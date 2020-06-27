<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Setting;
use App\Http\SupportUtils;

class SettingController extends Controller
{
	/*
		php.ini -> max upload file size

		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
	*/

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$setting = Setting::first();
		return view('admin.setting', compact('setting'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{ }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validated = $this->validateRequest($request, true);

		$setting = Setting::first();
		if (isset($setting)) {
			$file = $_FILES['logo'];
			if ($file['size'] > 0) {
				$validated['logo'] = SupportUtils::uploadImages($file, '', 'logo', 'png');
			}

			Setting::create($validated);
		}

		return redirect(route('admin') . '/settings');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function show(Setting $setting)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Setting $setting)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Setting $setting)
	{
		$validated = $this->validateRequest($request);

		$file = $_FILES['logo'];
		if ($file['size'] > 0) {
			if (file_exists($setting->logo)) {
				unlink($setting->logo);
			}

			$validated['logo'] = SupportUtils::uploadImages($file, '', 'logo', 'png');
		}

		$setting->update($validated);

		return redirect(route('admin') . '/settings');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Setting  $setting
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Setting $setting)
	{
		//
	}

	private function validateRequest(Request $request, bool $create = false)
	{
		return $request->validate([
			'company_name' => 'max:32',
			'company_owner' => 'max:32',
			'company_slogan' => 'max:64',
			'company_website' => 'max:32',
			'logo' => 'image|max:' . config('app.max_file_size'),
			'tax_id' => 'max:32',
			'email' => 'max:32',
			'phone_number' => 'max:32',
			'address' => 'max:128',
			'working_hours' => 'max:32',
			'location' => 'max:32'
		]);
	}
}
