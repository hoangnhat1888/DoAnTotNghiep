<?php

namespace App\Http\Controllers\Admin;

use App\BookingTimeOff;
use App\User;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Gender;
use App\Position;
use App\Role\UserRole;
use App\Http\SupportUtils;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Content;
use PhpOffice\PhpWord\Writer\Word2007\Style\Row;
use Carbon\Carbon;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
					'6' => 'start_date',
					'7' => 'signing_date',
					'8' => 'signing_term',
					'9' => 'end_date',
					'10' => 'annual_leave',
					'11' => 'remaining_days',
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
				foreach ($users as $user) {
					$arrTmp = [];

					$date_current = Carbon::now();
					if($date_current->month >=3)
					{
						// 3456789 10 11 12
						$date_reset = Carbon::create($date_current ->year, 3, 1, 00, 00, 00);


						if($user->start_date>$date_reset)
						{
							$date_vacation = $date_current->month - Carbon::create($user->start_date)->month;
						}
						else{
							$date_vacation = $date_current ->month - 2;
						}
						$amount_date_agree = DB::table('booking_time_off')->where('user_id',$user->id)->where('approval_type_id',1)->whereBetween('booking_day',
											[$date_reset, $date_current])->count();
						$date_rest = $date_vacation - $amount_date_agree ;

					}
					else
					{
						//12
						$year_reset = $date_current->year - 1;
						$date_reset = Carbon::create($year_reset, 3, 1, 00, 00, 00);

						if($user->start_date>$date_reset)
						{
							$date_vacation = $date_current->month + (13-Carbon::create($user->start_date)->month);
						}
						else{
							$date_vacation = $date_current->month + 10;
						}

						$amount_date_agree = DB::table('booking_time_off')->where('user_id',$user->id)->where('approval_type_id',1)->whereBetween('booking_day',
											[$date_reset, $date_current])->count();
						$date_rest = $date_vacation - $amount_date_agree;
					}

					array_push($arrTmp, $user->id);
					array_push($arrTmp, $user->first_name . ' ' . $user->last_name);
					array_push($arrTmp, $user->username);
					array_push($arrTmp, $user->email);
					array_push($arrTmp, $user->phone_number);
					array_push($arrTmp, $user->position ? $user->position->name : null);
					array_push($arrTmp, date('d-m-Y', strtotime($user->start_date)));
					array_push($arrTmp, date('d-m-Y', strtotime($user->signing_date)));
					array_push($arrTmp, $user->signing_term);
					array_push($arrTmp, $user->end_date ? date('d-m-Y', strtotime($user->end_date)) : '');

					if ($user->position_id < 10) {
						array_push($arrTmp, $date_vacation);
						array_push($arrTmp, $date_rest);
					} else {
						array_push($arrTmp, '---');
						array_push($arrTmp, '---');
					}

					array_push($result['data'], $arrTmp);
				}

				return $result;
			}
		}
		//dd($this->timeupdate());
		return view('admin.user', compact('total'));
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$genders = Gender::all();
		$positions = Position::all();
		$roles = UserRole::getRoleList();

		return view('admin.user-details', compact('genders', 'positions', 'roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validated = $this->validateRequest($request, true);

		$file = $_FILES['image'];
		if ($file['size'] > 0) {
			$validated['image'] = SupportUtils::uploadImages($file, 'users', SupportUtils::formatToUrl($validated['username']));
		}

		$validated['password'] = Hash::make($validated['password']);
		$validated['created_user_id'] = auth()->user()->id;
		User::create($validated);

		return redirect(route('admin') . '/users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$genders = Gender::all();
		$positions = Position::all();
		$roles = UserRole::getRoleList();

		return view('admin.user-details', compact('user', 'genders', 'positions', 'roles'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$validated = $this->validateRequest($request);

		if (isset($_FILES['image'])) {
			$file = $_FILES['image'];
			if ($file['size'] > 0) {
				if (file_exists($user->image)) {
					unlink($user->image);
				}

				$validated['image'] = SupportUtils::uploadImages($file, 'users', SupportUtils::formatToUrl($validated['username']));
			}
		}

		if ($validated['password'] === '') {
			$validated['password'] = $user->password;
		} else {
			$validated['password'] = Hash::make($validated['password']);
		}
		$validated['updated_user_id'] = auth()->user()->id;
		$user->update($validated);

		return redirect(route('admin') . '/users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$update['updated_user_id'] = auth()->user()->id;
		$user->update($update);
		$user->delete();
	}

	private function validateRequest(Request $request, bool $create = false)
	{
		if (isset($request['roles']) && $request['roles']) {
			$request['roles'] = json_decode($request['roles']);
		} else {
			$request['roles'] = [];
		}

		$validated = $request->validate([
			'bts_id' => 'max:8',
			'username' => 'max:32' . ($create ? '|unique:users,username' : ''),
			'password' => 'max:64|confirmed',
			'email' => 'required|email|max:32' . ($create ? '|unique:users,email' : ''),
			'image' => 'max:' . config('app.max_file_size'),
			'first_name' => 'required|max:32',
			'last_name' => 'required|max:32',
			'phone_number' => 'required|max:32',
			'address' => 'max:128',
			'gender_id' => '',
			'position_id' => '',
			'start_date' => 'required|date',
			'signing_date' => 'required|date',
			'signing_term' => 'min:0',
			'end_date' => '',
			'salary' => 'numeric|min:0',
			'roles' => '',
			'created_user_id' => '',
			'updated_user_id' => '',
		]);

		if ($validated['end_date'] && $validated['end_date'] < $validated['start_date']) {
			$validated['end_date'] = null;
		}

		if (!isset($validated['password'])) {
			$validated['password'] = '';
		}

		return $validated;
	}

	public function editCurrentAccount()
	{
		$user = auth()->user();
		$genders = Gender::all();
		$positions = Position::all();
		$roles = UserRole::getRoleList();

		return view('admin.user-details', compact('user', 'genders', 'positions', 'roles'));
	}

	public function updateCurrentAccount(Request $request)
	{
		$validated = $this->validateRequest($request);
		$user = auth()->user();

		if (isset($_FILES['image'])) {
			$file = $_FILES['image'];
			if ($file['size'] > 0) {
				if (file_exists($user->image)) {
					unlink($user->image);
				}

				$validated['image'] = SupportUtils::uploadImages($file, 'users', SupportUtils::formatToUrl($validated['username']));
			}
		}

		if ($validated['password'] === '') {
			$validated['password'] = $user->password;
		} else {
			$validated['password'] = Hash::make($validated['password']);
		}
		$validated['updated_user_id'] = auth()->user()->id;

		unset($validated['vip_id']);
		unset($validated['roles']);

		$user->update($validated);

		return redirect(route('admin'));
	}

	public function templates()
	{
		//get templates from server
		$templates = Template::where('exported', 0)->get();
		return view('admin/templates')->with('kindOfTemplates', $templates);
	}

	public function templatesDetail($id)
	{
		//read file
		$striped_content = '';
		$content = '';

		$temp = Template::find($id);
		if (file_exists($temp->link)) {
			$zip = zip_open($temp->link);

			if (!$zip || is_numeric($zip)) return false;

			while ($zip_entry = zip_read($zip)) {

				if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

				if (zip_entry_name($zip_entry) != "word/document.xml") continue;

				$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

				zip_entry_close($zip_entry);
			} // end while

			zip_close($zip);
			$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
			$content = str_replace('</w:r></w:p>', "\r\n", $content);
			$striped_content = strip_tags($content);

			//get all of fields from file
			$array = explode(' ', $striped_content);
			$values = array();
			for ($i = 0; $i < count($array); $i++) {
				if (str_contains($array[$i], '{{') && str_contains($array[$i], '}}')) {
					if (!empty(str_before($array[$i], '}}'))) {
						$item = str_after(str_before($array[$i], '}}'), "{{");
						array_push($values, $item);
					}
				}
			}
			$values = array_unique($values);
			return view('admin/templates-detail')->with(['field_name' => $values, 'title' => $temp]);
		} else {
			$temp = Template::find($id);
			$temp->delete();
			return back();
		}
	}

	public function export(Request $request)
	{
        //Read file
        $striped_content = '';
        $content = '';
        $id = $request->idTitle;
        $temp = Template::find($id);
        $file = $temp->link;
        if (file_exists($temp->link)) {
            $zip = zip_open($file);

            if (!$zip || is_numeric($zip)) {
                return false;
            }
            while ($zip_entry = zip_read($zip)) {
                if (zip_entry_open($zip, $zip_entry) == false) {
                    continue;
                }
                if (zip_entry_name($zip_entry) != "word/document.xml") {
                    continue;
                }
                $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                zip_entry_close($zip_entry);
            } // end while

            zip_close($zip);
            $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
            $content = str_replace('</w:r></w:p>', "\r\n", $content);
            $striped_content = strip_tags($content);
            $array = explode(' ', $striped_content);
            $values = array();
            for ($i = 0; $i < count($array); $i++) {
                if (str_contains($array[$i], '{{') && str_contains($array[$i], '}}')) {
                    if (!empty(str_before($array[$i], '}}'))) {
                        $item = str_after(str_before($array[$i], '}}'), "{{");
                        array_push($values, $item);
                    }
                }
            }
            $values = array_unique($values);

            //Load file template
            $phpword = new \PhpOffice\PhpWord\TemplateProcessor($file);

            //Replace field
            foreach ($values as $item) {
                if (str_contains($item, 'date') || str_contains($item, 'day')) {
                    $datetemp = strtotime($request->$item);
                    $phpword->setValue('{{' . $item . '}}', date('d', $datetemp) . " tháng " . date('m', $datetemp) . " năm " . date('Y', $datetemp));
                } elseif (str_contains($item, 'number') && str_contains($item, 'phone')) {
                    $array = explode(' ', $request->$item);
                    $number = '';
                    for ($i = 0; $i < count($array); $i++) {
                        $number .= trim($array[$i]);
                    }
                    $phpword->setValue('{{' . $item . '}}', "0" . number_format($number, 0, ".", "."));
                } elseif (str_contains($item, 'number')) {
                    $array = explode(' ', $request->$item);
                    $number = '';
                    for ($i = 0; $i < count($array); $i++) {
                        $number .= trim($array[$i]);
                    }
                    $phpword->setValue('{{' . $item . '}}', number_format($number, 0, ".", "."));
                } else {
                    $phpword->setValue('{{' . $item . '}}', $request->$item);
                }
            }

            //Create file name
            $str = $temp->name . '-' . SupportUtils::getRandomString(20, false);
            $unicode = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd' => 'đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i' => 'í|ì|ỉ|ĩ|ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
                'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D' => 'Đ',
                'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
                'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );

            foreach ($unicode as $nonUnicode => $uni) {
                $str = preg_replace("/($uni)/i", $nonUnicode, $str);
            }
            $str = str_replace(' ', '', $str);

            //Save file
            $phpword->saveAs('export-templates/' . $str . '.docx');

            //Insert server
            $template = new Template();
            $template->user_id = auth()->user()->id;
            $template->name = $temp->name;
            $template->link = 'export-templates/' . $str . '.docx';
            $template->exported = 1;
            $template->save();

            return response()->download('export-templates/' . $str . '.docx');
        } else {
            return back();
        }
	}
}








