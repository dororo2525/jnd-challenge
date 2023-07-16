<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;
use App\Models\UrlClick;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = Url::where('user_id', Auth::user()->id)->get();
        return view('backend.dashboard.dashboard', compact('urls'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getClickbyCurrentDate()
    {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
        $clickCounts = [];

        $currentDate = $startDate->copy();
        $urls = Url::where('user_id', Auth::user()->id)->get();
        foreach ($urls as $key => $url) {
            while ($currentDate <= $endDate) {
                $clickCount = UrlClick::whereYear('created_at', $currentDate->year)
                        ->whereMonth('created_at', $currentDate->month)
                        ->where('url_id', $url->id)
                        ->count();
                $clickCounts[$currentDate->format('n') - 1] = $clickCount;

                $currentDate->addMonth();
            }
            $urls[$key]['clicks'] = $clickCounts;
            $clickCounts = [];
        }
        return response()->json($urls);
    }

    public function getClickbyDate(Request $request)
    {
        $startDate = Carbon::parse($request->startDate)->startOfMonth();
        $endDate = Carbon::parse($request->endDate)->endOfMonth();
        $clickCounts = [];
        $currentDate = $startDate->copy();
        $urls = Url::where('user_id', Auth::user()->id)->get();
        foreach ($urls as $key => $url) {
            while ($currentDate <= $endDate) {
                $clickCount = UrlClick::whereYear('created_at', $currentDate->year)
                        ->whereMonth('created_at', $currentDate->month)
                        ->where('url_id', $url->id)
                        ->count();

                $clickCounts[$currentDate->format('Y-n')] = $clickCount;

                $currentDate->addMonth();
            }
            $urls[$key]['clicks'] = $clickCounts;
            $clickCounts = [];
        }
        return response()->json($urls);
    }
}
