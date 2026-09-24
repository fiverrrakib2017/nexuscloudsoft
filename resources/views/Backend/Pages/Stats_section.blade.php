@extends('Backend.Layout.App')

@section('title', 'Manage Counter Stats')

@section('style')
<!-- Bootstrap Icons CDN for Admin Preview -->
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
                <h1 class="m-0 font-weight-bold text-dark">Counter Stats Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stats Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-calculator text-primary mr-2"></i>Counter Items List</h3>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addStatModal">
                <i class="fas fa-plus mr-1"></i> Add New Counter Stat
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 80px;">Icon</th>
                        <th>Title</th>
                        <th>Count Value</th>
                        <th>Color</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody id="statTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD STAT MODAL ================= -->
<div class="modal fade" id="addStatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add Counter Stat</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addStatForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Stat Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Happy Clients">
                        <span class="text-danger error-text add_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Count Value / End Number <span class="text-danger">*</span></label>
                        <input type="number" name="count" class="form-control" placeholder="e.g. 232">
                        <span class="text-danger error-text add_count_error"></span>
                    </div>

                    <!-- Icon Selection with Visual Preview -->
                    <div class="form-group">
                        <label>Select or Type Icon Class <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light" id="add_icon_preview_wrapper">
                                    <i class="bi bi-emoji-smile fs-5" id="add_icon_preview" style="color: #4154f1;"></i>
                                </span>
                            </div>
                            <input type="text" name="icon" id="add_icon_input" class="form-control" placeholder="e.g. bi bi-emoji-smile" value="bi bi-emoji-smile">
                        </div>
                        <span class="text-danger error-text add_icon_error"></span>

                        <!-- Quick Icon Picker Grid -->
                        <small class="text-muted d-block mb-1 font-weight-bold">Click an icon to select:</small>
                        <div class="icon-select-box">
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-emoji-smile" title="Emoji Smile"><i class="bi bi-emoji-smile"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-journal-richtext" title="Journal"><i class="bi bi-journal-richtext"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-headset" title="Headset / Support"><i class="bi bi-headset"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-people" title="People / Team"><i class="bi bi-people"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-trophy" title="Trophy"><i class="bi bi-trophy"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-award" title="Award"><i class="bi bi-award"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-star" title="Star"><i class="bi bi-star"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-check-circle" title="Success"><i class="bi bi-check-circle"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-briefcase" title="Briefcase"><i class="bi bi-briefcase"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-diagram-3" title="Network / OLT"><i class="bi bi-diagram-3"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-graph-up-arrow" title="Growth"><i class="bi bi-graph-up-arrow"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-shield-check" title="Shield"><i class="bi bi-shield-check"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-display" title="Monitor / TV"><i class="bi bi-display"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cash-stack" title="Billing"><i class="bi bi-cash-stack"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-lightning-charge" title="Speed / Fast"><i class="bi bi-lightning-charge"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-globe" title="Internet / Globe"><i class="bi bi-globe"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-cpu" title="Router / Hardware"><i class="bi bi-cpu"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn add-picker-icon" data-icon="bi bi-heart" title="Heart"><i class="bi bi-heart"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Icon Color Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="add_color_picker" value="#4154f1" style="max-width: 60px;">
                            <input type="text" name="color" id="add_color_text" class="form-control" value="#4154f1" placeholder="#4154f1">
                        </div>
                        <span class="text-danger error-text add_color_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addStatBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Save Stat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT STAT MODAL ================= -->
