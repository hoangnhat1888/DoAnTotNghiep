<?php

namespace App\Http\Controllers\Api;

use App\CardMapping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkStatistic;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkStatisticsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$array =  WorkStatistic::all();
		return ['data' => $array, '_token' => csrf_token()];
		// $temp_work_statistics =  WorkStatistic::where('user_id', 101)->orderBy('id', 'desc')->first();
		// return $temp_work_statistics;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//find user
		$user = User::find($request->user_id);
		if (isset($user)) {
			$work_statistic =  WorkStatistic::where('user_id', $user->id)->orderBy('id', 'desc')->first();
			if (isset($work_statistic)) {
				if (strcmp($work_statistic->direction, $request->direction) == 0 || !($user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3)) {
					$result['result'] = false;
					return $result;
				}
				//add value
				$item = new WorkStatistic();
				$item->user_id = $request->user_id;
				$item->interactive_date = Carbon::now()->toDateString();
				$item->interactive_time = Carbon::now()->toTimeString();
				$item->direction = $request->direction;
				$item->save();
				$result['result'] = true;
				return $result;
			} else {
				//add value
				$item = new WorkStatistic();
				$item->user_id = $request->user_id;
				$item->interactive_date = Carbon::now()->toDateString();
				$item->interactive_time = Carbon::now()->toTimeString();
				$item->direction = $request->direction;
				$item->save();
				$result['result'] = true;
				return $result;
			}
		}
		$result['result'] = false;
		return $result;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$work_statistic = WorkStatistic::find($id);
		if (isset($work_statistic)) {
			return ['data' => $work_statistic];
		} else {
			return 'Không tồn tại';
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function apiWorkStatistics()
	{
		//find card mapping
		$card = CardMapping::where('card_id', request()['card_id'])->first();
		if (isset($card)) {
			$user = User::find($card->user_id);
		}

		//user is exist
		if (isset($user) && isset($card) && isset($card->card_id)) {
			$work_statistic =  WorkStatistic::where('user_id', $user->id)->orderBy('id', 'desc')->first();
			if (isset($work_statistic)) {
				if (strcmp($work_statistic->direction, request()['direction']) == 0 && !($user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3)) {
					$result['result'] = false;
					return $result;
				}
				//add value
				$item = new WorkStatistic();
				$item->user_id = $user->id;
				$item->interactive_date = Carbon::now()->toDateString();
				$item->interactive_time = Carbon::now()->toTimeString();
				$item->direction = request()['direction'];
				$item->save();
				$result['result'] = true;
				return $result;
			} else {
				if (strcmp(request()['direction'], 'out') == 0 && !($user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3)) {
					$result['result'] = false;
					return $result;
				}
				//add value
				$item = new WorkStatistic();
				$item->user_id = $user->id;
				$item->interactive_date = Carbon::now()->toDateString();
				$item->interactive_time = Carbon::now()->toTimeString();
				$item->direction = request()['direction'];
				$item->save();
				$result['result'] = true;
				return $result;
			}
		}
		$result['result'] = false;
		return $result;
	}
}