<?php

namespace App\Http\Controllers\Admin;

use App\BookingTimeOff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class WorkOffController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = BookingTimeOff::query();
		$total = $query->where('approval_type_id', NULL)->get()->count();

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
					$query = $query->Where('id', 'like', "%$keyword%")
						->orWhere('user_id', 'like', "%$keyword%");

					if ($keyword) {
						$filtered = true;
					}
				}

				$dictFields = [
					'0' => 'id',
					'1' => 'Bts_id',
					'2' => 'Tên',
					'3' => 'Email',
					'4' => 'Số Điện Thoại',
					'5' => 'Ngày xin nghỉ',
					'6' => 'Lí do',
				];

				if (
					request()->has('order') && request('order') && count(request('order')) &&
					array_key_exists('column', request('order')[0]) && array_key_exists('dir', request('order')[0])
				) {
					$query = $query->where('approval_type_id', NULL)->orderBy($dictFields[request('order')[0]['column']], request('order')[0]['dir']);
				}

				$work_offs = $query->skip($currentPage * $perPage)->take($perPage)->get();

				if (request()->has('draw') && request('draw') && is_numeric(request('draw'))) {
					$result['draw'] = request('draw') + 1;
				} else {
					$result['draw'] = 1;
				}
				$result['recordsTotal'] = $total;
				$result['recordsFiltered'] = $filtered ? count($work_offs) : $total;

				$result['data'] = [];
				foreach ($work_offs as $booking_time_off) {
					if (isset($booking_time_off->user_id) && $booking_time_off->approval_type_id == NULL){
						$arrTmp = [];
						array_push($arrTmp, $booking_time_off->id);
						foreach (User::all() as $user) {
							if ($user->id == $booking_time_off->user_id) {
								array_push($arrTmp, $user->bts_id);
								array_push($arrTmp, $user->first_name . ' ' . $user->last_name);
								array_push($arrTmp, $user->email);
								array_push($arrTmp, $user->phone_number);
							}
						}
						array_push($arrTmp, $booking_time_off->booking_day);
						array_push($arrTmp, $booking_time_off->reason);

						array_push($result['data'], $arrTmp);
					}
				}

				return $result;
			}
		}

		return view('admin.book-time-off', compact('total'));
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{ }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$work = BookingTimeOff::find($id);
		if (strcmp(request()['type'], 'update') == 0) {
			$work->approval_type_id = 1;
		} else {
			$work->approval_type_id = 2;
		}
		$work->approved_user_id = auth()->user()->id;
		$work->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{ }
}
