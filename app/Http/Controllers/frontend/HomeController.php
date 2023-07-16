<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\UrlClick;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }

   public function getShortenLink($link)
   {
         $agent = new Agent();
       $result = Url::where('code', $link)->first();
       if($result && $result->status == 1){
           $result->hits = $result->hits + 1;
           $result->save();
              UrlClick::create([
                'url_id' => $result->id,
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
                'device' => $agent->device(),
              ]);
           return redirect($result->url);
       }
       return view('errors.fail-url');
   }
}
