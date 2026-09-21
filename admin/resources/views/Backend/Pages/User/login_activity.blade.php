@extends('Backend.Layout.App')
@section('title', ' User Logs Management | Admin Panel')
@section('style')
<style>
/* Table Header Design */
#user_logs_datatable thead th {

    background: #f8fafc !important;
    font-size: 15px;
}

/* Header Icons */
#user_logs_datatable thead th i {

    color: #64748b;

    font-size: 12px;

    margin-right: 4px;

    font-weight: normal;
}

/* Table Body */
#user_logs_datatable tbody td {

    font-size: 15px;

}

/* Hover Effect */
#user_logs_datatable tbody tr:hover {

    background: #f8fafc;
}

/* DataTable Search */
.dataTables_filter input {

    border-radius: 8px !important;

    border: 1px solid #dbeafe !important;

    padding: 6px 12px !important;
}

/* Pagination */
.page-item.active .page-link {

    background: #0d6efd !important;

    border-color: #0d6efd !important;
}

/* Table */
#user_logs_datatable {

    border-collapse: separate;

    border-spacing: 0;
}
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                @include('Backend.Component.Common.card-header', [
                    'title' => 'Login Activity Report',
                    'description' => 'Monitor admin and customer login activity, sessions, failed logins and access history',
                    'icon' => '<i class="fas fa-user-shield"></i>',
                ])

                <div class="card-header bg-light">

                    <div class="row align-items-end">

                        <div class="col-md-3">

                            <label class="fw-bold">
                                <i class="fas fa-calendar-alt text-primary"></i>
                                From Date
                            </label>

                            <input
                                type="date"
                                id="from_date"
                                class="form-control">

                        </div>

                        <div class="col-md-3">

                            <label class="fw-bold">
                                <i class="fas fa-calendar-check text-success"></i>
                                To Date
                            </label>

                            <input
                                type="date"
                                id="to_date"
                                class="form-control">

                        </div>

                        <div class="col-md-6 text-end">

                            <button
                                class="btn btn-primary"
                                id="filterBtn">

                                <i class="fas fa-search"></i>
                                Filter

                            </button>

                            <button
                                class="btn btn-danger"
                                onclick="loadData()">

                                <i class="fas fa-sync"></i>
                                Refresh

                            </button>

                            <button
                                class="btn btn-success"
                                onclick="window.print()">

                                <i class="fas fa-print"></i>
                                Print

                            </button>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="user_logs_datatable">

                       <thead>

                        <tr>

                            <th width="50">
                                #
                            </th>

                            <th>
                                <i class="fas fa-user-shield"></i>
                                User Type
                            </th>

                            <th>
                                <i class="fas fa-user"></i>
                                Username / Email
                            </th>

                            <th>
                                <i class="fas fa-network-wired"></i>
                                IP Address
                            </th>

                            <th>
                                <i class="fas fa-check-circle"></i>
                                Status
                            </th>

                            <th>
                                <i class="fas fa-sign-in-alt"></i>
                                Login Time
                            </th>

                            <th>
                                <i class="fas fa-sign-out-alt"></i>
                                Logout Time
                            </th>

                            @can('manage.user.logs.delete')
                                <th width="80">
                                    <i class="fas fa-cogs"></i>
                                    Action
                                </th>
                            @endcan

                        </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

    <div id="deleteModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <form action="{{ route('admin.user.logs.delete') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <div class="icon-box">
                            <i class="fas fa-trash"></i>
                        </div>
                        <h4 class="modal-title w-100">Are you sure?</h4>
                        <input type="hidden" name="id" value="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        let table;
        window.permissions = {
            canDelete: @json(auth('admin')->user()->can('manage.user.logs.delete')),
        };
        $(document).ready(function () {
            $("#user_logs_datatable").DataTable();

            table = $('#user_logs_datatable').DataTable({
                destroy: true,
                pageLength: 25,
                ordering: true,
                responsive: true
            });

            loadData();

            $('#filterBtn').on('click', function () {
                loadData();
            });

        });

        function loadData()
        {
            $.ajax({

                url: "{{ route('admin.user.logs.get_data') }}",

                type: "GET",

                data: {

                    from_date : $('#from_date').val(),
                    to_date   : $('#to_date').val()

                },

                success: function(response)
                {
                    table.clear();

                    $.each(response, function(index, row){

                        let statusBadge = '';

                        if(row.status === 'success')
                        {
                            statusBadge =
                                '<span class="badge bg-success">Success</span>';
                        }
                        else
                        {
                            statusBadge =
                                '<span class="badge bg-danger">Failed</span>';
                        }

                        let userTypeBadge = '';

                        if(row.user_type === 'admin')
                        {
                            userTypeBadge =
                                '<span class="badge bg-primary">Admin</span>';
                        }
                        else if(row.user_type === 'customer')
                        {
                            userTypeBadge =
                                '<span class="badge bg-info">Customer</span>';
                        }
                        else
                        {
                            userTypeBadge =
                                '<span class="badge bg-secondary">Unknown</span>';
                        }

                        let actionBtn = '';

                        if(window.permissions.canDelete)
                        {
                            actionBtn = `
                                <button
                                    class="btn btn-sm btn-danger delete-btn"
                                    data-id="${row.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        }

                        table.row.add([
                            index + 1,
                            userTypeBadge,
                            row.username ?? '',
                            row.ip_address ?? '',
                            statusBadge,
                            row.login_at ?? '',
                            row.logout_at ?? '-',
                            actionBtn
                        ]);
                    });

                    table.draw();
                }
            });
        }

        /** Handle Delete button click**/
        $('#user_logs_datatable tbody').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var deleteUrl = "{{ route('admin.user.logs.delete', ':id') }}".replace(':id', id);

            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteModal').find('input[name="id"]').val(id);
            $('#deleteModal').modal('show');
        });
        $('#deleteModal form').submit(function(e) {
            e.preventDefault();
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#deleteModal').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseText);
                },
                complete: function() {
                    submitBtn.html(originalBtnText);
                }
            });
        });
    </script>
@endsection
