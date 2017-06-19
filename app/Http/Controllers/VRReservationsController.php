<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesTranslations;
use App\Models\VRReservations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class VRReservationsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function displays all Reservations existing in data base
     */
    public function adminIndex()
    {
        $configuration = (new VRReservations())->getFillableAndTableName();
        array_unshift($configuration['fields'], 'id');

        $configuration['message'] = Session()->get('message');

        $configuration['list_data'] = VRReservations::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date, $addWhat, $value, $dateFormat)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->$addWhat($value)) {
            $dates[] = $date->format($dateFormat);
        }

        return $dates;
    }

    public function adminCreate($date_from_url = null, $message = null)
    {
        if ($date_from_url == null) {
            $date_from_url = Carbon::today()->toDateString();
        }

        $shopOpenTime = Carbon::today()->addHours(11);
        $shopCloseTime = Carbon::today()->addHour(21)->addMinute(50);

        $shopOpenTime2 = Carbon::today()->addHours(11);
        $shopCloseTime2 = Carbon::today()->addHour(21)->addMinute(50);

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(13);

        $timeNow = Carbon::now(+2)->addHours(1);

        $allOneDayWorkingTimes = $this->generateDateRange($shopOpenTime2, $shopCloseTime2, 'addMinutes', 10, 'Y-m-d H:i');

        $disabledTimes = [];
        $enabledTimes = [];

        foreach ($allOneDayWorkingTimes as $time) {

            if($timeNow <= $time) {
                array_push($enabledTimes, substr($time, 11));
            } else {
                array_push($disabledTimes, substr($time, 11));
            }
        }

        $configuration = (new VRReservations())->getFillableAndTableName();
        $configuration['message'] = $message;
        $configuration['date_from_url'] = $date_from_url;

        $configuration['shop_working_times'] = $this->generateDateRange($shopOpenTime, $shopCloseTime, 'addMinutes', 10, 'H:i');
        $configuration['order_days'] = $this->generateDateRange($startDate, $endDate, 'addDays', 1, 'Y-m-d');
        $configuration['enabledTimes'] = $enabledTimes;
        $configuration['disabledTimes'] = $disabledTimes;
        $configuration['today'] = Carbon::today()->toDateString();

        $configuration['categories'] = VRPagesCategories::with(['pages'])->get()->toArray();
        $configuration['reservations'] = VRReservations::get()->toArray();

//        dd($configuration);

        return view('admin.reservation', $configuration);
    }


    public function adminStore()
    {
        $timesReserved = VRReservations::pluck('time', 'pages_id');

        $data = request()->all();
        unset($data['_token']);

        $message = '';

        if($data == null)
        {
            $message = 'Bitte machen reservierung!';
        }

        if($timesReserved != []) {

            foreach ( $data as $key => $value ) {

                foreach ( $timesReserved as $timesKey => $timesValue ) {

                    if ( $key == $timesKey and $value == $timesValue ) {
                        $message = 'Time already taken';
                        break;

                    }
                }
            }
        }

            if(!strlen($message) > 0){

                $order = VROrders::create([
                    'status' => 'active'
                ]);

            foreach ($data as $key => $value) {

                VRReservations::create([

                    'time' => $value,
                    'pages_id' => $key,
                    'orders_id' => $order['id']

                ]);

                $message = 'Time reserved successfully!';

            }

            } else {

                return $this->adminCreate(null, $message);
            }

        return $this->adminCreate(null, $message);
    }

    public function adminDestroy($id)
    {
        if (VRReservations::destroy($id)) {

            return json_encode(["success" => true, "id" => $id]);

        }
    }

}
