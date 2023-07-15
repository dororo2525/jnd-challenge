<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Url;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }

   public function getShortenLink($link)
   {
       $result = Url::where('code', $link)->first();
       if($result && $result->status == 1){
           $result->hits = $result->hits + 1;
           $result->save();
           return redirect($result->url);
       }
       return view('errors.fail-url');
   }
}
