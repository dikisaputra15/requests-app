<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RequestDetail;
use App\Models\Requests;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class InfrastructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Infrastructure')
            ->whereIn('requests.status', ['COMPLETED', 'REJECTED'])
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<a href="#" class="btn btn-primary btn-sm">Detail</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('infrastructure.index', [
            'title' => "Infrastructure Completed"
        ]);
    }

     public function onprogress(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Infrastructure')
            ->where('requests.status', 'ON PROGRESS')
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<a href="#" class="btn btn-primary btn-sm">Detail</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('infrastructure.reqonprogress', [
            'title' => "Infrastructure On Progress"
        ]);
    }

     public function available(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Infrastructure')
            ->where('requests.status', 'WAITING')
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<a href="#" class="btn btn-primary btn-sm">Detail</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('infrastructure.reqavailable', [
            'title' => "Infrastructure Available"
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

    public function formspecup()
    {
        $reqtypes = DB::table('request_types')->get();
        return view('infrastructure.formspecup', [
            'title' => "Form Server Spesification Upgrade",
            'reqtypes' => $reqtypes
        ]);
    }
    public function formsoftinstall()
    {
        $reqtypes = DB::table('request_types')->get();
        return view('infrastructure.formsoftinstall', [
            'title' => "Form Server Software Installation",
            'reqtypes' => $reqtypes
        ]);
    }

    public function saveformspec(Request $request)
    {
        $tgl = Carbon::now();
        $tgl_now = $tgl->format('Y-m-d');
        $user_id = auth()->user()->id;

        $req = Requests::create([
            'request_date' => $tgl_now,
            'status' => 'WAITING',
            'user_id' => $user_id,
            'request_type_id' => $request->req_id
        ]);

         if($req){
            // $last_id = Requests::latest()->first();
            $req_id = $req->id;

                RequestDetail::create([
                    'ticket_url' => $request->ticket_url,
                    'server_name' => $request->server_name,
                    'current_spec' => $request->current_spec,
                    'requested_spec' => $request->requested_spec,
                    'purpose' => $request->purpose,
                    'request_id' => $req_id
                ]);
         }

         return redirect('developer-request-onprogress')->with('success', 'Data berhasil dibuat.');
    }

       public function saveformsoft(Request $request)
    {
         $tgl = Carbon::now();
        $tgl_now = $tgl->format('Y-m-d');
        $user_id = auth()->user()->id;

        $req = Requests::create([
            'request_date' => $tgl_now,
            'status' => 'WAITING',
            'user_id' => $user_id,
            'request_type_id' => $request->req_id
        ]);

         if($req){
            // $last_id = Requests::latest()->first();
            $req_id = $req->id;

                RequestDetail::create([
                    'ticket_url' => $request->ticket_url,
                    'server_name' => $request->server_name,
                    'software_name' => $request->software_name,
                    'software_version' => $request->software_version,
                    'purpose' => $request->purpose,
                    'request_id' => $req_id
                ]);
         }

         return redirect('developer-request-onprogress')->with('success', 'Data berhasil dibuat.');
    }
}
