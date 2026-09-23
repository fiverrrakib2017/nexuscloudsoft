@extends('Backend.Layout.App')

@section('title', 'Manage Why Choose Us / Values')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Why Choose Us / Values Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Values Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    
    <!-- Header Title & Subtitle Card -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-heading text-primary mr-2"></i>Edit Section Header</h3>
        </div>
        <form id="headerForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="header_title">Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="header_title" class="form-control" value="{{ $header->title ?? 'Why Choose Us' }}">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="header_subtitle">Section Subtitle <span class="text-danger">*</span></label>
                        <input type="text" name="subtitle" id="header_subtitle" class="form-control" value="{{ $header->subtitle ?? 'Built to Simplify & Grow Your ISP Business' }}">
                        <span class="text-danger error-text header_subtitle_error"></span>
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

    <!-- Cards List Table -->
    <div class="card card-success card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-th-large text-success mr-2"></i>Value Cards</h3>
            <button type="button" class="btn btn-success btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addCardModal">
                <i class="fas fa-plus mr-1"></i> Add New Card
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody id="cardTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= ADD CARD MODAL ================= -->
<div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add New Value Card</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCardForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Card Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Complete ISP Automation">
                        <span class="text-danger error-text add_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter short description..."></textarea>
                        <span class="text-danger error-text add_description_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Image <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="addCardImage" accept="image/*">
                            <label class="custom-file-label" for="addCardImage">Choose Image...</label>
                        </div>
                        <span class="text-danger error-text add_image_error"></span>
                        <div class="mt-2">
                            <img id="addPreview" src="" alt="Preview" width="100" class="img-thumbnail rounded d-none">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addCardBtn" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Save Card</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT CARD MODAL ================= -->
<div class="modal fade" id="editCardModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Value Card</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCardForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_card_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Card Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        <span class="text-danger error-text edit_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        <span class="text-danger error-text edit_description_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="editCardImage" accept="image/*">
                            <label class="custom-file-label" for="editCardImage">Choose New Image...</label>
                        </div>
                        <span class="text-danger error-text edit_image_error"></span>
                        <div class="mt-2">
                            <img id="editPreview" src="" alt="Preview" width="100" class="img-thumbnail rounded">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editCardBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Card</button>
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

    // Load Cards Data
    fetchCards();

    function fetchCards() {
        $.ajax({
            url: "{{ route('admin.values.cards.get') }}",
            type: "GET",
            success: function (response) {
                let html = '';
                if (response.cards.length > 0) {
                    $.each(response.cards, function (key, item) {
                        let imgPath = item.image ? `{{ asset('') }}${item.image}` : `{{ asset('Frontend/assets/img/values-1.png') }}`;
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td><img src="${imgPath}" width="60" class="img-thumbnail rounded"></td>
                                <td class="font-weight-bold text-left">${item.title}</td>
                                <td class="text-left">${item.description}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="5" class="text-center text-muted">No Cards Found!</td></tr>`;
                }
                $('#cardTableBody').html(html);
            }
        });
    }

    // Header Form Update
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.values.header.update') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Header');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) {
                        $('.header_' + key + '_error').text(err[0]);
                    });
                } else if (res.status === 200) {
                    Swal.fire('Success!', res.message, 'success');
                }
            }
        });
    });

    // Image Live Previews
    $('#addCardImage').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#addPreview').attr('src', e.target.result).removeClass('d-none'); }
            reader.readAsDataURL(file);
        }
    });

    $('#editCardImage').change(function (e) {
        let file = e.target.files[0];
        if (file) {
            $(this).next('.custom-file-label').text(file.name);
            let reader = new FileReader();
            reader.onload = function (e) { $('#editPreview').attr('src', e.target.result); }
            reader.readAsDataURL(file);
        }
    });

    // Add Card Form Submission
    $('#addCardForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#addCardBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.values.card.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Card');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) {
                        $('.add_' + key + '_error').text(err[0]);                     });                 } else if (res.status === 200) {$('#addCardModal').modal('hide');
                    $('#addCardForm')[0].reset();
                    $('#addPreview').addClass('d-none');
                    $('.custom-file-label').text('Choose Image...');
                    Swal.fire('Success!', res.message, 'success');
                    fetchCards();
                }
            }
        });
    });

    // Edit Card Modal Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/values-section/card-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_card_id').val(res.card.id);
                    $('#edit_title').val(res.card.title);
                    $('#edit_description').val(res.card.description);
                    let imgPath = res.card.image ? `{{ asset('') }}${res.card.image}` : `{{ asset('Frontend/assets/img/values-1.png') }}`;
                    $('#editPreview').attr('src', imgPath);
                    $('#editCardModal').modal('show');
                }
            }
        });
    });

    // Update Card Form Submission
    $('#editCardForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_card_id').val();
        let formData = new FormData(this);
        let btn = $('#editCardBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/values-section/card-update') }}/${id}`,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Card');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) {
                        $('.edit_' + key + '_error').text(err[0]);                     });                 } else if (res.status === 200) {$('#editCardModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchCards();
                }
            }
        });
    });

    // Delete Card Trigger
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This card will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/values-section/card-delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchCards();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection