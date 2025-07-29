<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class RequestController extends Controller
{
     public function reqcomplated(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'request_types.request_type_name', 'users.name')
            ->where('requests.user_id', auth()->id())
            ->whereIn('requests.status', ['COMPLETED', 'REJECTED'])
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = "<a href='/developer-request-complated/{$row->id}/detail' class='btn btn-primary btn-sm'>Detail</a>";

                    if ($row->status === 'REJECTED') {
                        $buttons .= "<a href='/developer-request-complated/{$row->id}/edit' class='btn btn-warning btn-sm ml-1'>Edit</a>";
                    }

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('request.reqcomplated', [
            'title' => "Request Completed"
        ]);
    }

     public function reqonprogress(Request $request)
    {
          if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'request_types.request_type_name', 'users.name')
            ->where('requests.user_id', auth()->id())
            ->whereIn('requests.status', ['WAITING', 'ON PROGRESS'])
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $buttons = "<a href='/developer-request-onprogress/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                  
                        if ($row->status === 'WAITING') {
                            $buttons .= "<a href='/developer-request-onprogress/{$row->id}/edit' class='btn btn-warning btn-sm ml-1'>Edit</a>";
                            $buttons .= "<form action='/developer-request-onprogress/{$row->id}/delete' method='POST' class='d-inline'>
                                            <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</button>
                                        </form>";
                        }

                        return $buttons;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('request.reqonprogress', [
            'title' => "Request On Progress"
        ]);
    }

    public function agentreqavailable(Request $request)
    {
        $userRoles = auth()->user()->roles()->pluck('id')->toArray();

        // dd($userRoles);

         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'request_types.request_type_name', 'users.name')
            ->where('request_types.role_id', $userRoles)
            ->where('requests.status', 'WAITING')
            ->orderBy('requests.id', 'asc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/agent-request-available/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>
                                <a href='/agent-request-available/$row->id/asign' class='btn btn-success btn-sm'>Assign To Me</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('request.agentreqavailable', [
            'title' => "Requests Available"
        ]);
    }

     public function agentreqonprogress(Request $request)
    {
        $userpic = auth()->user()->name;

        // dd($userRoles);

         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'request_types.request_type_name', 'users.name')
            ->where('requests.pic', $userpic)
            ->where('requests.status', 'ON PROGRESS')
            ->orderBy('requests.id', 'asc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/agent-request-onprogress/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('request.agentreqonprogress', [
            'title' => "Requests On Progress"
        ]);
    }

    public function agentreqcomplated(Request $request)
    {
        $userpic = auth()->user()->name;

        // dd($userRoles);

         if ($request->ajax()) {
            $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'request_types.request_type_name', 'users.name')
            ->where('requests.pic', $userpic)
            ->whereIn('requests.status', ['COMPLETED', 'REJECTED'])
            ->orderBy('requests.id', 'desc')
            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return "<a href='/agent-request-available/$row->id/detail' class='btn btn-primary btn-sm'>Detail</a>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                    }

        return view('request.agentreqcomplated', [
            'title' => "Requests Completed"
        ]);
    }

    public function agentasignreq($id)
    {
        $userpic = auth()->user()->name;
         $tgl = Carbon::now();
        $tgl_now = $tgl->format('Y-m-d');
        DB::table('requests')
            ->where('id', $id)
            ->update([
                'collect_date' => $tgl_now,
                'pic' => $userpic,
                'status' => 'ON PROGRESS'
            ]);

        return redirect('agent-request-onprogress')->with('success', 'Request Berhasil diambil.');
    }

    public function agentdetailonprogress($id)
    {
        $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->join('users as pic_users', 'pic_users.name', '=', 'requests.pic')
            ->join('request_details', 'requests.id', '=', 'request_details.request_id')
            ->select('request_details.*', 
                    'request_types.request_type_name', 
                    'requests.status', 
                    'requests.request_date', 
                    'requests.collect_date', 
                    'users.name', 
                    'users.email', 
                    'pic_users.name as pic_name',
                    'pic_users.email as pic_email')
            ->where('request_details.request_id', $id)
            ->first();
        return view('request.agentdetailonprogress', [
            'title' => "Detail Request On Progress",
            'data' => $data
        ]);
    }

    public function agentdetailavailable($id)
    {
        $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->join('request_details', 'requests.id', '=', 'request_details.request_id')
            ->select('request_details.*', 
                    'request_types.request_type_name', 
                    'requests.status', 
                    'requests.request_date', 
                    'users.name', 
                    'users.email')
            ->where('request_details.request_id', $id)
            ->first();
        return view('request.agentdetailavailable', [
            'title' => "Detail Request Available",
            'data' => $data
        ]);
    }

    public function devdetailonprogress($id)
    {
        $data = DB::table('requests')
            ->join('request_types', 'request_types.id', '=', 'requests.request_type_id')
            ->join('users', 'users.id', '=', 'requests.user_id')
            ->leftJoin('users as pic_users', 'pic_users.name', '=', 'requests.pic')
            ->join('request_details', 'requests.id', '=', 'request_details.request_id')
            ->select('request_details.*', 
                    'request_types.request_type_name', 
                    'requests.status', 
                    'requests.request_date', 
                    'requests.collect_date',
                    'users.name', 
                    'users.email', 
                    'pic_users.name as pic_name',
                    'pic_users.email as pic_email')
            ->where('request_details.request_id', $id)
            ->first();
        return view('request.devdetailonprogress', [
            'title' => "Detail Request On Progress",
            'data' => $data
        ]);
    }
}
