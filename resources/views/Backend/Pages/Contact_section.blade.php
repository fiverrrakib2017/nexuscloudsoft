@extends('Backend.Layout.App')

@section('title', 'Manage Contact Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Contact Section & Messages</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Contact Info Settings Form Card -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-address-book text-primary mr-2"></i>Edit Contact Info & Header</h3>
        </div>
        <form id="settingForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $setting->title ?? 'Contact' }}">
                        <span class="text-danger error-text title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $setting->sub_title ?? 'Contact Us' }}">
                        <span class="text-danger error-text sub_title_error"></span>
                    </div>
                </div>

                <hr>
                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle mr-1"></i> Address & Info Details</h6>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control" value="{{ $setting->address_line1 ?? 'A108 Adam Street' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control" value="{{ $setting->address_line2 ?? 'New York, NY 535022' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Phone 1</label>
                        <input type="text" name="phone1" class="form-control" value="{{ $setting->phone1 ?? '+1 5589 55488 55' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Phone 2</label>
                        <input type="text" name="phone2" class="form-control" value="{{ $setting->phone2 ?? '+1 6678 254445 41' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Email 1</label>
                        <input type="email" name="email1" class="form-control" value="{{ $setting->email1 ?? 'info@example.com' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Email 2</label>
                        <input type="email" name="email2" class="form-control" value="{{ $setting->email2 ?? 'contact@example.com' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Open Hours Days</label>
                        <input type="text" name="open_hours_days" class="form-control" value="{{ $setting->open_hours_days ?? 'Monday - Friday' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Open Hours Time</label>
                        <input type="text" name="open_hours_time" class="form-control" value="{{ $setting->open_hours_time ?? '9:00AM - 05:00PM' }}">
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" id="saveSettingBtn" class="btn btn-primary font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Save Contact Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Received Messages Table Card -->
    <div class="card card-danger card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-envelope text-danger mr-2"></i>Received Client Messages</h3>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Sender Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody id="messagesTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= VIEW MESSAGE MODAL ================= -->
<div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-envelope-open mr-1"></i> Message Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong class="text-muted">From:</strong>
                        <p id="msg_sender" class="font-weight-bold m-0"></p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <strong class="text-muted">Date:</strong>
                        <p id="msg_date" class="text-muted m-0"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong class="text-muted">Subject:</strong>
                    <h6 id="msg_subject" class="font-weight-bold text-dark"></h6>
                </div>
                <hr>
                <div>
                    <strong class="text-muted">Message Content:</strong>
                    <div id="msg_body" class="p-3 bg-light rounded mt-2 border"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    fetchMessages();

    // Save Settings Form
    $('#settingForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveSettingBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.contact.setting.update') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Contact Settings');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.' + key + '_error').text(err[0]); });
                } else if (res.status === 200) {
                    Swal.fire('Success!', res.message, 'success');
                }
            }
        });
    });

    // Fetch Messages
    function fetchMessages() {
        $.ajax({
            url: "{{ route('admin.contact.messages.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.messages.length > 0) {
                    $.each(res.messages, function (key, item) {
                        let formattedDate = new Date(item.created_at).toLocaleString();
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td class="font-weight-bold text-left">${item.name}</td>
                                <td class="text-left">${item.email}</td>
                                <td class="text-left">${item.subject}</td>
                                <td><span class="badge badge-light border">${formattedDate}</span></td>
                                <td>
                                    <button class="btn btn-info btn-sm viewMsgBtn" 
                                        data-name="${item.name}" 
                                        data-email="${item.email}" 
                                        data-subject="${item.subject}" 
                                        data-message="${item.message}" 
                                        data-date="${formattedDate}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm deleteMsgBtn" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="6" class="text-center text-muted">No Messages Received Yet!</td></tr>`;
                }
                $('#messagesTableBody').html(html);
            }
        });
    }

    // View Message Trigger
    $(document).on('click', '.viewMsgBtn', function () {
        let name = $(this).data('name');
        let email = $(this).data('email');
        let subject = $(this).data('subject');
        let message = $(this).data('message');
        let date = $(this).data('date');

        $('#msg_sender').text(`${name} (${email})`);
        $('#msg_date').text(date);
        $('#msg_subject').text(subject);
        $('#msg_body').text(message);
        $('#viewMessageModal').modal('show');
    });

    // Delete Message
    $(document).on('click', '.deleteMsgBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This message will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/contact-section/message-delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchMessages();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection