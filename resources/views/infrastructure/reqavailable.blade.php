@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $title ?? '' }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Infrastructure Available</div>
                </div>
            </div>

            <div id="session" data-session="{{ session('success') }}"></div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="mb-3 d-flex justify-content-end gap-3">
                            <a href="{{ route('infrastructure-complated.create') }}" class="btn btn-primary btn-sm ml-2">Tambah data</a>
                        </div> -->
                        <table id="infraAvailableTable" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Request</th>
                                    <th>Name</th>
                                    <th>Type Request</th>
                                    <th>Tanggal Request</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        This is card footer
                    </div>
                </div>
            </div>


        </section>


    </div>
@endsection



@push('script')
    <script>
        $(document).ready(function() {

            let session = $('#session').data('session');

            if (session) {
                Swal.fire({
                    title: "Sukses!",
                    text: session,
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: true
                });
            }

            // table data
            $('#infraAvailableTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('infrastructure-available') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'request_type_name',
                        name: 'request_type_name'
                    },
                    {
                        data: 'request_date',
                        name: 'request_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            // Event listener untuk tombol hapus
            // $('#reqtypeTable').on('click', '.delete-btn', function () {
            //     var reqtypeId = $(this).data('id');

            //     Swal.fire({
            //         title: "Apakah Anda yakin?",
            //         text: "Data akan dihapus secara permanen!",
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: "#d33",
            //         cancelButtonColor: "#3085d6",
            //         confirmButtonText: "Ya, Hapus!",
            //         cancelButtonText: "Batal"
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 url: '/requesttypes/' + reqtypeId,
            //                 type: 'DELETE',
            //                 data: {
            //                     _token: '{{ csrf_token() }}'
            //                 },
            //                 success: function(response){
            //                 if(response.success == 1){
            //                     alert("Record deleted.");
            //                     var oTable = $('#reqtypeTable').dataTable();
            //                     oTable.fnDraw(false);
            //                 }else{
            //                         alert("Invalid ID.");
            //                     }
            //                 },

            //             });
            //         }
            //     });
            // });


        });
    </script>
@endpush
