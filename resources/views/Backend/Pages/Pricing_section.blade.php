@extends('Backend.Layout.App')

@section('title', 'Manage Pricing Section')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .icon-select-box {
        max-height: 100px;
        overflow-y: auto;
        border: 1px solid #de2b2b2b;
        border-radius: 6px;
        padding: 6px;
        background-color: #f8f9fa;
    }
    .icon-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 2px;
        font-size: 16px;
        border-radius: 6px;
    }
    .tier-row {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 8px;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Pricing Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pricing Section</li>
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
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'Pricing' }}" placeholder="e.g. Pricing">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'Choose the Perfect Plan for Your ISP Business' }}" placeholder="e.g. Choose the Perfect Plan for Your ISP Business">
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

    <!-- Pricing Plans Table Card -->
    <div class="card card-success card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-tags text-success mr-2"></i>Pricing Plans List</h3>
            <button type="button" class="btn btn-success btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addPlanModal">
                <i class="fas fa-plus mr-1"></i> Add New Pricing Plan
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 70px;">Icon</th>
                        <th>Plan Name</th>
                        <th>Setup Fee</th>
                        <th>Theme Color</th>
                        <th>Featured?</th>
                        <th>Total Tiers</th>
                        <th style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody id="planTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD PLAN MODAL ================= -->
