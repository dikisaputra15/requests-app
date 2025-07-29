<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Requests;
use App\Models\RequestDetail;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class NetworkController extends Controller
{
     public function reqcompleted(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Network')
            ->whereIn('requests.status', ['COMPLETED', 'REJECTED'])
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/network-completed/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('network.reqcompleted', [
            'title' => "Network Completed"
        ]);
    }

    public function reqonprogress(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Network')
            ->where('requests.status', 'ON PROGRESS')
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/network-onprogress/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('network.reqonprogress', [
            'title' => "Network On Progress"
        ]);
    }

    public function reqavailable(Request $request)
    {
         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('roles', 'roles.id', '=', 'request_types.role_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name', 'request_types.request_type_name')
            ->where('roles.name', 'IT Network')
            ->where('requests.status', 'WAITING')
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/network-available/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('network.reqavailable', [
            'title' => "Network Available"
        ]);
    }

     public function formaddressip()
    {
        $reqtypes = DB::table('request_types')->get();
        return view('network.formaddressip', [
            'title' => "Form IP Address Allocation",
            'reqtypes' => $reqtypes
        ]);
    }

     public function formfirewallaccess()
    {
        $reqtypes = DB::table('request_types')->get();
        return view('network.formfirewallaccess', [
            'title' => "Form Firewall Access",
            'reqtypes' => $reqtypes
        ]);
    }

    public function saveformipaddress(Request $request)
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
                    'purpose' => $request->purpose,
                    'request_id' => $req_id
                ]);
         }

         return redirect('developer-request-onprogress')->with('success', 'Data berhasil dibuat.');
    }

    public function saveformfirewall(Request $request)
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
                    'source_ip' => $request->source_ip,
                    'destination_ip' => $request->destination_ip,
                    'port' => $request->port,
                    'purpose' => $request->purpose,
                    'request_id' => $req_id
                ]);
         }

         return redirect('developer-request-onprogress')->with('success', 'Data berhasil dibuat.');
    }
}
