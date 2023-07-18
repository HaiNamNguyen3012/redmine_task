<?php

namespace App\Services\System\Stripe;

use App\Helpers\Helpers;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Subscription;
use Stripe\Token;

class StripeService
{
    private $stripePubKey;
    private $stripeSecretKey;
    private $stripeTax;
    private $client;

    public function __construct()
    {

    }

    /**
     * Init Stripe
     */
    public function keyStripe()
    {
        try {
            if (in_array(env('ENVIRONMENT_STRIPE'), ["local", "development"])) {
                $this->stripePubKey = env('STRIPE_DEV_PUBLISHABLE_KEY');
                $this->stripeSecretKey = env('STRIPE_DEV_SECRET_KEY');
                $this->stripeTax = env('STRIPE_DEV_SERVICE_TAX');
            }
            if (env('ENVIRONMENT_STRIPE') == 'production') {
                $this->stripePubKey = env('STRIPE_PRODUCTION_PUBLISHABLE_KEY');
                $this->stripeSecretKey = env('STRIPE_PRODUCTION_SECRET_KEY');
                $this->stripeTax = env('STRIPE_PRODUCTION_SERVICE_TAX');
            }

            //register stripe
            $stripe = new Stripe();
            $stripe::setApiKey($this->stripeSecretKey);
            $this->client = new StripeClient($this->stripeSecretKey);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Function register CustomerID
     */
    public function registerCustomerID($_data, $_user)
    {
        try {
            $error = __('layer.stripe.fail');

            //connect api stripe
            if (!$this->keyStripe()) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //register token
            $token = Token::create(
                [
                    'card' => [
                        'number' => $_data['card_number'],
                        'exp_month' => $_data['month'],
                        'exp_year' => $_data['year'],
                        'cvc' => $_data['card_cvc']
                    ]
                ]
            );
            if (empty($token->id)) return ResponseHelpers::serverErrorResponse([], '', $error);


            if (!empty($_user->customer_id)) {
                //update customer_id
                $customer = Customer::update(
                    $_user->customer_id,
                    [
                        'name' => @$_user->email ?? $_data['card_name'],
                        'source' => $token,
                    ]
                );
            } else {
                //register customer_id
                $customer = Customer::create(
                    [
                        'phone' => "",
                        'source' => $token->id,
                        'name' => @$_user->email ?? $_data['card_name'],
                        'metadata' => ['user_id' => !empty($_user->id) ? $_user->id : '', "is_account" => $_data['is_account']],
                    ]
                );
            }

            if (empty($customer->id)) return ResponseHelpers::serverErrorResponse([], '', $error);

            //success
            return ResponseHelpers::showResponse($customer->id, '');

        } catch (\Exception $e) {
            $message = __('layer.stripe.message.ex');
            return ResponseHelpers::serverErrorResponse([], 'array', $message);
        }
    }

    /**
     * Function charge capture = false
     * Params:
     * - price
     * - customer_id
     * - user_id
     * - teacher_id
     * - document_id
     */
    public function chargePayment($_data)
    {
        try {
            $error = __('layer.stripe.fail');

            //connect api stripe
            if (!$this->keyStripe()) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //check data
            if (!isset($_data['price']) || is_null($_data['price']) ||
                empty($_data['customer_id']) ||
                empty($_data['metadata'])) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //capture
            $stripeCharge = [
                "amount" => Helpers::formatPricePayment($_data['price'] + ($_data['price'] * config("sys_fee.vat"))),
                "currency" => 'jpy',
                "customer" => $_data['customer_id'],
                "capture" => false,
                "description" => !empty($_data['description']) ? $_data['description'] : "",
                "metadata" => $_data['metadata']
            ];

            $charge = Charge::create($stripeCharge);

            //return
            if (!empty($charge->id)) {
                return ResponseHelpers::showResponse(['charge_id' => $charge->id], 'array');
            } else {
                return ResponseHelpers::serverErrorResponse([], 'array', $error);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelpers::serverErrorResponse([], '', __('layer.stripe.message.ex'));
        }
    }

    /**
     * Function charge capture = true
     * Params:
     * - charge_id
     */
    public function chargeCaptureTrue($charge_id)
    {
        try {
            $error = __('layer.stripe.fail');

            //connect api stripe
            if (!$this->keyStripe()) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //change
            $charge = Charge::retrieve($charge_id);
            $charge->capture();

            //return
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelpers::serverErrorResponse([], '', __('layer.stripe.message.ex'));
        }
    }

    /**
     * Function charge capture = true
     * Params:
     * - charge_id
     */
    public function subscriptionStripe($_user, $_plan, $_data)
    {
        try {
            $error = __('layer.stripe.fail');

            //connect api stripe
            if (!$this->keyStripe()) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //subscription
            $stripSubscription = [
                "customer" => $_user->customer_id,
                "items" => array(
                    array(
                        "plan" => $_plan->payment_service_product_id,
                    ),
                ),
                'default_tax_rates' => [
                    $this->stripeTax
                ],
                'metadata' => $_data['metadata'],
                //'coupon' => $coupon,
                'trial_end' => $_data['trial_end']
            ];
            $subscription = Subscription::create($stripSubscription);

            //return
            if (!empty($subscription->id)) {
                return ResponseHelpers::showResponse(['subscription_id' => $subscription->id], 'array');
            } else {
                return ResponseHelpers::serverErrorResponse([], 'array', $error);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelpers::serverErrorResponse([], '', __('layer.stripe.message.ex'));
        }
    }

    /**
     * Function subscription cancel
     * Params:
     * - subscription_id
     */
    public function cancelSubscription($subscription_id)
    {
        try {
            $error = __('layer.stripe.fail');

            //connect api stripe
            if (!$this->keyStripe()) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //check subscription_id null
            if (!$subscription_id) return ResponseHelpers::serverErrorResponse([], 'array', $error);

            //calcel subscription
            $canceled_subscription = Subscription::retrieve($subscription_id)->delete();

            return $canceled_subscription;
        } catch (\Exception $e) {
            return false;
        }
    }

}
