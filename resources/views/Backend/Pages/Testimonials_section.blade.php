@extends('Backend.Layout.App')

@section('title', 'Manage Testimonials Section')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .star-rating i {
        color: #ffc107;
    }
    .avatar-preview {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Testimonials / Client Reviews</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Testimonials Section</li>
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
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'What Our Clients Say' }}" placeholder="e.g. What Our Clients Say">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'Hear from Internet Service Providers who trust our Billing & Network Management Software every day.' }}" placeholder="Subtitle text...">
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

    <!-- Testimonial Items Table Card -->
    <div class="card card-info card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-quote-left text-info mr-2"></i>Client Reviews List</h3>
            <button type="button" class="btn btn-info btn-sm font-weight-bold text-white ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New Review
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 70px;">Avatar</th>
                        <th style="width: 180px;">Client Name</th>
                        <th style="width: 150px;">Designation</th>
                        <th>Review</th>
                        <th style="width: 120px;">Rating</th>
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

<!-- ================= ADD ITEM MODAL ================= -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add Client Review</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Client / ISP Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" class="form-control" placeholder="e.g. Alpha Net">
                            <span class="text-danger error-text add_client_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Designation / Subtitle <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" value="Trusted ISP Partner" placeholder="e.g. Trusted ISP Partner">
                            <span class="text-danger error-text add_designation_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Review / Comment <span class="text-danger">*</span></label>
                        <textarea name="review" class="form-control" rows="3" placeholder="Excellent billing software..."></textarea>
                        <span class="text-danger error-text add_review_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Star Rating <span class="text-danger">*</span></label>
                        <select name="rating" class="form-control font-weight-bold">
                            <option value="5">5 Stars (⭐⭐⭐⭐⭐)</option>
                            <option value="4">4 Stars (⭐⭐⭐⭐)</option>
                            <option value="3">3 Stars (⭐⭐⭐)</option>
                            <option value="2">2 Stars (⭐⭐)</option>
                            <option value="1">1 Star (⭐)</option>
                        </select>
                        <span class="text-danger error-text add_rating_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-info font-weight-bold text-white"><i class="fas fa-save mr-1"></i> Save Review</button>
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
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Client Review</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Client / ISP Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" id="edit_client_name" class="form-control">
                            <span class="text-danger error-text edit_client_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Designation / Subtitle <span class="text-danger">*</span></label>
                            <input type="text" name="designation" id="edit_designation" class="form-control">
                            <span class="text-danger error-text edit_designation_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Review / Comment <span class="text-danger">*</span></label>
                        <textarea name="review" id="edit_review" class="form-control" rows="3"></textarea>
                        <span class="text-danger error-text edit_review_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Star Rating <span class="text-danger">*</span></label>
                        <select name="rating" id="edit_rating" class="form-control font-weight-bold">
                            <option value="5">5 Stars (⭐⭐⭐⭐⭐)</option>
                            <option value="4">4 Stars (⭐⭐⭐⭐)</option>
                            <option value="3">3 Stars (⭐⭐⭐)</option>
                            <option value="2">2 Stars (⭐⭐)</option>
                            <option value="1">1 Star (⭐)</option>
                        </select>
                        <span class="text-danger error-text edit_rating_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Review</button>
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

    // Header Form Update
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.testimonials.header.update') }}",
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
            url: "{{ route('admin.testimonials.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        let stars = '';
                        for(let i=0; i<item.rating; i++) {
                            stars += '<i class="bi bi-star-fill text-warning"></i> ';
                        }

                        let avatarLetter = item.avatar_letter ? item.avatar_letter : item.client_name.charAt(0).toUpperCase();

                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><div class="avatar-preview">${avatarLetter}</div></td>
                                <td class="font-weight-bold text-left">${item.client_name}</td>
                                <td><span class="badge badge-light border">${item.designation}</span></td>
                                <td class="text-left text-muted">${item.review}</td>
                                <td><div class="star-rating">${stars}</div></td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="7" class="text-center text-muted">No Client Reviews Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add Review
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.testimonials.item.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Review');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit Review Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/testimonials-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_item_id').val(res.item.id);
                    $('#edit_client_name').val(res.item.client_name);
                    $('#edit_designation').val(res.item.designation);
                    $('#edit_review').val(res.item.review);
                    $('#edit_rating').val(res.item.rating);
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update Review
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/testimonials-section/item-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Review');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete Review
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This client review will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/testimonials-section/item-delete') }}/${id}`,
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