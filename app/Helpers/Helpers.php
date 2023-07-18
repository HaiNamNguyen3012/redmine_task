<?php

namespace App\Helpers;

use App\Models\Page;
use App\Services\User\ProjectService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use PDF;

class Helpers
{
    public static function pre($data = array())
    {
        echo '<pre>';
        print_r($data);
        die;
    }

    public static function substring($str, $start, $length)
    {
        return substr($str, $start, $length);
    }

    public static function renderCode()
    {
        return substr(str_shuffle(str_repeat("0123456789", 6)), 0, 6);
    }


    public static function paginate($_items, $_perPage, $_page = null, $_options = [])
    {
        $page = $_page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $_items instanceof Collection ? $_items : Collection::make($_items);
        return new LengthAwarePaginator($items->forPage($_page, $_perPage), $items->count(), $_perPage, $_page, $_options);
    }

    public static function metaHead($data)
    {
        return array(
            'title_seo' => !empty($data->title_seo) ? $data->title_seo : (!empty($data["title"]) ? $data["title"] : (!empty($data->name) ? $data->name : '')),
            'meta_key' => !empty($data->meta_key) ? $data->meta_key : (!empty($data["title"]) ? $data["title"] : (!empty($data->name) ? $data->name : '')),
            'meta_des' => !empty($data->meta_des) ? Helpers::shortDesc($data->meta_des, 150) : ""
        );
    }

    public static function checkPermissionUser($data, $route)
    {
        if (!empty($data) && !empty($route)) {
            foreach ($data as $row) {
                if (!empty($row->permission->permission_list)) {
                    $per = @json_decode($row->permission->permission_list, true);
//                    Helpers::pre($per);
                    if (in_array($route, $per)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function redirectPer()
    {
        return abort(403, 'Unauthorized action.');
    }

    public static function renderInfoUser($user)
    {
        if (!empty($user->name)) {
            return $user->name;
        } elseif (!empty($user->email)) {
            return $user->email;
        }
        return "";
    }

    public static function getWeekday($date)
    {
        return date('l', $date);
    }

    public static function dayInMonth($m, $y)
    {
        return date("t", strtotime($y . "-" . $m . "-" . "01 23:59:59"));
    }

    public static function taskPoint($task, $data, $point)
    {
        //define
        $start_date_y = !empty($task["start_date"]) ? (int)date("Y", strtotime($task["start_date"] . " 23:59:59")) : "";
        $start_date_m = !empty($task["start_date"]) ? (int)date("m", strtotime($task["start_date"] . " 23:59:59")) : "";
        $start_date_d = !empty($task["start_date"]) ? (int)date("d", strtotime($task["start_date"] . " 23:59:59")) : "";
        $end_date_y = !empty($task["end_date"]) ? (int)date("Y", strtotime($task["end_date"] . " 23:59:59")) : "";
        $end_date_m = !empty($task["end_date"]) ? (int)date("m", strtotime($task["end_date"] . " 23:59:59")) : "";

        //start
        $point_start = ($start_date_m == $data["month"]) ? $start_date_d : 1;
        $task["point_start"] = $point_start;

        //end
        if (empty($task["end_date"])) {
            $task["point_end"] = Helpers::dayInMonth($data["month"], $data["year"]);
        } else {
            if ($end_date_m == $data["month"]) {
                $task["point_end"] = (int)date("d", strtotime($task["end_date"]));
            } else {
                $task["point_end"] = Helpers::dayInMonth($data["month"], $data["year"]);
            }
        }

        return $task[$point];
    }

    public static function colorRandom()
    {
        $arr = ['#000000', '#677DFF', '#FFA41D', '#009320', '#EB7F39', '#F151C3', '#F15151', '#DBDF07', '#00DFD2', '#F5129B', '#AF143A', '#F4A460', '#63CDAA', '#800080', '#7E4A3F'];
        return $arr[array_rand($arr)];
    }

    public static function txtRandom($rd = false)
    {
        $arrColor = ['DBDF07', '00DFD2', 'F5129B', 'AF143A', 'F4A460', '63CDAA', '800080', '7E4A3F'];
        return $rd ? $arrColor : $arrColor[array_rand($arrColor)];
    }

    public static function formatDateTime($format, $date)
    {
        return $date ? date($format, strtotime($date)) : '';
    }

    public static function calPricePlan($price, $data)
    {
        //define
        $price_day = $price / 30;
        $time = $data["time"];
        $fm_day = 1 + (date("d", strtotime("-1 day", strtotime("+1 month", strtotime(date("Y-m", $time) . "-01 00:00:00")))) - date("d", $time));

        //return
        $data = [
            "first_month" => $fm_day * $price_day,
            "next_month" => $price,
        ];
        $data["vat"] = ($data["first_month"] + $data["next_month"]) * 0.1;
        $data["total"] = $data["first_month"] + $data["next_month"] + $data["vat"];

        //start, end
        $data["date"] = [
            "first_start" => date("Y-m-d H:i:s", $time),
            "first_end" => date("Y-m", $time) . "-" . date("d", strtotime("-1 day", strtotime("+1 month", strtotime(date("Y-m", $time) . "-01 00:00:00")))) . " 23:59:59",
            "second_start" => date("Y-m", strtotime("+1 month", strtotime(date("Y-m", $time) . "-01 00:00:00"))) . "-01 00:00:00",
            "second_end" => "",
        ];
        $data["date"]["second_end"] = date("Y-m-d H:i:s", strtotime("-1 day", strtotime("+1 month", strtotime(date("Y-m", strtotime($data["date"]["second_start"])) . "-01 23:59:59"))));

        return $data;
    }

    public static function formatPricePayment($price)
    {
        $number = explode(".", (string)$price);
        $price = count($number) == 1 ? $price : ceil($price);

        return (int)$price;
    }

    public static function planShowExpired($data)
    {
        $result = [
            "time" => "",
            "is_expire" => (count($data["plan_bought"]) > 0) ? true : false,
            "plan_bought_by_time" => count($data["plan_bought_by_time"]),
            "project_count" => $data["project_count"],
        ];
        foreach ($data["plan_bought"] as $row) {
            $result["time"] = date("Y", strtotime($row->end_date)) . "年" . date("m", strtotime($row->end_date)) . "月";
            $result["is_expire"] = (strtotime($row->end_date) > time()) ? false : true;
            break;
        }

        //is_create
        $project_create = false;
        if ($result["project_count"] == 0)
            $project_create = true;
        elseif ($result["project_count"] > 0 && $result["plan_bought_by_time"] == 0)
            $project_create = false;
        elseif ($result["plan_bought_by_time"] > 0)
            $project_create = true;
        elseif ($result["project_count"] > 0 && $result['is_expire'])
            $project_create = false;
        else
            $project_create = false;

        $result["is_create_project"] = $project_create;

        return $result;
    }

    public static function checkProjectIsUser($permission_list, $user_id)
    {
        $flag = false;
        $arr = [];
        foreach ($permission_list as $row) {
            $arr[] = $row->user_id;
        }
        return (!in_array($user_id, $arr)) ? false : true;
    }
}
