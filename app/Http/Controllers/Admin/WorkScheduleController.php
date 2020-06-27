<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkSchedule;
use App\User;
use Illuminate\Support\Facades\View;

class WorkScheduleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = User::query();
		$total = $query->get()->count();

		if (request()->has('api') && request('api')) {
			if (request()->has('start') && request()->has('length') && request('length')) {
				try {
					$currentPage = request('start') / request('length');
					$perPage = request('length') > 0 ? request('length') : config('app.page_size');
				} catch (Exception $ex) {
					$currentPage = 1;
					$perPage = config('app.page_size');
				}

				$filtered = false;
				if (request()->has('search') && request('search') && array_key_exists('value', request('search'))) {
					$keyword = request('search')['value'];
					$query = $query->orWhere('username', 'like', "%$keyword%")
						->orWhere('first_name', 'like', "%$keyword%")
						->orWhere('last_name', 'like', "%$keyword%");

					if ($keyword) {
						$filtered = true;
					}
				}
				$dictFields = [
					'0' => 'id',
					'1' => 'name',
					'2' => 'T2',
					'3' => 'T3',
					'4' => 'T4',
					'5' => 'T5',
					'6' => 'T6',
					'7' => 'T7',

				];

				$users = $query->skip($currentPage * $perPage)->take($perPage)->get();

				if (request()->has('draw') && request('draw') && is_numeric(request('draw'))) {
					$result['draw'] = request('draw') + 1;
				} else {
					$result['draw'] = 1;
				}
				$result['recordsTotal'] = $total;
				$result['recordsFiltered'] = $filtered ? count($users) : $total;

				$result['data'] = [];
				foreach ($users as $user) {
					$arrTmp = [];
					array_push($arrTmp, $user->id);
					array_push($arrTmp, $user->first_name." ".$user->last_name);
					//T2
					$schedule = $user->workSchedule->where('kind_of_day','like','Monday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);
					//T3

					$schedule = $user->workSchedule->where('kind_of_day','like','Tuesday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);
					//T4

					$schedule = $user->workSchedule->where('kind_of_day','like','Wednesday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);
					//T5

					$schedule = $user->workSchedule->where('kind_of_day','like','Thursday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);
					//T6

					$schedule = $user->workSchedule->where('kind_of_day','like','Friday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);
					//T7

					$schedule = $user->workSchedule->where('kind_of_day','like','Saturday');
					if ($schedule->isEmpty())
					{
						$workTime="";
					}
					else {
						$workTime=$schedule->first()->work_time;
					}
					array_push($arrTmp, $workTime);



					array_push($result['data'], $arrTmp);
				}

				return $result;
			}
		}
		return view('admin.work-schedule', compact('total'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(User $user)
	{
		$schedule = WorkSchedule::where('user_id',$user->id)->first();
		if(isset($schedule))
		{
			return redirect('admin/work-schedule/'.$user->id.'/edit');
		}else{
            return view('admin.createtime', compact('user'));
        }
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(User $user, Request $request)
	{
		$schedule = WorkSchedule::where('user_id',$user->id)->first();
		if(isset($schedule))
		{
			return redirect('admin/work-schedule/'+$user->id+"/edit");
		}else{
			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Monday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthuhai;
			$schedule->save();

			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Tuesday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthuba;
			$schedule->save();

			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Wednesday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthutu;
			$schedule->save();

			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Thursday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthunam;
			$schedule->save();

			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Friday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthusau;
			$schedule->save();

			$schedule = new WorkSchedule();
			$schedule->kind_of_day = "Saturday";
			$schedule->user_id = $user->id;
			$schedule->work_time = $request->txtthubay;
			$schedule->save();
		}
		return redirect('admin/work-schedule');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{ }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{

		$schedules = $user->workSchedule;
		return view('admin.edittime', compact('user', 'schedules'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$schedules = $user->workSchedule;
		foreach ($schedules as $schedule) {
			if ($schedule->kind_of_day == "Monday")
				$schedule->work_time = request('txtthu2');
			if ($schedule->kind_of_day == "Tuesday")
				$schedule->work_time = request('txtthu3');
			if ($schedule->kind_of_day == "Wednesday")
				$schedule->work_time = request('txtthu4');
			if ($schedule->kind_of_day == "Thursday")
				$schedule->work_time = request('txtthu5');
			if ($schedule->kind_of_day == "Friday")
				$schedule->work_time = request('txtthu6');
			if ($schedule->kind_of_day == "Saturday")
				$schedule->work_time = request('txtthu7');
			$schedule->save();
		}

		return redirect('/admin/work-schedule');

		/**
		 * HONG NHAT
		 */
		// $validated = $this->validateRequest($request);
		// $validated['updated_user_id'] = auth()->user()->id;
		// $id->update($validated);
		// return redirect(route('admin') . '/WorkScheduleController');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$schedules = $user->workSchedule;
		foreach ($schedules as $schedule) {
			$schedule->delete();
		}
		return redirect(route('admin') . '/work-schedule');
		/**
		 * Phan lam cua ban hong nhat
		 */
		// $update['updated_user_id'] = auth()->user()->id;
		// $id->update($update);
		// $id->delete();
		// return view('admin', '/WorkScheduleController');
	}
	public function postWorkSchedule(Request $request)
	{
	}
}
