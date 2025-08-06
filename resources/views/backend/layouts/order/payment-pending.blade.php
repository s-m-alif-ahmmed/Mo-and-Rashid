@extends('backend.app')

@section('title', 'Pending Payment Orders')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pending Payment Orders</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending Payment Orders</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom" style="margin-bottom: 0; display: flex; justify-content: space-between;">
                    <h3 class="card-title">Pending Payment Orders Table</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Order At</th>
                                <th class="wd-15p border-bottom-0">Order ID</th>
                                <th class="wd-20p border-bottom-0">Status</th>
                                <th class="wd-15p border-bottom-0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- dynamic data --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            if (!$.fn.DataTable.isDataTable('#datatable')) {
                let dTable = $('#datatable').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>`
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('order.index.pending.payment') }}",
                        type: "GET",
                    },

                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'tracking_id',
                            name: 'tracking_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                dTable.buttons().container().appendTo('#file_exports');
                new DataTable('#example', {
                    responsive: true
                });
            }
        });

        // Status Change Confirm Alert
        function showStatusChangeAlert(event, id) {
            event.preventDefault();
            let selectedStatus = $(event.target).val(); // Get the selected status value

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to update the status to ' + selectedStatus + '?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    statusChange(id, selectedStatus); // Pass the selected status
                }
            });
        }

        // Status Change
        function statusChange(id, status) {
            let url = '{{ route('order.status', ':id') }}';
            $.ajax({
                type: "POST", // Change to POST
                url: url.replace(':id', id),
                data: { status: status }, // Send status in the request body
                success: function(resp) {
                    console.log(resp);
                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // Show toast message
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }

        // Delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Item
        function deleteItem(id) {
            let url = '{{ route('order.destroy', ':id') }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                success: function(resp) {
                    $('#datatable').DataTable().ajax.reload();
                    toastr[resp.success ? 'success' : 'error'](resp.message);
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    </script>
@endpush
