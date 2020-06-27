<?php

namespace App\Http\Controllers\Admin;
use App\Template;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\File;
class TemplateExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
	{
        $query = Template::query();
        $total=$query->whereNotNull('user_id')->where('exported','1')->get()->count();
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
                    $keyword =  request('search')['value'];
                    $query = $query->orWhere('name', 'like', "%$keyword%");    
					if ($keyword) {
						$filtered = true;
					}
				}

				$dictFields = [
					'0' => '',
					'1' => 'nameTemplate',
					'2' => '',

				];

                $templates = $query -> skip($currentPage * $perPage)->take($perPage)->get();
               
				if (request()->has('draw') && request('draw') && is_numeric(request('draw'))) {
					$result['draw'] = request('draw') + 1;
				} else {
					$result['draw'] = 1;
				}
				$result['recordsTotal'] = $total;
				$result['recordsFiltered'] = $filtered ? count($user) : $total ;

				$result['data'] = [];
				foreach ($templates as $template) {
                    $arrTmp = [];
                    if($template->user_id == null || $template->exported == 0 )
                        continue;
                    else{
                        //add value checkbox
                        array_push($arrTmp, $template->id);
                        //return name user
                        array_push($arrTmp, $template->name);
                        //check file
                        if( file_exists($template->link) ){
                            array_push($arrTmp, [$template->link,$template->name]);  
                        }
                        else{
                            $template->delete();
                            continue;   
                        }
                        array_push($result['data'], $arrTmp);
                    }
				}

				return $result;
			}
		}

		return view('admin.template-exports', compact('total'));
	}

    public function create()
    {
        return view('admin.create-template-exports');
    }

  
    public function store(Request $request)
    {   
        $validate =$request->validate([
            '_file'=>'required',
            'name'=>'required',
        ]);
        $filename= $request->file('_file')->getClientOriginalName();
        $path=$request->file('_file')->move('export-templates', str_random(10).$filename);
        Template::create([
            'user_id'=>Auth()->user()->id,
            'name'=> $request->name,
            'link'=>$path,
            'exported'=>1
        ]);
        
        return redirect("/admin/template-exports");
            
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
    {
       
        return view('admin.create-template-exports');
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
        $template=Template::findOrFail($id);
        File::delete($template->link);
	    $template->delete();
     }       
}
