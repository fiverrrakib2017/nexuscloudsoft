@extends('Backend.Layout.App')

@section('title', 'Client Demo Requests')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-desktop text-primary mr-2"></i>Client Demo Requests</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Demo Requests</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-list mr-1"></i> Received Demo Requests</h3>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th class="text-left">Company Name</th>
                        <th class="text-left">Contact Person</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>User Count</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width: 130px;">Action</th>
                    </tr>
                </thead>
                <tbody id="demoTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= VIEW DETAILS MODAL ================= -->
<div class="modal fade" id="viewDemoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-info-circle mr-1"></i> Demo Request Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>ISP / Company Name:</strong>
                        <p id="detail_company" class="text-primary font-weight-bold h5 m-0"></p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <strong>Requested Date:</strong>
                        <p id="detail_date" class="text-muted m-0"></p>
                    </div>
                </div>

                <div class="row p-3 bg-light rounded border mb-3">
                    <div class="col-md-6 mb-2"><strong>Contact Person:</strong> <span id="detail_name"></span></div>
                    <div class="col-md-6 mb-2"><strong>Phone:</strong> <a href="" id="detail_phone_link"><span id="detail_phone" class="text-dark font-weight-bold"></span></a></div>
                    <div class="col-md-6 mb-2"><strong>Email:</strong> <span id="detail_email"></span></div>
                    <div class="col-md-6 mb-2"><strong>District / Location:</strong> <span id="detail_district"></span></div>
                    <div class="col-md-6"><strong>Active Users:</strong> <span id="detail_user_count" class="badge badge-info"></span></div>
                </div>

                <div class="mb-3">
                    <strong>Client Message / Requirements:</strong>
                    <div id="detail_message" class="p-3 bg-white border rounded mt-1"></div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="font-weight-bold">Update Request Status:</label>
                    <input type="hidden" id="current_demo_id">
                    <select id="update_status_select" class="form-control font-weight-bold">
                        <option value="pending">⏳ Pending (New Request)</option>
                        <option value="contacted">📞 Contacted Client</option>
                        <option value="completed">✅ Demo Completed</option>
                        <option value="rejected">❌ Cancelled / Rejected</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveStatusBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Status</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    fetchData();

    // Fetch Data List
    function fetchData() {
        $.ajax({
            url: "{{ route('admin.demo_requests.get.data') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.requests.length > 0) {
                    $.each(res.requests, function (key, item) {
                        let date = new Date(item.created_at).toLocaleDateString('en-GB');

                        let statusBadge = '';
                        if(item.status === 'pending') statusBadge = '<span class="badge badge-warning">Pending</span>';
                        else if(item.status === 'contacted') statusBadge = '<span class="badge badge-info">Contacted</span>';
                        else if(item.status === 'completed') statusBadge = '<span class="badge badge-success">Completed</span>';
                        else if(item.status === 'rejected') statusBadge = '<span class="badge badge-danger">Rejected</span>';

                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td class="font-weight-bold text-left">${item.company_name}</td>
                                <td class="text-left">${item.name}</td>
                                <td><a href="tel:${item.phone}" class="font-weight-bold">${item.phone}</a></td>
                                <td>${item.district ? item.district : 'N/A'}</td>
                                <td><span class="badge badge-light border">${item.user_count ? item.user_count : 'N/A'}</span></td>
                                <td>${statusBadge}</td>
                                <td>${date}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm viewBtn" 
                                        data-id="${item.id}"
                                        data-company="${item.company_name}"
                                        data-name="${item.name}"
                                        data-phone="${item.phone}"
                                        data-email="${item.email}"
                                        data-district="${item.district ? item.district : 'N/A'}"
                                        data-users="${item.user_count ? item.user_count : 'N/A'}"
                                        data-message="${item.message ? item.message : 'No message provided.'}"
                                        data-status="${item.status}"
                                        data-date="${date}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="9" class="text-center text-muted">No Demo Requests Received Yet!</td></tr>`;
                }
                $('#demoTableBody').html(html);
            }
        });
    }

    // View Modal Trigger
    $(document).on('click', '.viewBtn', function () {
        let id = $(this).data('id');$('#current_demo_id').val(id);
        $('#detail_company').text($(this).data('company'));
        $('#detail_name').text($(this).data('name'));
        $('#detail_phone').text($(this).data('phone'));
        $('#detail_phone_link').attr('href', 'tel:' + $(this).data('phone'));
        $('#detail_email').text($(this).data('email'));
        $('#detail_district').text($(this).data('district'));
        $('#detail_user_count').text($(this).data('users'));
        $('#detail_message').text($(this).data('message'));
        $('#detail_date').text($(this).data('date'));
        $('#update_status_select').val($(this).data('status'));

        $('#viewDemoModal').modal('show');
    });

    // Update Status
    $('#saveStatusBtn').on('click', function () {
        let id = $('#current_demo_id').val();
        let status = $('#update_status_select').val();

        $.ajax({
            url: `{{ url('admin/demo-requests/status-update') }}/${id}`,
            type: "POST",
            data: { status: status },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                if (res.status === 200) {
                    $('#viewDemoModal').modal('hide');
                    Swal.fire('Updated!', res.message, 'success');
                    fetchData();
                }
            }
        });
    });

    // Delete Request
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This request will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/demo-requests/delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchData();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection