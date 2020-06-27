<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage; 
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\SupportUtils;
use \Input as Input;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        $templates=Template::whereNull('user_id')->get();
        $query = Template::whereNull('user_id');
        $total = $query->get()->count();
        return view('admin.template',compact('templates','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.create-templates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'file'=>'required|mimes:doc,docx|max:2048',
            'name'=>'required|min:0',
            
        ]);
        
     
        $path1=$request->file->getClientOriginalName();
        $path=$request->file->move('template-samples',str_random(3).$path1);
        Template::create([
             'name'=>request('name'),
              'link'=>$path, 
         ]);
        return redirect('admin/template');
   

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        return redirect('admin/templates');
        // $template=Template::findOrfail($id);
        // return view('admin.show-templates',compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $template=Template::findOrfail($id);
        File::delete($template->link);
        // $link_path='/template-samples/$template->link';
        // unlink($link_path);
        $template->delete();
       
    }
}

