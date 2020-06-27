<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Statistic;

class HomeController extends Controller
{
	public function index()
	{
		$validated = request()->validate([
			'fromDate' => 'numeric',
			'toDate' => 'numeric|gt:fromDate',
			'lang' => '',
			'url' => ''
		]);

		if (isset($validated['lang'])) {
			if (file_exists(resource_path('lang/' . $validated['lang']))) {
				session(['locale' => $validated['lang']]);
			}
			return redirect(isset($validated['url']) ? $validated['url'] : '');
		}

		// if (!array_key_exists('fromDate', $validated) || !array_key_exists('toDate', $validated)) {
		// 	$fromDate = date('Y-m-d', strtotime('-15 days'));
		// 	// $toDate = date('Y-m-d', strtotime('+1 days'));
		// 	$toDate = date('Y-m-d');
		// } else {
		// 	$fromDate = date('Y-m-d', $validated['fromDate']);
		// 	// $toDate = date('Y-m-d', strtotime(date('Y-m-d', $validated['toDate']) . '+ 1 days'));
		// 	$toDate = date('Y-m-d', $validated['toDate']);
		// }

		// $statistics = Statistic::whereBetween('access_time', [$fromDate, date('Y-m-d', strtotime($toDate . '+1 days'))])->get();

		// $currentDate = $fromDate;
		// $nextDate = date('Y-m-d', strtotime($currentDate . '+1 days'));

		// $points = [];

		// $point = new Point();
		// $point->x = strtotime($currentDate) * 1000;
		// for ($i = 0; $i < count($statistics); $i++) {
		// 	$statistic = $statistics[$i];

		// 	if ($statistic->access_time >= $currentDate && $statistic->access_time < $nextDate) {
		// 		$point->y++;
		// 	} else {
		// 		$currentDate = date('Y-m-d', strtotime($nextDate));
		// 		$nextDate = date('Y-m-d', strtotime($nextDate . '+1 days'));
		// 		array_push($points, $point);
		// 		$point = new Point();
		// 		$point->x = strtotime($currentDate) * 1000;

		// 		if ($statistic->access_time >= $currentDate && $statistic->access_time < $nextDate) {
		// 			$point->y++;
		// 		} else {
		// 			$i--;
		// 		}
		// 	}
		// }
		// array_push($points, $point);

		// return view('admin.home', compact('statistics', 'fromDate', 'toDate', 'points'));

		return view('admin.home');
	}
}

class Point
{
	public $x = 0;
	public $y = 0;
}
