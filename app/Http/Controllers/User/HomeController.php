<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Statistic;
use App\Setting;
use App\WorkSchedule;
use App\BookingTimeOff;
use App\User;
use Illuminate\View\View;
use App\WorkStatistic;
use App\AppConstants;
use Carbon\Carbon;
use App\TimeOffType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\SupportUtils;
use Gumlet\ImageResize;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function home()
	{
		$user_id = auth()->user()->id;
		$workSchedules = WorkSchedule::where('user_id',$user_id)->get();
		if(count($workSchedules) <= 0){
			return View('user.create');
		}
		
		$id = Auth::user()->id;
		$Array = [];
		$schedule = $this->create_schedule();
		$check_schedule = $this->text_schedule();
		$work_time = $this->calculateTimeWork($id);
		$salary = $this->calculateSalary($id);
		return View('user.check-schedule',compact('schedule','Array','check_schedule','work_time','salary'));
	}

	public function createPost(Request $res){
		// dd($res);
		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Monday';
		$model->work_time = $res->T2;
		$model->save();

		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Tuesday';
		$model->work_time = $res->T3;
		$model->save();

		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Wednesday';
		$model->work_time = $res->T4;
		$model->save();

		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Thursday';
		$model->work_time = $res->T5;
		$model->save();

		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Friday';
		$model->work_time = $res->T6;
		$model->save();

		$model = new WorkSchedule();
		$model->user_id = auth()->user()->id;
		$model->kind_of_day = 'Saturday';
		$model->work_time = $res->T7;
		$model->save();
		return back();
	}
	
	public function cal_total_time_work($id)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$today = date('Y-m-d', time());
		//dd($today);
		$current_time = date('H:i:s', time()); 
		$dates = DB::table('work_statistics')->distinct()->where('user_id',$id)->select('interactive_time')->get();
		$total_time_work = 0;
		foreach ($dates as $date)
		{
			$time_work_1_day = 0;
			$time_work_to_day = 0;
			$times = DB::table('work_statistics')->select('interactive_time')->where('user_id', $id)->where('interactive_time', $date->interactive_time)->get();
			$directions = DB::table('work_statistics')->select('direction')->where('user_id', $id)->where('interactive_time', $date->interactive_time)->get();
			$length = count($times);
			if ($length > 1 && $date->interactive_time != $today){
				for ($i = 0; $i < $length; $i+=2){
					if ($i > $length-1)
						break;
					elseif ($directions[0]->direction == 'out')
						continue;
					elseif ($directions[$length-1]->direction == 'in')
						continue;
					elseif ($directions[$i]->direction == 'in' && $directions[$i+1]->direction == 'out')
						$time_work_1_day +=  $this->cal_working_hours($times[$i]->interactive_time, $times[$i+1]->interactive_time);
					elseif ($directions[$i]->direction == 'out' && $directions[$i-1]->direction == 'in')
						$time_work_1_day +=  $this->cal_working_hours($times[0]->interactive_time, $times[$i]->interactive_time);
				}							 
			}

			// Calculate the working hours of today
			if ($date->interactive_time == $today){
				if ($length > 1)
					for ($i = 0; $i < $length; $i+=2){
						if ($i > $length-1)
							break;
						elseif ($directions[0]->direction == 'out')
							continue;
						elseif ($directions[$length-1]->direction == 'in'){
							$time_work_to_day += $this->cal_working_hours($times[$length-1]->interactive_time, $current_time);
							continue;
						}
						elseif ($directions[$i]->direction == 'in' && $directions[$i+1]->direction == 'out')
							$time_work_to_day +=  $this->cal_working_hours($times[$i]->interactive_time, $times[$i+1]->interactive_time);
						elseif ($directions[$i]->direction == 'out' && $directions[$i-1]->direction == 'in')
							$time_work_to_day +=  $this->cal_working_hours($times[0]->interactive_time, $times[$i]->interactive_time);
					}								  
				else
					$time_work_to_day =  $this->cal_working_hours($times[0]->interactive_time, $current_time);
			}
			$total_time_work += (self::convert_time_to_work($time_work_1_day) + self::convert_time_to_work($time_work_to_day)); // Convert actual working hours a day, then accumulate by day
		}       
		return $total_time_work;
	}

	public static function calculateSalary($id){
        // Get time work
        $timeWork = HomeController::calculateTimeWork($id);
        // Get time off
        $timeOff = HomeController::calculateTimeOff($id);
        // Salary per day
        $user = User::find($id);
        $daysInMonth = $user->position_id == AppConstants::$position_intern ?
                        Carbon::now()->daysInMonth / 2 : Carbon::now()->daysInMonth;
        $salaryPerDay = $user->salary / $daysInMonth;
        // Time work in this month
        $timeResult = $timeWork - $timeOff;
        $dayWork = $timeResult / 24;
        // Salary this month
        $salary = number_format(round($salaryPerDay * $dayWork,3));

        // Return
        return $salary;
    }

    public static function calculateTimeWork ($id){
        // Check position director and mangager
        $isCheckPosition = SupportUtils::checkPosition($id);
        if($isCheckPosition){
            // Current day
            $day = Carbon::now()->day;
            // Convert to hours
            $hours = $day * 24;

            // Return
            return $hours;
        }

        // Get list the work statistic list of the user for this month
        $currenthMonth = Carbon::now()->month;
        $total_time = 0;
        $workstatistics = WorkStatistic::where('user_id',$id)->whereRaw('MONTH(interactive_time)= ?',[$currenthMonth])->get();
        for($i=0;$i<count($workstatistics);$i++){
            // Current has in and has out
            if(isset($workstatistics[$i+1])){
                // Exist in and out
                if($workstatistics[$i]->direction == 'in' && $workstatistics[$i+1]->direction == 'out'||
                    $workstatistics[$i]->direction == 'out' && $workstatistics[$i+1]->direction == 'in'
                )
                {
                    // Get time in
                    $time_start = strtotime($workstatistics[$i]->interactive_time);
                    // Get time out
                    $time_finish = strtotime($workstatistics[$i+1]->interactive_time);
                    // Calculate
                    $result = $time_finish - $time_start;
                    // Convert to hours
                    $total_time+= $result/(60*60);
                }
            }
        }

        // Return
        return round($total_time,2);
    }

    public static function calculateTimeOff($id){
        $totalTimeOff = 0;
        // Current month
        $currenthMonth = Carbon::now()->month;
        // Get data: The reason is accrept in this month
        $timeOff = BookingTimeOff::where([
            ['user_id','=',$id],
            ['approval_type_id','=',AppConstants::$approvalTypeAccept]
        ])->whereRaw('MONTH(booking_day)= ?',[$currenthMonth])->get();

        foreach($timeOff as $key => $value){
            // Off full a day
            if($value->day_off_type == AppConstants::$full){
                if($value->time_off_type_id == AppConstants::$typePTO ||
                    $value->time_off_type_id == AppConstants::$typeHoliday
                ){
                    // DTO or Holiday
                    $totalTimeOff += 0;
                }else{
                    $totalTimeOff += AppConstants::$hoursWorkADay;
                }
            }else{
                // Off half a day
                $totalTimeOff += AppConstants::$hoursWorkADay / 2;
            }
        }
        return $totalTimeOff;
    }

	public function cal_salary($total_time_work, $id)
	{
		$real_salary = 0;
		$pos_id = User::find($id)->position_id;
		$salary_of_this_person = User::find($id)->salary;
		$pos_name = DB::table('positions')->where('id', $pos_id)->select('name')->get();
		// dd($pos_name);

		if ($pos_name[0]->name == 'Interns')
			$real_salary = ($salary_of_this_person / 16) * $total_time_work;
		else
			$real_salary = ($salary_of_this_person / 26) * $total_time_work;
		return number_format($real_salary,0,',',' ');
	}

	public function convert_time_to_work($time)
	{
		if ($time >= 6)
			return 1;
		elseif ($time > 4 && $time < 6)
			return 0.75;
		elseif ($time >= 3 && $time <= 4)
			return 0.5;
		elseif($time >= 1 && $time < 3)
			return 0;
	}

	/**
	 * Calculate the actual hours worked a day.
	 */
	public function cal_working_hours($time_in, $time_out)
	{
		if ($time_in < '08:30:00')
			$time_in = '08:30:00';
		$excess_time_in = strtotime('13:30:00') - strtotime($time_in); // Use this variable when checking in after 12:00 to 13:30
		$excess_time_out = strtotime($time_out) - strtotime('12:00:00'); //  Use this variable when checking out after 12:00 to 13:30
		$temp = strtotime($time_out) - strtotime($time_in);
		if ($time_out <= '12:00:00' || $time_in >= '13:30:00')	  // Work in morning or afternoon and do not check in / out during lunch break
			$time_work_1_day = $temp / 3600;
		elseif ($time_out > '12:00:00' && $time_out < '13:30:00') // Work in the morning and check out during lunch break
			$time_work_1_day = ($temp - $excess_time_out) / 3600;
		elseif ($time_in > '12:00:00' && $time_in < '13:30:00')	  // Check in during lunch break and work in the afternoon
			$time_work_1_day = ($temp - $excess_time_in) / 3600;
		else													  // Work all day
			$time_work_1_day = $temp / 3600 - 1.5;
		return $time_work_1_day;
	}

	public function bookingTimeOff(){
		$types = TimeOffType::all();
		return view('user.booking-time-off',compact('types'));
	}

	public function bookingCreatePost(Request $res){
		$model = new BookingTimeOff();
		$model->user_id = auth()->user()->id;
		$model->booking_day = $res->date;
		$model->time_off_type_id = $res->day_off_type;
		$model->reason = $res->resson;
		$model->save();
		return back();
	}


	// Ham Work Time
	public function create_schedule()
	{
		$id = Auth::user()->id;
		$workSchedules = DB::table('work_schedules')->where('user_id',$id)->get();
		// dd($workSchedules);
		$user = User::find($id);
		$result['fullName'] = $user->first_name . ' ' . $user->last_name;

		foreach($workSchedules as $workSchedule)
		{
			switch ($workSchedule->kind_of_day) {
			 	case 'Monday':
					$result['t2'] = $workSchedule->work_time;
			 		break;

			 	case 'Tuesday':
			 		$result['t3'] = $workSchedule->work_time;
			 		break;

			 	case 'Wednesday':
			 		$result['t4'] = $workSchedule->work_time;
			 		break;

			 	case 'Thursday':
			 		$result['t5'] = $workSchedule->work_time;
			 		break;

			 	case 'Friday':
			 		$result['t6'] = $workSchedule->work_time;
			 		break;

			 	case 'Saturday':
			 		$result['t7'] = $workSchedule->work_time;
			 		break;
			 	
			 	default:
			 		# code...
			 		break;
			};
		}
		return $result;
	}

	// Ham Check Work Time
	public function text_schedule()
	{
		$id = Auth::user()->id;
		$workStatistics = DB::table('work_statistics')->where('user_id',$id)->get();
		$user = User::find($id);
		$result['fullName'] = $user->first_name . ' ' . $user->last_name;

		foreach($workStatistics as $workStatistic)
		{	
			switch ($workStatistic->interactive_time) {
			case 'value':
				# code...
				break;
			
			default:
				# code...
				break;
			}
			switch ($workStatistic->direction) {
			 	case 'in':
					$result['in'] = $workStatistic->interactive_time;
			 		break;

			 	case 'out':
			 		$result['out'] = $workStatistic->interactive_time;
			 		break;
			 			 	
			 	default:
			 		# code...
			 		break;
			};
		}
		return $result;
		// $Array =[];
		// foreach($Array_check_schedule as $row)
		// {
		// 	$user_ = DB::table('users')->find($row->user_id);
		// 	$item = array("user_id" =>$user_->id , "first_name" =>$user_->first_name .' '. $user_->last_name, "last_name" =>$user_->last_name);
		// 	$array_current = DB::table('work_statistics')->where('user_id',$row->user_id)->get();
		// 	foreach($array_current as $row_)
		// 	{
		// 		array_unshift($item,$row_->interactive_time);
		// 	}
		// 	array_unshift($Array,$item);
		// }
		// return $Array;
	}

	//Chuong
	public function create()
	{
		return View ('user.create');
	}
}
