<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;
use App\Models\UrlClick;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;

class ManageUrlController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission')->only(['edit']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $result =  Url::all();
            $users = User::all();
            return view('backend.manage-url.list', compact('result' , 'users'));
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
                'user_id' => $request->has('user_id') ? $request->user_id : Auth::user()->id,
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
        $result = Url::where('code', $id)->first();
        return view('backend.manage-url.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'url' => 'required|url'
        ]);
        try{
            DB::beginTransaction();
            $result = Url::where('code', $id)->first();
            $result->url = $request->url;
            $result->status = $request->has('status') ? 1 : 0;
            $result->save();
            DB::commit();
            return redirect()->route('manage-url.index')->with('success', 'Url updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            $result = Url::where('code', $id)->first();
            $result->delete();
            $click = UrlClick::where('url_id', $result->id);
            $click->delete();
            DB::commit();
            return response()->json(['status' => true, 'msg' => 'Url deleted successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'msg' => 'Something went wrong!']);
        }
    }

    public function switchStatus(Request $request){
        $result = Url::where('code',$request->code)->first();
        if($result){
            $result->status = $request->status;
            $result->save();
            return response()->json(['status' => true, 'msg' => 'Status updated successfully!']);
        }
        return response()->json(['status' => false, 'msg' => 'Something went wrong!']);
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
