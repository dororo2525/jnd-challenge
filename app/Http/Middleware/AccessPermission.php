<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;

class AccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $result = Url::where('code', $request->route()->parameters('id'))->first();
        if(($result && Auth::user()->role == 'admin') || ($result && $result->user_id == Auth::user()->id)){
            return $next($request);
        }
        return redirect()->route('manage-url.index')->withErrors(['msg' => 'You do not have permission to access this page.']);
    }
}
