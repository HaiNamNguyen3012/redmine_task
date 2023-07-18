<?php

namespace App\Services\User;

use App\Helpers\Helpers;
use App\Jobs\planPayment;
use App\Jobs\planPaymentFail;
use App\Repositories\System\Plan\PlanRepositoryInterface;
use App\Services\System\Stripe\StripeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanService
{
    private $repository;
    private $stripe;
    private $planUserBoughtService;
    private $userService;

    public function __construct(PlanRepositoryInterface $repository,
                                StripeService $stripe,
                                UserService $userService,
                                PlanUserBoughtService $planUserBoughtService)
    {
        $this->repository = $repository;
        $this->planUserBoughtService = $planUserBoughtService;
        $this->userService = $userService;
        $this->stripe = $stripe;
    }

    public function checkBoughtNow($id)
    {
        $data = $this->planUserBoughtService->getSecondLastBought(["user_id" => Auth::guard(config("sys_auth.user"))->user()->id]);
    }

    public function get($data)
    {
        return $this->repository->get($data);
    }

    public function findById($id, $data)
    {
        return $this->repository->findById($id, $data);
    }

    public function payPlan($data)
    {
        try {
            $data["user"] = Auth::guard(config("sys_auth.user"))->user();
            $this->userService->update($data["user"]->id, ["is_bought" => 0]);
            planPayment::dispatch($data)->delay(now()->addSecond(2));
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function payment($data)
    {
        DB::beginTransaction();
        try {
            //define
            $plan_price = Helpers::calPricePlan($data["plan"]->price, ["time" => time()]);
            $charge_ids = [];
            $flag = true;

            //first payment
            $meta_data = [
                "user_id" => $data["user"]->id,
                "plan_id" => $data["plan"]->id,
                "payment_type" => "First payment"
            ];

            $pay_first = [
                "price" => $plan_price["first_month"],
                "customer_id" => $data["user"]->customer_id,
                "metadata" => $meta_data,
                //"description" => $des,
            ];

            $res = $this->stripe->chargePayment($pay_first);
            if ($res["meta"]["status"] == 200) {
                $charge_ids[] = $res["response"]["charge_id"];

                //update cart_item
                if (!$this->planUserBoughtService->store([
                    "user_id" => $data["user"]->id,
                    "plan_id" => $data["plan"]->id,
                    "price" => $plan_price["first_month"],
                    "start_date" => $plan_price["date"]["first_start"],
                    "end_date" => $plan_price["date"]["first_end"],
                    "charge_id" => $res["response"]["charge_id"],
                ])) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }

            //second payment
            $meta_data = [
                "user_id" => $data["user"]->id,
                "plan_id" => $data["plan"]->id,
                "payment_type" => "Second payment"
            ];

            $pay_second = [
                "price" => $plan_price["next_month"],
                "customer_id" => $data["user"]->customer_id,
                "metadata" => $meta_data,
                //"description" => $des,
            ];

            $res = $this->stripe->chargePayment($pay_second);
            if ($res["meta"]["status"] == 200) {
                $charge_ids[] = $res["response"]["charge_id"];

                //update cart_item
                if (!$this->planUserBoughtService->store([
                    "user_id" => $data["user"]->id,
                    "plan_id" => $data["plan"]->id,
                    "price" => $plan_price["next_month"],
                    "start_date" => $plan_price["date"]["second_start"],
                    "end_date" => $plan_price["date"]["second_end"],
                    "charge_id" => $res["response"]["charge_id"],
                ])) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }

            //create subscription
            $sub_data["trial_end"] = strtotime(date("Y-m", strtotime("+1 day", strtotime($plan_price["date"]["second_end"]))) . "-01 00:00:00");
            //$sub_data["trial_end"] = strtotime(date("Y-m-d", strtotime("+1 day", time())) . " 00:00:00");
            $sub_data["metadata"] = [
                "user_id" => $data["user"]->id,
                "plan_id" => $data["plan"]->id,
                "payment_type" => "Subscription payment"
            ];
            $res = $this->stripe->subscriptionStripe($data["user"], $data["plan"], $sub_data);
            $subscription_id = "";
            if ($res["meta"]["status"] == 200) {
                $subscription_id = $res["response"]["subscription_id"];
            } else {
                $flag = false;
            }

            //save plan_id
            if ($flag) {
                if (!$this->userService->update($data["user"]->id, ["plan_id" => $data["plan"]->id, "is_bought" => 1, "payment_service_plan_subscription_id" => $subscription_id])) {
                    $flag = false;
                }
            }

            //result
            if ($flag) {
                DB::commit();
                //change capture
                foreach ($charge_ids as $charge_id) {
                    $this->stripe->chargeCaptureTrue($charge_id);
                }

                return true;
            }

            DB::rollBack();

            //save payment_fail
            planPaymentFail::dispatch($data)->delay(now()->addSecond(2));

            return false;
        } catch (\Exception $ex) {
            Log::info("planPayment: " . $ex->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function paymentFail($data)
    {
        DB::beginTransaction();
        try {
            if ($this->userService->update($data["user"]->id, ["plan_id" => $data["plan"]->id, "is_bought" => 2])) {
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Exception $ex) {
            Log::info("planPaymentFail: " . $ex->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function planCancelSub($data)
    {
        DB::beginTransaction();
        try {
            //define
            $flag = true;

            $data["user"] = Auth::guard(config("sys_auth.user"))->user();
            if (!$this->userService->update($data["user"]->id, ["plan_id" => $data["plan"]->id, "payment_service_plan_subscription_id" => ""])) {
                $flag = false;
            }

            //result
            if ($flag) {
                $this->stripe->cancelSubscription($data["user"]->payment_service_plan_subscription_id);
                DB::commit();
                return true;
            }

            DB::rollBack();
            return false;
        } catch (\Exception $ex) {
            Log::info("planCancelSub: " . $ex->getMessage());
            DB::rollBack();
            return false;
        }
    }

}
