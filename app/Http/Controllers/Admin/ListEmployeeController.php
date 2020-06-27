<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\WorkStatistic;
use Illuminate\Support\Facades\DB;



class ListEmployeeController extends Controller
{		
    public function index()
   	{
		$query = User::query();
		$total = $query->get()->count();
		if (request()->has('api') && request('api'))
		{
			if (request()->has('start') && request()->has('length') && request('length'))
			{
				try 
				{
					$currentPage = request('start') / request('length');
					$perPage = request('length') > 0 ? request('length') : config('app.page_size');
				} catch (Exception $ex) {
					$currentPage = 1;
					$perPage = config('app.page_size');
				}
				$filtered = false;
				if (request()->has('search') && request('search') && array_key_exists('value', request('search'))) 
				{
					$keyword = request('search')['value'];
					$query = $query->orWhere('username', 'like', "%$keyword%")
						->orWhere('email', 'like', "%$keyword%")
						->orWhere('phone_number', 'like', "%$keyword%");
					if ($keyword) {
						$filtered = true;
					}
				}

				$dictFields = [
					'0' => 'id',
					'1' => 'name',
					'2' => 'username',
					'3' => 'email',
					'4' => 'phone_number',
					'5' => 'position_name',
				];

				if (
					request()->has('order') && request('order') && count(request('order')) &&
					array_key_exists('column', request('order')[0]) && array_key_exists('dir', request('order')[0])
				) {
					$query = $query->orderBy($dictFields[request('order')[0]['column']], request('order')[0]['dir']);
				}

				$users = $query->skip($currentPage * $perPage)->take($perPage)->get();
				if (request()->has('draw') && request('draw') && is_numeric(request('draw'))) {
					$result['draw'] = request('draw') + 1;
				} else {
					$result['draw'] = 1;
				}
				$result['recordsTotal'] = $total;
				$result['recordsFiltered'] = $filtered ? count($users) : $total;

				$result['data'] = [];
				foreach ($users as $user)
				{
					$arrTmp = [];
					array_push($arrTmp, $user->id);
					array_push($arrTmp, $user->first_name . ' ' . $user->last_name);
					array_push($arrTmp, $user->username);
					array_push($arrTmp, $user->email);
					array_push($arrTmp, $user->phone_number);
					array_push($arrTmp, $user->position ? $user->position->name : null);
					array_push($result['data'], $arrTmp);
				}
					return $result;
			}
		}			
		return view('admin.list-employee',compact('total'));
	}

	public function show($id)
	{
		
		$query = WorkStatistic::query();
		$total = $query->where('user_id',$id)->get()->count();
		$users = User::find($id)->workstatistic()->distinct()->get();
		$name = User::find($id)->username;
		$total_time_work = $this->cal_total_time_work($id);
		$salary = $this->cal_salary($total_time_work, $id);
		return view('admin.check-in-out', compact('users', 'total_time_work', 'salary', 'name', 'total'));
	}

	/**
	 * Function calculate total work time.
	 */
	public function cal_total_time_work($id)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$today = date('Y-m-d', time());
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

	/**
	 * Function of calculating total salary.
	 */
	public function cal_salary($total_time_work, $id)
	{
		$real_salary = 0;
		$pos_id = User::find($id)->position_id;
		$salary_of_this_person = User::find($id)->salary;
		$pos_name = DB::table('positions')->where('id', $pos_id)->select('name')->get();
		if ($pos_name[0]->name == 'Interns')
			$real_salary = ($salary_of_this_person / 16) * $total_time_work;
		else
			$real_salary = ($salary_of_this_person / 26) * $total_time_work;
		return number_format($real_salary,0,',',' ');
	}

	/**
	 * Convert working hours to work.
	 */
	public function convert_time_to_work($time)
	{
		if ($time >= 6)
			return 1;
		elseif ($time > 4 && $time < 6)
			return 0.75;
		elseif ($time >= 3 && $time <= 4)
			return 0.5;
		elseif($time >= 1 && $time < 3)
			return 0.25;
		else
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

	public function create($id){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$today = date('Y-m-d', time());
		$current_time = date('H:i:s', time()); 
		$name = User::find($id)->username;
		return view('admin.create-employee', compact('id', 'name', 'today', 'current_time'));
	}

	public function store($id,Request $request){
		$user_id = $id;	
		$validate=$request->validate([
			'direction'=>'required|',
			'interactive_time'=>'required|',
			'interactive_time'=>'required',
		]);
		WorkStatistic::create(request(['user_id','direction','interactive_time','interactive_time']));
		return redirect("/admin/list-employee/$user_id/show");
	}

	public function edit($user_id, $id){
		$work = WorkStatistic::find($id);
		$name = User::find($user_id)->username;
		return view('admin.check-in-out-edit', compact('work', 'name', 'id'));
	}
	
	public function update(Request $request, $id){
		$works = WorkStatistic::find($id);
		$user_id = $works->user_id;
		$works->update(request(['direction','interactive_time','interactive_time']));
		return redirect("/admin/list-employee/$user_id/show");
	}
	
	public function destroy($user_id,$id){
		$work=WorkStatistic::find($id);
		$work->delete();
	}
}
