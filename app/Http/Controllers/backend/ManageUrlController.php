<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;

class ManageUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $result =  Url::all();
            return view('backend.manage-url.list', compact('result'));
        }
        $result =  Url::where('user_id', Auth::user()->id)->get();
        return view('backend.manage-url.list', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.manage-url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $code = $this->ShortUrl();
        try{
            DB::beginTransaction();
            $result = Url::create([
                'url' => $request->url,
                'shorten_url' => url('/short').'/'. $code,
                'code' => $code,
                'user_id' => Auth::user()->id,
                'hits' => 0,
                'created_at' => Carbon::now(),
            ]);
            DB::commit();
            return redirect()->route('manage-url.index')->with('success', 'Url created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Something went wrong!']);
        }
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

    public function ShortUrl(){
        $result = base_convert(rand(1000,99999), 10, 36);
        $check = Url::where('code', $result)->first();

        if($check != null){
            $this->ShortUrl();
        }

        return $result;
    }
}
