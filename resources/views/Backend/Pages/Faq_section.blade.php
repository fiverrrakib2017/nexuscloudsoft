@extends('Backend.Layout.App')

@section('title', 'Manage FAQ Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">FAQ Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">FAQ Section</li>
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
                        <input type="text" name="title" class="form-control" value="{{ $header->title ?? 'FAQ' }}" placeholder="e.g. FAQ">
                        <span class="text-danger error-text header_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Section Subtitle / Description</label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $header->sub_title ?? 'Frequently Asked Questions' }}" placeholder="e.g. Frequently Asked Questions">
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

    <!-- FAQ Items Table Card -->
    <div class="card card-warning card-outline shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-question-circle text-warning mr-2"></i>FAQ Items List</h3>
            <button type="button" class="btn btn-warning btn-sm font-weight-bold text-dark ml-auto" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus mr-1"></i> Add New FAQ
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="width: 300px;">Question</th>
                        <th>Answer</th>
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
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add New FAQ Item</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control" placeholder="e.g. What is ISP Billing Management Software?">
                        <span class="text-danger error-text add_question_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control" rows="4" placeholder="Enter detailed answer..."></textarea>
                        <span class="text-danger error-text add_answer_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemBtn" class="btn btn-warning font-weight-bold text-dark"><i class="fas fa-save mr-1"></i> Save FAQ</button>
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
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit FAQ Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm">
                @csrf
                <input type="hidden" id="edit_item_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" id="edit_question" class="form-control">
                        <span class="text-danger error-text edit_question_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" id="edit_answer" class="form-control" rows="4"></textarea>
                        <span class="text-danger error-text edit_answer_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editItemBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update FAQ</button>
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

    // Update Header Form
    $('#headerForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveHeaderBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.faq.header.update') }}",
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
            url: "{{ route('admin.faq.items.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.items.length > 0) {
                    $.each(res.items, function (key, item) {
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td class="font-weight-bold text-left">${item.question}</td>
                                <td class="text-left text-muted">${item.answer}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="4" class="text-center text-muted">No FAQ Items Found!</td></tr>`;
                }
                $('#itemTableBody').html(html);
            }
        });
    }

    // Add FAQ Item
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.faq.item.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save FAQ');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addItemModal').modal('hide');
                    $('#addItemForm')[0].reset();
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Edit FAQ Item Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/faq-section/item-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_item_id').val(res.item.id);
                    $('#edit_question').val(res.item.question);
                    $('#edit_answer').val(res.item.answer);
                    $('#editItemModal').modal('show');
                }
            }
        });
    });

    // Update FAQ Item
    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_item_id').val();
        let btn = $('#editItemBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/faq-section/item-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update FAQ');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editItemModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchItems();
                }
            }
        });
    });

    // Delete FAQ Item
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This FAQ item will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/faq-section/item-delete') }}/${id}`,
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