<div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add New Pricing Plan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPlanForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Plan Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Basic / Standard / Premium">
                            <span class="text-danger error-text add_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Setup Fee <span class="text-danger">*</span></label>
                            <input type="text" name="setup_fee" class="form-control" placeholder="e.g. ৳2,000">
                            <span class="text-danger error-text add_setup_fee_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Setup Label</label>
                            <input type="text" name="setup_label" class="form-control" value="One-time Setup Charge" placeholder="One-time Setup Charge">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Theme Color <span class="text-danger">*</span></label>
                            <select name="theme_color" class="form-control font-weight-bold">
                                <option value="#0d6efd" style="color:#0d6efd;">Blue (#0d6efd - Basic)</option>
                                <option value="#20c997" style="color:#20c997;">Teal / Green (#20c997 - Standard)</option>
                                <option value="#6f42c1" style="color:#6f42c1;">Purple (#6f42c1 - Premium)</option>
                                <option value="#fd7e14" style="color:#fd7e14;">Orange (#fd7e14)</option>
                                <option value="#dc3545" style="color:#dc3545;">Red (#dc3545)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Icon Selector -->
                        <div class="col-md-6 form-group">
                            <label>Icon Class <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="bi bi-box fs-5" id="add_icon_preview"></i></span>
                                </div>
                                <input type="text" name="icon" id="add_icon_input" class="form-control" value="bi bi-box">
                            </div>

                            <small class="text-muted d-block mb-1 font-weight-bold">Quick Select Icon:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-box"><i class="bi bi-box"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-star-fill"><i class="bi bi-star-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-gem"><i class="bi bi-gem"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-rocket-takeoff-fill"><i class="bi bi-rocket-takeoff-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-shield-check"><i class="bi bi-shield-check"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-award-fill"><i class="bi bi-award-fill"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="add_is_featured" name="is_featured" value="1">
                                <label class="custom-control-label font-weight-bold text-success" for="add_is_featured">Mark as Featured / Most Popular Plan</label>
                            </div>
                            <div class="mt-2">
                                <label>Featured Badge Text</label>
                                <input type="text" name="badge_text" class="form-control" value="Most Popular" placeholder="e.g. Most Popular">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Button Text</label>
                            <input type="text" name="btn_text" class="form-control" value="Get Started" placeholder="e.g. Get Started / Choose Standard">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button Link</label>
                            <input type="text" name="btn_link" class="form-control" value="#" placeholder="#">
                        </div>
                    </div>

                    <hr>
                    <!-- Pricing Tiers Repeater Section -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-weight-bold text-dark m-0"><i class="fas fa-list text-primary mr-1"></i> User Pricing Tiers</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold" id="addTierRowBtn"><i class="fas fa-plus"></i> Add Tier Row</button>
                    </div>

                    <div id="addTierContainer">
                        <!-- Initial Default Rows -->
                        <div class="row tier-row align-items-center">
                            <div class="col-md-5">
                                <input type="text" name="user_ranges[]" class="form-control form-control-sm" value="1 - 300 Users" placeholder="User Range (e.g. 1 - 300 Users)" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="prices[]" class="form-control form-control-sm" value="৳1,000 / mo" placeholder="Monthly Price (e.g. ৳1,000 / mo)" required>
                            </div>
                            <div class="col-md-2 text-center">
                                <button type="button" class="btn btn-sm btn-danger removeTierRow"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addPlanBtn" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Save Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT PLAN MODAL ================= -->
<div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Pricing Plan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPlanForm">
                @csrf
                <input type="hidden" id="edit_plan_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Plan Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <span class="text-danger error-text edit_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Setup Fee <span class="text-danger">*</span></label>
                            <input type="text" name="setup_fee" id="edit_setup_fee" class="form-control">
                            <span class="text-danger error-text edit_setup_fee_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Setup Label</label>
                            <input type="text" name="setup_label" id="edit_setup_label" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Theme Color <span class="text-danger">*</span></label>
                            <select name="theme_color" id="edit_theme_color" class="form-control font-weight-bold">
                                <option value="#0d6efd" style="color:#0d6efd;">Blue (#0d6efd - Basic)</option>
                                <option value="#20c997" style="color:#20c997;">Teal / Green (#20c997 - Standard)</option>
                                <option value="#6f42c1" style="color:#6f42c1;">Purple (#6f42c1 - Premium)</option>
                                <option value="#fd7e14" style="color:#fd7e14;">Orange (#fd7e14)</option>
                                <option value="#dc3545" style="color:#dc3545;">Red (#dc3545)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Icon Selector -->
                        <div class="col-md-6 form-group">
                            <label>Icon Class <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="bi bi-box fs-5" id="edit_icon_preview"></i></span>
                                </div>
                                <input type="text" name="icon" id="edit_icon_input" class="form-control">
                            </div>

                            <small class="text-muted d-block mb-1 font-weight-bold">Quick Select Icon:</small>
                            <div class="icon-select-box">
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-box"><i class="bi bi-box"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-star-fill"><i class="bi bi-star-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-gem"><i class="bi bi-gem"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-rocket-takeoff-fill"><i class="bi bi-rocket-takeoff-fill"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-shield-check"><i class="bi bi-shield-check"></i></button>
                                <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-award-fill"><i class="bi bi-award-fill"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="edit_is_featured" name="is_featured" value="1">
                                <label class="custom-control-label font-weight-bold text-success" for="edit_is_featured">Mark as Featured / Most Popular Plan</label>
                            </div>
                            <div class="mt-2">
                                <label>Featured Badge Text</label>
                                <input type="text" name="badge_text" id="edit_badge_text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Button Text</label>
                            <input type="text" name="btn_text" id="edit_btn_text" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button Link</label>
                            <input type="text" name="btn_link" id="edit_btn_link" class="form-control">
                        </div>
                    </div>

                    <hr>
                    <!-- Pricing Tiers Repeater Section -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-weight-bold text-dark m-0"><i class="fas fa-list text-primary mr-1"></i> User Pricing Tiers</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold" id="editTierRowBtn"><i class="fas fa-plus"></i> Add Tier Row</button>
                    </div>

                    <div id="editTierContainer">
                        <!-- Loaded via AJAX -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editPlanBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Plan</button>
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

    fetchPlans();

    // Icon Live Select
    $('#add_icon_input').on('keyup change input', function() { $('#add_icon_preview').attr('class', $(this).val().trim() + ' fs-5'); });$(document).on('click', '.add-picker-icon', function() {
        let icon = $(this).data('icon');$('#add_icon_input').val(icon);
        $('#add_icon_preview').attr('class', icon + ' fs-5');
    });

    $('#edit_icon_input').on('keyup change input', function() { $('#edit_icon_preview').attr('class', $(this).val().trim() + ' fs-5'); });$(document).on('click', '.edit-picker-icon', function() {
        let icon = $(this).data('icon');$('#edit_icon_input').val(icon);
        $('#edit_icon_preview').attr('class', icon + ' fs-5');
    });

    // Add Tier Row JS
    $('#addTierRowBtn').on('click', function() {
        let rowHtml = `
            <div class="row tier-row align-items-center">
                <div class="col-md-5">
                    <input type="text" name="user_ranges[]" class="form-control form-control-sm" placeholder="User Range (e.g. 301 - 500 Users)" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="prices[]" class="form-control form-control-sm" placeholder="Monthly Price (e.g. ৳1,500 / mo)" required>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-danger removeTierRow"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        $('#addTierContainer').append(rowHtml);
    });

    $('#editTierRowBtn').on('click', function() {
        let rowHtml = `
            <div class="row tier-row align-items-center">
                <div class="col-md-5">
                    <input type="text" name="user_ranges[]" class="form-control form-control-sm" placeholder="User Range (e.g. 301 - 500 Users)" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="prices[]" class="form-control form-control-sm" placeholder="Monthly Price (e.g. ৳1,500 / mo)" required>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-sm btn-danger removeTierRow"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        $('#editTierContainer').append(rowHtml);
    });

    $(document).on('click', '.removeTierRow', function() {$(this).closest('.tier-row').remove();
    });

    // Update Section Header
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.pricing.header.update') }}",
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

    // Fetch Plans List
    function fetchPlans() {
        $.ajax({
            url: "{{ route('admin.pricing.plans.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.plans.length > 0) {
                    $.each(res.plans, function (key, plan) {
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><i class="${plan.icon} fs-4"></i></td>
                                <td class="font-weight-bold" style="color:${plan.theme_color};">${plan.name}</td>
                                <td><span class="badge badge-light border p-2 font-weight-bold">${plan.setup_fee}</span></td>
                                <td><span class="badge text-white p-2" style="background-color:${plan.theme_color};">${plan.theme_color}</span></td>
                                <td>${plan.is_featured ? '<span class="badge badge-success">Featured</span>' : '<span class="badge badge-secondary">Standard</span>'}</td>
                                <td><span class="badge badge-info p-2">${plan.tiers.length} Tiers</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${plan.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${plan.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="8" class="text-center text-muted">No Pricing Plans Found!</td></tr>`;
                }
                $('#planTableBody').html(html);
            }
        });
    }

    // Save Plan
    $('#addPlanForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addPlanBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.pricing.plan.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Plan');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addPlanModal').modal('hide');
                    $('#addPlanForm')[0].reset();
                    Swal.fire('Success!', res.message, 'success');
                    fetchPlans();
                }
            }
        });
    });

    // Edit Plan Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/pricing-section/plan-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    let plan = res.plan;
                    $('#edit_plan_id').val(plan.id);
                    $('#edit_name').val(plan.name);
                    $('#edit_setup_fee').val(plan.setup_fee);
                    $('#edit_setup_label').val(plan.setup_label);
                    $('#edit_theme_color').val(plan.theme_color);
                    $('#edit_icon_input').val(plan.icon);
                    $('#edit_icon_preview').attr('class', plan.icon + ' fs-5');
                    $('#edit_is_featured').prop('checked', plan.is_featured == 1);
                    $('#edit_badge_text').val(plan.badge_text);
                    $('#edit_btn_text').val(plan.btn_text);
                    $('#edit_btn_link').val(plan.btn_link);

                    // Load Tiers
                    let tierHtml = '';
                    if (plan.tiers.length > 0) {
                        $.each(plan.tiers, function(i, tier) {
                            tierHtml += `
                                <div class="row tier-row align-items-center">
                                    <div class="col-md-5">
                                        <input type="text" name="user_ranges[]" class="form-control form-control-sm" value="${tier.user_range}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="prices[]" class="form-control form-control-sm" value="${tier.price}" required>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button type="button" class="btn btn-sm btn-danger removeTierRow"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>`;
                        });
                    }
                    $('#editTierContainer').html(tierHtml);
                    $('#editPlanModal').modal('show');
                }
            }
        });
    });

    // Update Plan
    $('#editPlanForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_plan_id').val();
        let btn = $('#editPlanBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/pricing-section/plan-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Plan');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editPlanModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchPlans();
                }
            }
        });
    });

    // Delete Plan
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This plan and its pricing tiers will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/pricing-section/plan-delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchPlans();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection