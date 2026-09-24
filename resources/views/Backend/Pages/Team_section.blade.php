@extends('Backend.Layout.App')

@section('title', 'Manage Team Section')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Team Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Team Section</li>
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
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'Team' }}" placeholder="e.g. Team">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'Our hard working team' }}" placeholder="e.g. Our hard working team">
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

    <!-- Team Members Table Card -->
    <div class="card card-indigo card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-users text-primary mr-2"></i>Team Members List</h3>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New Member
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 80px;">Image</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Social Links</th>
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

<!-- ================= ADD MEMBER MODAL ================= -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-1"></i> Add Team Member</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Member Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Walter White">
                            <span class="text-danger error-text add_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" placeholder="e.g. Chief Executive Officer">
                            <span class="text-danger error-text add_designation_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Member Photo</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="addMemberImage" accept="image/*">
                            <label class="custom-file-label" for="addMemberImage">Choose Photo...</label>
                        </div>
                        <span class="text-danger error-text add_image_error"></span>
                        <div class="mt-2 text-center">
                            <img id="add_image_preview" src="{{ asset('Frontend/assets/img/team/team-1.jpg') }}" width="100" height="100" class="rounded-circle img-thumbnail shadow-sm">
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold text-muted mb-3"><i class="fas fa-share-alt mr-1"></i> Social Media Links (Optional)</h6>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-twitter-x text-dark mr-1"></i> Twitter / X Link</label>
                            <input type="url" name="twitter" class="form-control" placeholder="https://twitter.com/username">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-facebook text-primary mr-1"></i> Facebook Link</label>
                            <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/username">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-instagram text-danger mr-1"></i> Instagram Link</label>
                            <input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/username">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-linkedin text-info mr-1"></i> LinkedIn Link</label>
                            <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Save Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT MEMBER MODAL ================= -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-edit mr-1"></i> Edit Team Member</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Member Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <span class="text-danger error-text edit_name_error"></span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" id="edit_designation" class="form-control">
                            <span class="text-danger error-text edit_designation_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Member Photo</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="editMemberImage" accept="image/*">
                            <label class="custom-file-label" for="editMemberImage">Choose New Photo...</label>
                        </div>
                        <span class="text-danger error-text edit_image_error"></span>
                        <div class="mt-2 text-center">
                            <img id="edit_image_preview" src="" width="100" height="100" class="rounded-circle img-thumbnail shadow-sm">
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold text-muted mb-3"><i class="fas fa-share-alt mr-1"></i> Social Media Links (Optional)</h6>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-twitter-x text-dark mr-1"></i> Twitter / X Link</label>
                            <input type="url" name="twitter" id="edit_twitter" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-facebook text-primary mr-1"></i> Facebook Link</label>
                            <input type="url" name="facebook" id="edit_facebook" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-instagram text-danger mr-1"></i> Instagram Link</label>
                            <input type="url" name="instagram" id="edit_instagram" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-linkedin text-info mr-1"></i> LinkedIn Link</label>
                            <input type="url" name="linkedin" id="edit_linkedin" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-info font-weight-bold text-white"><i class="fas fa-save mr-1"></i> Update Member</button>
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

    // Image Live Preview (Add Modal)
    $('#addMemberImage').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#add_image_preview').attr('src', e.target.result); }
            reader.readAsDataURL(file);
        }
    });

    // Image Live Preview (Edit Modal)
    $('#editMemberImage').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#edit_image_preview').attr('src', e.target.result); }
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
            url: "{{ route('admin.team.header.update') }}",
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
            url: "{{ route('admin.team.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        let imgUrl = item.image ? `{{ asset('') }}${item.image}` : `{{ asset('Frontend/assets/img/team/team-1.jpg') }}`;
                        
                        let socialIcons = '';
                        if(item.twitter) socialIcons += `<a href="${item.twitter}" target="_blank" class="mr-1 text-dark"><i class="bi bi-twitter-x"></i></a>`;
                        if(item.facebook) socialIcons += `<a href="${item.facebook}" target="_blank" class="mr-1 text-primary"><i class="bi bi-facebook"></i></a>`;
                        if(item.instagram) socialIcons += `<a href="${item.instagram}" target="_blank" class="mr-1 text-danger"><i class="bi bi-instagram"></i></a>`;
                        if(item.linkedin) socialIcons += `<a href="${item.linkedin}" target="_blank" class="mr-1 text-info"><i class="bi bi-linkedin"></i></a>`;

                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><img src="${imgUrl}" width="45" height="45" class="rounded-circle border shadow-sm"></td>
                                <td class="font-weight-bold text-left">${item.name}</td>
                                <td><span class="badge badge-light border">${item.designation}</span></td>
                                <td class="fs-5">${socialIcons ? socialIcons : '<span class="text-muted small">None</span>'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="6" class="text-center text-muted">No Team Members Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add Member
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.team.item.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Member');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    $('#add_image_preview').attr('src', `{{ asset('Frontend/assets/img/team/team-1.jpg') }}`);
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit Member Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/team-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    let m = res.member;
                    $('#edit_item_id').val(m.id);
                    $('#edit_name').val(m.name);
                    $('#edit_designation').val(m.designation);
                    $('#edit_twitter').val(m.twitter);
                    $('#edit_facebook').val(m.facebook);
                    $('#edit_instagram').val(m.instagram);
                    $('#edit_linkedin').val(m.linkedin);

                    let imgUrl = m.image ? `{{ asset('') }}${m.image}` : `{{ asset('Frontend/assets/img/team/team-1.jpg') }}`;
                    $('#edit_image_preview').attr('src', imgUrl);
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update Member
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let formData = new FormData(this);
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/team-section/item-update') }}/${id}`,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Member');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete Member
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This team member will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/team-section/item-delete') }}/${id}`,
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