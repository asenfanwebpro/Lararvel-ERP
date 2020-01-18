<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nwidart\ForecastPhp\Forecast;

class LayoutController extends Controller
{
    public function content(){
       // $forecast = new \Nwidart\ForecastPhp\Forecast('52cec5ff313a4d19b60540cfe89675a5');
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['link'=>"/dashboard",'name'=>"Dashboard"], ['name'=>"Content Layout"]
        ];
       // Forecast::get('37.8267','-122.423');
        
       // $sss = $forecast->get('37.8267','-122.423');
        return view('/pages/content-layout', [
            'breadcrumbs' => $breadcrumbs,
            'page'=>'dashboard',
        ]);
        
    }

    public function full(){
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
        ];
        
        return view('/pages/full-layout', [
            'pageConfigs' => $pageConfigs
        ]);
    }
}

