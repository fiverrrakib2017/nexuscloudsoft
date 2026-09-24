@extends('Backend.Layout.App')

@section('title', 'Manage Alt Features Section')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .icon-select-box {
        max-height: 120px;
        overflow-y: auto;
        border: 1px solid #de2b2b2b;
        border-radius: 6px;
        padding: 8px;
        background-color: #f8f9fa;
    }
    .icon-btn {
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 3px;
        font-size: 18px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .icon-btn:hover, .icon-btn.active {
        background-color: #007bff;
        color: #fff !important;
        border-color: #007bff;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Alt Features Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Alt Features Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Header Image Card -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-image text-primary mr-2"></i>Edit Featured Side Image</h3>
        </div>
        <form id="headerForm" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8 form-group">
                        <label>Featured Side Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="headerImage" accept="image/*">
                            <label class="custom-file-label" for="headerImage">Choose New Image...</label>
                        </div>
                        <span class="text-danger error-text header_image_error"></span>
                    </div>

                    <div class="col-md-4 text-center">
                        <label class="d-block">Current Preview</label>
                        <img id="headerImagePreview" src="{{ isset($header->image) && file_exists(public_path($header->image)) ? asset($header->image) : asset('Frontend/assets/img/alt-features.png') }}" width="140" class="img-thumbnail rounded shadow-sm">
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" id="saveHeaderBtn" class="btn btn-primary font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Image
                </button>
            </div>
        </form>
    </div>

    <!-- Feature Items Table -->
    <div class="card card-info card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-boxes text-info mr-2"></i>Alt Feature Items List</h3>
            <button type="button" class="btn btn-info btn-sm font-weight-bold text-white ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New Alt Feature
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 80px;">Icon</th>
                        <th style="width: 200px;">Title</th>
                        <th>Description</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody id="itemTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD ITEM MODAL ================= -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add Alt Feature Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Feature Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. MikroTik Integration">
                        <span class="text-danger error-text add_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Short Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Manage PPPoE users, profiles, queues..."></textarea>
                        <span class="text-danger error-text add_description_error"></span>
                    </div>

                    <div class="row">
                        <!-- Icon Selection -->
                        <div class="col-md-6 form-group">
                            <label>Icon Class <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-router-fill fs-5" id="add_icon_preview"></i>
                                    </span>
                                </div>
                                <input type="text" name="icon" id="add_icon_input" class="form-control" value="bi bi-router-fill">
                            </div>
                            <span class="text-danger error-text add_icon_error"></span>

                            <small class="text-muted d-block mb-1 font-weight-bold">Select Icon:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-router-fill"><i class="bi bi-router-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-hdd-network-fill"><i class="bi bi-hdd-network-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-credit-card-fill"><i class="bi bi-credit-card-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-envelope-paper-fill"><i class="bi bi-envelope-paper-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-bar-chart-line-fill"><i class="bi bi-bar-chart-line-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cloud-check-fill"><i class="bi bi-cloud-check-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-shield-lock-fill"><i class="bi bi-shield-lock-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-speedometer2"><i class="bi bi-speedometer2"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cpu-fill"><i class="bi bi-cpu-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-diagram-3-fill"><i class="bi bi-diagram-3-fill"></i></button>
                            </div>
                        </div>

                        <!-- Icon Color Class -->
                        <div class="col-md-6 form-group">
                            <label>Icon Color Class <span class="text-danger">*</span></label>
                            <select name="color" id="add_color_select" class="form-control">
                                <option value="text-primary" class="text-primary font-weight-bold">Primary (Blue)</option>
                                <option value="text-success" class="text-success font-weight-bold">Success (Green)</option>
                                <option value="text-warning" class="text-warning font-weight-bold">Warning (Yellow/Orange)</option>
                                <option value="text-danger" class="text-danger font-weight-bold">Danger (Red)</option>
                                <option value="text-info" class="text-info font-weight-bold">Info (Cyan/Teal)</option>
                                <option value="text-secondary" class="text-secondary font-weight-bold">Secondary (Gray)</option>
                                <option value="text-dark" class="text-dark font-weight-bold">Dark (Black)</option>
                            </select>
                            <span class="text-danger error-text add_color_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-info font-weight-bold text-white"><i class="fas fa-save mr-1"></i> Save Alt Feature</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT ITEM MODAL ================= -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Alt Feature Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Feature Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        <span class="text-danger error-text edit_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Short Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        <span class="text-danger error-text edit_description_error"></span>
                    </div>

                    <div class="row">
                        <!-- Icon Selection -->
                        <div class="col-md-6 form-group">
                            <label>Icon Class <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-router-fill fs-5" id="edit_icon_preview"></i>
                                    </span>
                                </div>
                                <input type="text" name="icon" id="edit_icon_input" class="form-control">
                            </div>
                            <span class="text-danger error-text edit_icon_error"></span>

                            <small class="text-muted d-block mb-1 font-weight-bold">Select Icon:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-router-fill"><i class="bi bi-router-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-hdd-network-fill"><i class="bi bi-hdd-network-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-credit-card-fill"><i class="bi bi-credit-card-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-envelope-paper-fill"><i class="bi bi-envelope-paper-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-bar-chart-line-fill"><i class="bi bi-bar-chart-line-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cloud-check-fill"><i class="bi bi-cloud-check-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-shield-lock-fill"><i class="bi bi-shield-lock-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-speedometer2"><i class="bi bi-speedometer2"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cpu-fill"><i class="bi bi-cpu-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-diagram-3-fill"><i class="bi bi-diagram-3-fill"></i></button>
                            </div>
                        </div>

                        <!-- Icon Color Class -->
                        <div class="col-md-6 form-group">
                            <label>Icon Color Class <span class="text-danger">*</span></label>
                            <select name="color" id="edit_color_select" class="form-control">
                                <option value="text-primary" class="text-primary font-weight-bold">Primary (Blue)</option>
                                <option value="text-success" class="text-success font-weight-bold">Success (Green)</option>
                                <option value="text-warning" class="text-warning font-weight-bold">Warning (Yellow/Orange)</option>
                                <option value="text-danger" class="text-danger font-weight-bold">Danger (Red)</option>
                                <option value="text-info" class="text-info font-weight-bold">Info (Cyan/Teal)</option>
                                <option value="text-secondary" class="text-secondary font-weight-bold">Secondary (Gray)</option>
                                <option value="text-dark" class="text-dark font-weight-bold">Dark (Black)</option>
                            </select>
                            <span class="text-danger error-text edit_color_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Alt Feature</button>
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

    // Side Image Live Preview
    $('#headerImage').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#headerImagePreview').attr('src', e.target.result); }
            reader.readAsDataURL(file);
        }
    });

    // Icon & Color Live Previews
    $('#add_icon_input, #add_color_select').on('keyup change input', function() {
        let icon = $('#add_icon_input').val().trim();
        let color = $('#add_color_select').val();
        $('#add_icon_preview').attr('class', icon + ' ' + color + ' fs-5');
    });

    $(document).on('click', '.add-picker-icon', function() {
        let icon = $(this).data('icon');
        let color = $('#add_color_select').val();
        $('#add_icon_input').val(icon);
        $('#add_icon_preview').attr('class', icon + ' ' + color + ' fs-5');
    });

    $('#edit_icon_input, #edit_color_select').on('keyup change input', function() {
        let icon = $('#edit_icon_input').val().trim();
        let color = $('#edit_color_select').val();
        $('#edit_icon_preview').attr('class', icon + ' ' + color + ' fs-5');
    });

    $(document).on('click', '.edit-picker-icon', function() {
        let icon = $(this).data('icon');
        let color = $('#edit_color_select').val();
        $('#edit_icon_input').val(icon);
        $('#edit_icon_preview').attr('class', icon + ' ' + color + ' fs-5');
    });

    // Header Form Update
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.alt_features.header.update') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Image');
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
            url: "{{ route('admin.alt_features.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><i class="${item.icon} ${item.color} fs-3"></i></td>
                                <td class="font-weight-bold text-left">${item.title}</td>
                                <td class="text-left text-muted">${item.description}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="5" class="text-center text-muted">No Alt Feature Items Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add Item
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.alt_features.item.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Alt Feature');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    $('#add_icon_preview').attr('class', 'bi bi-router-fill text-primary fs-5');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit Item Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/alt-features-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_item_id').val(res.item.id);
                    $('#edit_title').val(res.item.title);
                    $('#edit_description').val(res.item.description);
                    $('#edit_icon_input').val(res.item.icon);
                    $('#edit_color_select').val(res.item.color);
                    $('#edit_icon_preview').attr('class', res.item.icon + ' ' + res.item.color + ' fs-5');
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update Item
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/alt-features-section/item-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Alt Feature');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete Item
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This item will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/alt-features-section/item-delete') }}/${id}`,
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