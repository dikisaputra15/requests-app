@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title ?? '' }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Request Detail</div>
                </div>
            </div>

            <div id="session" data-session="{{ session('success') }}"></div>

            <div class="container mt-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Detail Permintaan</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-3">Data Pemohon</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$data->email}}</td>
                            </tr>
                        </table>

                        @if($data->pic_name || $data->pic_email)
                        <h6 class="mb-3">Data Penanggung Jawab</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{$data->pic_name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$data->pic_email}}</td>
                            </tr>
                        </table>
                        @endif

                        <h6 class="mb-3">Status Permintaan</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Status</th>
                                <td>
                                    @php
                                        $status = strtolower($data->status);
                                        $badgeClass = match($status) {
                                            'waiting' => 'bg-info',
                                            'on progress' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }} text-white text-capitalize px-3 py-2">
                                        {{ $data->status }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Tanggal Request</th>
                                <td>{{ $data->request_date }}</td>
                            </tr>

                            <tr>
                                <th>Tanggal Ambil Request</th>
                                <td>{{ $data->collect_date }}</td>
                            </tr>
                        </table>

                        <h6 class="mt-4 mb-3">Data Permintaan</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Request Type</th>
                                <td>{{$data->request_type_name}}</td>
                            </tr>

                            @if($data->ticket_url)
                            <tr>
                                <th>Request ID</th>
                                <td>{{ $data->request_id }}</td>
                            </tr>
                            @endif

                            @if($data->ticket_url)
                            <tr>
                                <th>Ticket URL</th>
                                <td>{{ $data->ticket_url }}</td>
                            </tr>
                            @endif

                            @if($data->server_name)
                            <tr>
                                <th>Server Name</th>
                                <td>{{ $data->server_name }}</td>
                            </tr>
                            @endif

                            @if($data->current_spec)
                            <tr>
                                <th>Current Spec</th>
                                <td>{{ $data->current_spec }}</td>
                            </tr>
                            @endif

                            @if($data->requested_spec)
                            <tr>
                                <th>Requested Spec</th>
                                <td>{{ $data->requested_spec }}</td>
                            </tr>
                            @endif

                            @if($data->software_version)
                            <tr>
                                <th>Software Version</th>
                                <td>{{ $data->software_version }}</td>
                            </tr>
                            @endif

                            @if($data->software_name)
                            <tr>
                                <th>Software Name</th>
                                <td>{{ $data->software_name }}</td>
                            </tr>
                            @endif

                            @if($data->file)
                            <tr>
                                <th>File</th>
                                <td>
                                    <a href="{{ Storage::url($data->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download File
                                    </a>
                                </td>
                            </tr>
                            @endif

                            @if($data->service_name)
                            <tr>
                                <th>Service Name</th>
                                <td>{{ $data->service_name }}</td>
                            </tr>
                            @endif

                            @if($data->feature)
                            <tr>
                                <th>Feature</th>
                                <td>{{ $data->feature }}</td>
                            </tr>
                            @endif

                            @if($data->source_ip)
                            <tr>
                                <th>Source IP</th>
                                <td>{{ $data->source_ip }}</td>
                            </tr>
                            @endif

                            @if($data->destination_ip)
                            <tr>
                                <th>Destination IP</th>
                                <td>{{ $data->destination_ip }}</td>
                            </tr>
                            @endif

                            @if($data->port)
                            <tr>
                                <th>Port</th>
                                <td>{{ $data->port }}</td>
                            </tr>
                            @endif

                            @if($data->database_name)
                            <tr>
                                <th>Database Name</th>
                                <td>{{ $data->database_name }}</td>
                            </tr>
                            @endif

                            @if($data->query)
                            <tr>
                                <th>Query</th>
                                <td>{{ $data->query }}</td>
                            </tr>
                            @endif

                            @if($data->description)
                            <tr>
                                <th>Description</th>
                                <td>{{ $data->description }}</td>
                            </tr>
                            @endif

                            @if($data->scan_type)
                            <tr>
                                <th>Scan Type</th>
                                <td>{{ $data->scan_type }}</td>
                            </tr>
                            @endif

                            @if($data->repository_url)
                            <tr>
                                <th>Repository URL</th>
                                <td>{{ $data->repository_url }}</td>
                            </tr>
                            @endif

                            @if($data->branch_name)
                            <tr>
                                <th>Branch Name</th>
                                <td>{{ $data->branch_name }}</td>
                            </tr>
                            @endif

                            @if($data->pr_url)
                            <tr>
                                <th>PR URL</th>
                                <td>{{ $data->pr_url }}</td>
                            </tr>
                            @endif

                            @if($data->purpose)
                            <tr>
                                <th>Purpose</th>
                                <td>{{ $data->purpose }}</td>
                            </tr>
                            @endif
                        </table>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ url('developer-request-onprogress') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@push('script')

@endpush
