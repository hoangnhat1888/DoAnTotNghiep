<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Setting;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function __construct()
	{
		$setting =  Setting::first();
		if (!$setting) {
			$setting = new Setting();
			$setting->save();
		}

		$config = array(
			'setting' => $setting,
			'pageSize' => config('app.page_size')
		);
		view()->share('config', $config);

		if (!session('locale')) {
			session(['locale' => config('app.locale')]);
		}
		App::setLocale(session('locale'));
	}

	public function adminUrl()
	{
		return config('app.admin_url');
	}
}
