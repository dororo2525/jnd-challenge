<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }

   public function getShortenLink($link)
   {
       $result = Url::where('code', $link)->first();
       if($result){
           $result->hits = $result->hits + 1;
           $result->save();
           return redirect($result->url);
       }
       return redirect()->route('home')->withErrors(['msg' => 'Url not found!']);
   }
}
