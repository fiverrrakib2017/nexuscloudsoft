@extends('Backend.Layout.App')

@section('title', 'Manage Clients Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Clients Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Clients Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Section Header Card -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-heading text-primary mr-2"></i>Edit Section Header</h3>
        </div>
        <form id="headerForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'Clients' }}" placeholder="e.g. Clients">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'We work with best clients' }}" placeholder="e.g. We work with best clients">
                        <span class="text-danger error-text header_sub_title_error"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" id="saveHeaderBtn" class="btn btn-primary font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Header
                </button>
            </div>
        </form>
    </div>

    <!-- Client Logos Table Card -->
    <div class="card card-success card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-handshake text-success mr-2"></i>Client Logos List</h3>
            <button type="button" class="btn btn-success btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New Client Logo
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 120px;">Logo</th>
                        <th>Client / Company Name</th>
                        <th>Target URL</th>
                        <th style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody id="itemTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD CLIENT MODAL ================= -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add Client Logo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Client Name (Optional)</label>
                        <input type="text" name="client_name" class="form-control" placeholder="e.g. Client 1">
                        <span class="text-danger error-text add_client_name_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Client Logo Image <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="logo" class="custom-file-input" id="addClientLogo" accept="image/*">
                            <label class="custom-file-label" for="addClientLogo">Choose Logo...</label>
                        </div>
                        <span class="text-danger error-text add_logo_error"></span>
                        <div class="mt-3 text-center">
                            <img id="add_logo_preview" src="{{ asset('assets/img/clients/client-1.png') }}" style="max-height: 80px;" class="img-thumbnail shadow-sm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Website URL (Optional)</label>
                        <input type="url" name="url" class="form-control" placeholder="https://example.com">
                        <span class="text-danger error-text add_url_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Save Logo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT CLIENT MODAL ================= -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Client Logo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Client Name (Optional)</label>
                        <input type="text" name="client_name" id="edit_client_name" class="form-control">
                        <span class="text-danger error-text edit_client_name_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Client Logo Image</label>
                        <div class="custom-file">
                            <input type="file" name="logo" class="custom-file-input" id="editClientLogo" accept="image/*">
                            <label class="custom-file-label" for="editClientLogo">Choose New Logo...</label>
                        </div>
                        <span class="text-danger error-text edit_logo_error"></span>
                        <div class="mt-3 text-center">
                            <img id="edit_logo_preview" src="" style="max-height: 80px;" class="img-thumbnail shadow-sm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Website URL (Optional)</label>
                        <input type="url" name="url" id="edit_url" class="form-control">
                        <span class="text-danger error-text edit_url_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Logo</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    fetchItems();

    // Image Live Preview (Add)
    $('#addClientLogo').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#add_logo_preview').attr('src', e.target.result); }
            reader.readAsDataURL(file);
        }
    });

    // Image Live Preview (Edit)
    $('#editClientLogo').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#edit_logo_preview').attr('src', e.target.result); }
            reader.readAsDataURL(file);
        }
    });

    // Header Form Update
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.clients.header.update') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Header');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.header_' + key + '_error').text(err[0]); });
                } else if (res.status === 200) {
                    Swal.fire('Success!', res.message, 'success');
                }
            }
        });
    });

    // Fetch Items List
    function fetchItems() {
        $.ajax({
            url: "{{ route('admin.clients.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        let logoUrl = item.logo ? `{{ asset('') }}${item.logo}` : `{{ asset('assets/img/clients/client-1.png') }}`;
                        let clientUrl = item.url ? `<a href="${item.url}" target="_blank">${item.url}</a>` : '<span class="text-muted">None</span>';

                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><img src="${logoUrl}" style="max-height: 40px; max-width: 100px;" class="img-fluid"></td>
                                <td class="font-weight-bold">${item.client_name ? item.client_name : 'N/A'}</td>
                                <td>${clientUrl}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="5" class="text-center text-muted">No Client Logos Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add Logo
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.clients.item.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Logo');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    $('#add_logo_preview').attr('src', `{{ asset('assets/img/clients/client-1.png') }}`);
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit Logo Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/clients-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    let c = res.client;
                    $('#edit_item_id').val(c.id);
                    $('#edit_client_name').val(c.client_name);
                    $('#edit_url').val(c.url);

                    let logoUrl = c.logo ? `{{ asset('') }}${c.logo}` : `{{ asset('assets/img/clients/client-1.png') }}`;
                    $('#edit_logo_preview').attr('src', logoUrl);
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update Logo
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let formData = new FormData(this);
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/clients-section/item-update') }}/${id}`,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Logo');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete Logo
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This client logo will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/clients-section/item-delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchItems();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection