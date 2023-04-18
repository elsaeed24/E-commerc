<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{
    protected $redirectRoute = 'setting.index';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Config::get('setting.app');

        if(!$settings){
            abort(404);
        }
       // dd($settings);

        $view = 'admin.settings.$group';
        if(!View::exists($view)){
            $view = 'admin.settings.index';
        }



       return View::make($view,[
            'settings' => $settings, // $this->prepareSettings($settings),
            'page_title' => $settings['title'],
            'group' => 'app'
        ]);



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request )
    {
        $settings = Config::get('setting.app', []);
        foreach($settings['settings'] as $name => $setting){
            $input = str_replace('.','_',$name);
            if($setting['type'] == 'image' || $setting['type'] == 'file' ){
                $value = $this->upload($request->file($input), $name);

            }else{
                $value = $request->post($input);
            }

            Setting::updateOrCreate([
                'name' => $name
            ],[
                'value' => $value
            ]);

        }

      //  Cache::forget('app-settings');

        return Redirect::route($this->redirectRoute)
                    ->with('alert.success', 'Settings Saved');

    }

    protected function upload(?UploadedFile $file, $name)
   {

        if(!$file || !$file->isValid()){
            return Config::get($name);
        }

        $name .= '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('settings',$name,[
            'disk' => 'uploads'
        ]);

        return Storage::disk('uploads')->url($path);

   }

    /**
     * Remove the specified resource from storage.
     */
   protected function prepareSettings($settings)
   {
        foreach ($settings as $key => $setting){
            if(isset($setting['options']) && is_callable($setting['options'])){
                $settings[$key]['options'] = call_user_func($setting['options']);
            }
        }
        return $settings ;
   }
}