<div class="modal fade" id="editStatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Counter Stat</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editStatForm">
                @csrf
                <input type="hidden" id="edit_stat_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Stat Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        <span class="text-danger error-text edit_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Count Value / End Number <span class="text-danger">*</span></label>
                        <input type="number" name="count" id="edit_count" class="form-control">
                        <span class="text-danger error-text edit_count_error"></span>
                    </div>

                    <!-- Icon Selection with Visual Preview -->
                    <div class="form-group">
                        <label>Select or Type Icon Class <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-emoji-smile fs-5" id="edit_icon_preview"></i>
                                </span>
                            </div>
                            <input type="text" name="icon" id="edit_icon_input" class="form-control">
                        </div>
                        <span class="text-danger error-text edit_icon_error"></span>

                        <!-- Quick Icon Picker Grid -->
                        <small class="text-muted d-block mb-1 font-weight-bold">Click an icon to select:</small>
                        <div class="icon-select-box">
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-emoji-smile" title="Emoji Smile"><i class="bi bi-emoji-smile"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-journal-richtext" title="Journal"><i class="bi bi-journal-richtext"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-headset" title="Headset / Support"><i class="bi bi-headset"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-people" title="People / Team"><i class="bi bi-people"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-trophy" title="Trophy"><i class="bi bi-trophy"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-award" title="Award"><i class="bi bi-award"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-star" title="Star"><i class="bi bi-star"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-check-circle" title="Success"><i class="bi bi-check-circle"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-briefcase" title="Briefcase"><i class="bi bi-briefcase"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-diagram-3" title="Network / OLT"><i class="bi bi-diagram-3"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-graph-up-arrow" title="Growth"><i class="bi bi-graph-up-arrow"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-shield-check" title="Shield"><i class="bi bi-shield-check"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-display" title="Monitor / TV"><i class="bi bi-display"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cash-stack" title="Billing"><i class="bi bi-cash-stack"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-lightning-charge" title="Speed / Fast"><i class="bi bi-lightning-charge"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-globe" title="Internet / Globe"><i class="bi bi-globe"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-cpu" title="Router / Hardware"><i class="bi bi-cpu"></i></button>
                            <button type="button" class="btn btn-outline-secondary icon-btn edit-picker-icon" data-icon="bi bi-heart" title="Heart"><i class="bi bi-heart"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Icon Color Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="edit_color_picker" style="max-width: 60px;">
                            <input type="text" name="color" id="edit_color" class="form-control">
                        </div>
                        <span class="text-danger error-text edit_color_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editStatBtn" class="btn btn-info font-weight-bold text-white"><i class="fas fa-save mr-1"></i> Update Stat</button>
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

    fetchStats();

    // Live Color Picker Sync & Icon Color Preview Update
    $('#add_color_picker').on('input', function() {
        let val = $(this).val();$('#add_color_text').val(val);
        $('#add_icon_preview').css('color', val);
    });
    $('#add_color_text').on('input', function() {
        let val = $(this).val();$('#add_color_picker').val(val);
        $('#add_icon_preview').css('color', val);
    });
    
    $('#edit_color_picker').on('input', function() {
        let val = $(this).val();$('#edit_color').val(val);
        $('#edit_icon_preview').css('color', val);
    });
    $('#edit_color').on('input', function() {
        let val = $(this).val();$('#edit_color_picker').val(val);
        $('#edit_icon_preview').css('color', val);
    });

    // Live Icon Preview on Input Typing (Add Modal)
    $('#add_icon_input').on('keyup input', function() {
        let iconClass = $(this).val().trim();$('#add_icon_preview').attr('class', iconClass + ' fs-5');
    });

    // Quick Select Icon Button Click (Add Modal)
    $(document).on('click', '.add-picker-icon', function() {
        let icon = $(this).data('icon');$('#add_icon_input').val(icon);
        $('#add_icon_preview').attr('class', icon + ' fs-5');
    });

    // Live Icon Preview on Input Typing (Edit Modal)
    $('#edit_icon_input').on('keyup input', function() {
        let iconClass = $(this).val().trim();$('#edit_icon_preview').attr('class', iconClass + ' fs-5');
    });

    // Quick Select Icon Button Click (Edit Modal)
    $(document).on('click', '.edit-picker-icon', function() {
        let icon = $(this).data('icon');$('#edit_icon_input').val(icon);
        $('#edit_icon_preview').attr('class', icon + ' fs-5');
    });

    // Fetch All Stats
    function fetchStats() {
        $.ajax({
            url: "{{ route('admin.stats.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.stats.length > 0) {
                    $.each(res.stats, function (key, item) {
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><i class="${item.icon} fs-4" style="color: ${item.color};"></i></td>
                                <td class="font-weight-bold text-left">${item.title}</td>
                                <td><span class="badge badge-primary px-3 py-2 fs-6">${item.count}</span></td>
                                <td><span class="badge text-white" style="background-color: ${item.color};">${item.color}</span></td>
                                <td>
                                    <button class="btn btn-info btn-sm editBtn text-white" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="6" class="text-center text-muted">No Counter Items Found!</td></tr>`;
                }
                $('#statTableBody').html(html);
            }
        });
    }

    // Add Stat
    $('#addStatForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addStatBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.stats.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Stat');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) {
                        $('.add_' + key + '_error').text(err[0]);                     });                 } else if (res.status === 200) {$('#addStatModal').modal('hide');
                    $('#addStatForm')[0].reset();
                    $('#add_icon_preview').attr('class', 'bi bi-emoji-smile fs-5').css('color', '#4154f1');
                    Swal.fire('Success!', res.message, 'success');
                    fetchStats();
                }
            }
        });
    });

    // Trigger Edit Modal
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/stats-section/edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_stat_id').val(res.stat.id);
                    $('#edit_title').val(res.stat.title);
                    $('#edit_count').val(res.stat.count);
                    $('#edit_icon_input').val(res.stat.icon);
                    $('#edit_icon_preview').attr('class', res.stat.icon + ' fs-5').css('color', res.stat.color);
                    $('#edit_color').val(res.stat.color);
                    $('#edit_color_picker').val(res.stat.color);
                    $('#editStatModal').modal('show');
                }
            }
        });
    });

    // Update Stat
    $('#editStatForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_stat_id').val();
        let btn = $('#editStatBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/stats-section/update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Stat');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) {
                        $('.edit_' + key + '_error').text(err[0]);                     });                 } else if (res.status === 200) {$('#editStatModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchStats();
                }
            }
        });
    });

    // Delete Stat
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
                    url: `{{ url('admin/stats-section/delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchStats();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection