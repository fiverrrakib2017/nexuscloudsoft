@extends('Backend.Layout.App')

@section('title', 'Manage Services Section')

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
    .badge-cyan { background-color: #0dcaf0; color: #fff; }
    .badge-orange { background-color: #fd7e14; color: #fff; }
    .badge-teal { background-color: #20c997; color: #fff; }
    .badge-red { background-color: #dc3545; color: #fff; }
    .badge-indigo { background-color: #6610f2; color: #fff; }
    .badge-pink { background-color: #d63384; color: #fff; }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Services / Solutions Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Our Services Solution</li>
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
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'Our Services Solutions' }}" placeholder="e.g. Our Solutions">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'Everything You Need to Run Your ISP Business' }}" placeholder="e.g. Everything You Need to Run Your ISP Business">
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

    <!-- Service Items Table Card -->
    <div class="card card-info card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-th-large text-info mr-2"></i>Service Items List</h3>
            <button type="button" class="btn btn-info btn-sm font-weight-bold text-white ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New Service
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 80px;">Icon</th>
                        <th style="width: 120px;">Theme Color</th>
                        <th style="width: 200px;">Title</th>
                        <th>Description</th>
                        <th style="width: 120px;">Button Text</th>
                        <th style="width: 130px;">Action</th>
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
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add New Service Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Service Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. MikroTik Automation">
                        <span class="text-danger error-text add_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Automate PPPoE user creation, suspension..."></textarea>
                        <span class="text-danger error-text add_description_error"></span>
                    </div>

                    <div class="row">
                        <!-- Icon Selector -->
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

                            <small class="text-muted d-block mb-1 font-weight-bold">Select Icon Quick Picker:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-router-fill"><i class="bi bi-router-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-hdd-network-fill"><i class="bi bi-hdd-network-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-credit-card-2-front-fill"><i class="bi bi-credit-card-2-front-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-graph-up-arrow"><i class="bi bi-graph-up-arrow"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-building-fill-gear"><i class="bi bi-building-fill-gear"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-headset"><i class="bi bi-headset"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-shield-check"><i class="bi bi-shield-check"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-speedometer"><i class="bi bi-speedometer"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cpu"><i class="bi bi-cpu"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cloud-arrow-up-fill"><i class="bi bi-cloud-arrow-up-fill"></i></button>
                            </div>
                        </div>

                        <!-- Card Theme Color -->
                        <div class="col-md-6 form-group">
                            <label>Service Card Theme Color <span class="text-danger">*</span></label>
                            <select name="color_class" class="form-control font-weight-bold">
                                <option value="item-cyan" class="text-info">Cyan (item-cyan)</option>
                                <option value="item-orange" class="text-warning">Orange (item-orange)</option>
                                <option value="item-teal" class="text-success">Teal (item-teal)</option>
                                <option value="item-red" class="text-danger">Red (item-red)</option>
                                <option value="item-indigo" class="text-primary">Indigo (item-indigo)</option>
                                <option value="item-pink" class="text-pink">Pink (item-pink)</option>
                            </select>
                            <span class="text-danger error-text add_color_class_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Button Text</label>
                            <input type="text" name="btn_text" class="form-control" value="Learn More" placeholder="Learn More">
                            <span class="text-danger error-text add_btn_text_error"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button Link / URL</label>
                            <input type="text" name="btn_link" class="form-control" value="#" placeholder="#">
                            <span class="text-danger error-text add_btn_link_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-info font-weight-bold text-white"><i class="fas fa-save mr-1"></i> Save Service</button>
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
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Service Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Service Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        <span class="text-danger error-text edit_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        <span class="text-danger error-text edit_description_error"></span>
                    </div>

                    <div class="row">
                        <!-- Icon Selector -->
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

                            <small class="text-muted d-block mb-1 font-weight-bold">Select Icon Quick Picker:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-router-fill"><i class="bi bi-router-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-hdd-network-fill"><i class="bi bi-hdd-network-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-credit-card-2-front-fill"><i class="bi bi-credit-card-2-front-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-graph-up-arrow"><i class="bi bi-graph-up-arrow"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-building-fill-gear"><i class="bi bi-building-fill-gear"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-headset"><i class="bi bi-headset"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-shield-check"><i class="bi bi-shield-check"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-speedometer"><i class="bi bi-speedometer"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cpu"><i class="bi bi-cpu"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cloud-arrow-up-fill"><i class="bi bi-cloud-arrow-up-fill"></i></button>
                            </div>
                        </div>

                        <!-- Card Theme Color -->
                        <div class="col-md-6 form-group">
                            <label>Service Card Theme Color <span class="text-danger">*</span></label>
                            <select name="color_class" id="edit_color_class" class="form-control font-weight-bold">
                                <option value="item-cyan" class="text-info">Cyan (item-cyan)</option>
                                <option value="item-orange" class="text-warning">Orange (item-orange)</option>
                                <option value="item-teal" class="text-success">Teal (item-teal)</option>
                                <option value="item-red" class="text-danger">Red (item-red)</option>
                                <option value="item-indigo" class="text-primary">Indigo (item-indigo)</option>
                                <option value="item-pink" class="text-pink">Pink (item-pink)</option>
                            </select>
                            <span class="text-danger error-text edit_color_class_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Button Text</label>
                            <input type="text" name="btn_text" id="edit_btn_text" class="form-control">
                            <span class="text-danger error-text edit_btn_text_error"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button Link / URL</label>
                            <input type="text" name="btn_link" id="edit_btn_link" class="form-control">
                            <span class="text-danger error-text edit_btn_link_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Service</button>
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

    // Live Icon Preview
    $('#add_icon_input').on('keyup change input', function() {
        $('#add_icon_preview').attr('class', $(this).val().trim() + ' fs-5');
    });

    $(document).on('click', '.add-picker-icon', function() {
        let icon = $(this).data('icon');$('#add_icon_input').val(icon);
        $('#add_icon_preview').attr('class', icon + ' fs-5');
    });

    $('#edit_icon_input').on('keyup change input', function() {
        $('#edit_icon_preview').attr('class', $(this).val().trim() + ' fs-5');
    });

    $(document).on('click', '.edit-picker-icon', function() {
        let icon = $(this).data('icon');$('#edit_icon_input').val(icon);
        $('#edit_icon_preview').attr('class', icon + ' fs-5');
    });

    // Update Header Form
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.services.header.update') }}",
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
            url: "{{ route('admin.services.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        let badgeClass = 'badge-secondary';
                        if (item.color_class === 'item-cyan') badgeClass = 'badge-cyan';
                        else if (item.color_class === 'item-orange') badgeClass = 'badge-orange';
                        else if (item.color_class === 'item-teal') badgeClass = 'badge-teal';
                        else if (item.color_class === 'item-red') badgeClass = 'badge-red';
                        else if (item.color_class === 'item-indigo') badgeClass = 'badge-indigo';
                        else if (item.color_class === 'item-pink') badgeClass = 'badge-pink';

                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><i class="${item.icon} fs-3"></i></td>
                                <td><span class="badge ${badgeClass} p-2">${item.color_class}</span></td>
                                <td class="font-weight-bold text-left">${item.title}</td>
                                <td class="text-left text-muted">${item.description}</td>
                                <td><span class="badge badge-light border p-1">${item.btn_text ?? 'Learn More'}</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="7" class="text-center text-muted">No Service Items Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add Service Item
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.services.item.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Service');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    $('#add_icon_preview').attr('class', 'bi bi-router-fill fs-5');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit Service Item Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/services-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_item_id').val(res.item.id);
                    $('#edit_title').val(res.item.title);
                    $('#edit_description').val(res.item.description);
                    $('#edit_icon_input').val(res.item.icon);
                    $('#edit_color_class').val(res.item.color_class);
                    $('#edit_btn_text').val(res.item.btn_text);
                    $('#edit_btn_link').val(res.item.btn_link);
                    $('#edit_icon_preview').attr('class', res.item.icon + ' fs-5');
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update Service Item
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/services-section/item-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Service');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete Service Item
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
                    url: `{{ url('admin/services-section/item-delete') }}/${id}`,
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