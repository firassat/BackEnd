<?php

namespace App\Http\Controllers\Api;

use http\Message;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use App\Models\BookedTime;
use App\Http\Controllers\Controller;
use App\Models\Expert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TimeController extends Controller
{
    public function availableTimeCreate(Request $request)
    {
        //فحص اذا كان الوقت مضاف
        $info = Expert::where('users_id', auth()->user()->id)->first();
        $expertTime = DB::table('available_times')->where('expert_id', $info->id)->get();

        foreach ($expertTime as $i) {
            if ($i->day_id == $request->day_id) {
                $startTime = date('H:i', strtotime($i->time_from));
                $endTime = date('H:i', strtotime($i->time_to));
                while ($startTime <= $endTime)
                {
                    $startTime2 = date('H:i', strtotime($request->from));
                    $endTime2 = date('H:i', strtotime($request->to));

                    while ($startTime2 <= $endTime2)
                    {
                        if($startTime == $startTime2)
                        {
                            return response()->json([
                                'status' => false,
                                'message' => trans('message.timeisAdd'),
                            ], 200);
                        }
                        $startTime2 = date('H:i', strtotime(Carbon::parse($startTime2)->addHour()));
                        if ($startTime2 == date('H:i', strtotime('00:00')))
                            break;
                    }
                        $startTime = date('H:i', strtotime(Carbon::parse($startTime)->addHour()));
                        if ($startTime == date('H:i', strtotime('00:00')))
                            break;
                }
            }
        }
        $validateUser = Validator::make($request->all(),
            [
                'from' => 'required',
                'to' => 'required',
                'day_id' => 'required|integer|min:1|max:7',
            ]);
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => trans('message.ve'),
                'errors' => $validateUser->errors()
            ], 200);
        }
        AvailableTime::create([
            'expert_id' => $info->id,
            'time_from' => $request->from,
            'time_to' => $request->to,
            'day_id' => $request->day_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => trans('message.timeS'),
        ], 200);
    }
    public function availableTimeUpdate(Request $request)
    {
        $info = Expert::where('users_id', auth()->user()->id)->first();
        $time_old = AvailableTime::find($request->time_old_id);

        if ($time_old->expert_id == $info->id) {
            $validateUser = Validator::make($request->all(),
                [
                    'from' => 'required',
                    'to' => 'required',
                    'day_id' => 'required|integer|min:1|max:7',
                ]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => trans('message.ve'),
                    'errors' => $validateUser->errors()
                ], 200);
            }

            $time_old->time_from = $request->from;
            $time_old->time_to = $request->to;
            $time_old->day_id = $request->day_id;
            $time_old->save();

            return response()->json([
                'status' => true,
                'message' => trans('message.timeS'),
            ], 200);
        } else
            return response()->json([
                'status' => false,
                'message' => trans('message.NA'),
            ], 200);
    }
    public function availableTimeDelete(Request $request)
    {
        $info = Expert::where('users_id', auth()->user()->id)->first();
        $time_old = AvailableTime::find($request->time_old_id);

        if($time_old == null){
            return response()->json([
                'status' => false,
                'message' => trans('message.timeNF'),
            ], 200);
        }
        if ($time_old->expert_id == $info->id) {
            $time_old->delete();
            return response()->json([
                'status' => true,
                'message' => trans('message.timeDS'),
            ], 200);
        } else
            return response()->json([
                'status' => false,
                'message' => trans('message.NA'),
            ], 200);
        }
    public function availableTimeForMe()
    {
        $info = Expert::where('users_id', auth()->user()->id)->first();
        $times = AvailableTime::where('expert_id', $info->id)->get();

        return $times;


    }
    public function availableTimeForExpert(Request $request)
    {
        $expertTime = DB::table('available_times')->where('expert_id', $request->expert_id)->get();
        $bookedTime = DB::table('booked_times')->where('expert_id', $request->expert_id)->get();
        $allNewDate = collect([]);
        $newDate1 = collect([]);
        $newDate = collect([]);
        for ($day = 1; $day < 8; $day += 1) {
            foreach ($expertTime as $i) {
                if ($i->day_id == $day) {
                    //  $newDate->push(['day_id'=>$day]);
                    $startTime = date('H:i', strtotime($i->time_from));
                    $endTime = date('H:i', strtotime($i->time_to));
                    $sunBooked = $bookedTime->where('day_id', $day);
                    $time2 = $startTime;

                    while ($time2 <= $endTime) {
                        $aa = true;
                        if (count($sunBooked) > 0) {
                            foreach ($sunBooked as $j) {
                                $time = date('H:i', strtotime($j->time));
                                if ($time == $time2) {
                                    $aa = false;
                                    break;
                                }
                            }
                        }
                        if ($aa)
                            $newDate1 = $newDate->push([$time2])->collapse();
                        $time2 = date('H:i', strtotime(Carbon::parse($time2)->addHour()));
                        if ($time2 == date('H:i', strtotime('00:00')))
                            break;
                    }
                }
            }
            $allNewDate->push($newDate1);
            $newDate1 = collect([]);
            $newDate = collect([]);
        }
        return $allNewDate->all();
    }
    public function bookedTimeCreate(Request $request)
    {
        //delete old date
        $lastDate=  date('Y-m-d', strtotime('-1 week'));
        DB::table('booked_times')->where('created_at','<',$lastDate)->delete();

        $time = date('H:i', strtotime($request->time));
        $validateUser = Validator::make($request->all(),
            [
                'time' => 'required',
                'expert_id' => 'required',
                'day_id' => 'required|integer|min:1|max:7',
            ]);
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'message.ve',
                'errors' => $validateUser->errors()
            ], 200);
        }
        $newTime = TimeController::availableTimeForExpert($request)[$request->day_id - 1];
        foreach ($newTime as $i) {
            if ($i == $time) {
                $expert = Expert::find($request->expert_id);

                if(auth()->user()->cash >= $expert->price){
                    $expert->user->cash += $expert->price;
                    auth()->user()->cash -=  $expert->price;
                    auth()->user()->save();
                    $expert->user->save();
                    BookedTime::create([
                        'user_id' => auth()->user()->id,
                        'expert_id' => $request->expert_id,
                        'time' => $request->time,
                        'day_id' => $request->day_id,
                    ]);
                    return response()->json([
                        'status' => true,
                        'message' => 'message.timeS',
                    ], 200);
                }
            }
        }
        return response()->json([
            'status' => false,
            'message' => trans('message.timeF'),
        ], 200);
    }
    public function bookedTimeShow()
    {
        $info = Expert::where('users_id', auth()->user()->id)->first();
        return BookedTime::where('expert_id',$info->id)->get();
    }
}
