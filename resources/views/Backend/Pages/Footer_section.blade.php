@extends('Backend.Layout.App')

@section('title', 'Manage Footer Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Footer Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Footer Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <form id="settingForm">
        @csrf

        <!-- 1. Footer CTA Newsletter Card -->
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-bullhorn text-primary mr-2"></i>CTA Newsletter Banner</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>CTA Title <span class="text-danger">*</span></label>
                        <input type="text" name="cta_title" class="form-control" value="{{ $setting->cta_title ?? 'Ready to Grow Your ISP Business?' }}">
                        <span class="text-danger error-text cta_title_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>CTA Description</label>
                        <input type="text" name="cta_description" class="form-control" value="{{ $setting->cta_description ?? 'Automate billing, manage customers, monitor networks, and scale your ISP with our all-in-one Billing Management Software.' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Button 1 Text</label>
                        <input type="text" name="cta_btn1_text" class="form-control" value="{{ $setting->cta_btn1_text ?? 'View Pricing' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Button 1 Link URL</label>
                        <input type="text" name="cta_btn1_url" class="form-control" value="{{ $setting->cta_btn1_url ?? '#pricing' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Button 2 Text</label>
                        <input type="text" name="cta_btn2_text" class="form-control" value="{{ $setting->cta_btn2_text ?? 'Contact Us' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Button 2 Link URL</label>
                        <input type="text" name="cta_btn2_url" class="form-control" value="{{ $setting->cta_btn2_url ?? '#contact' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Footer About & Contact Card -->
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle text-info mr-2"></i>About & Contact Info</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Brand / Site Name <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" class="form-control" value="{{ $setting->site_name ?? 'ISP Billing' }}">
                        <span class="text-danger error-text site_name_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ $setting->phone ?? '+880 1700-000000' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $setting->email ?? 'support@yourdomain.com' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>About Description</label>
                        <textarea name="about_text" class="form-control" rows="2">{{ $setting->about_text ?? 'A complete ISP Billing & Network Management solution for Internet Service Providers. Automate billing, manage customers, monitor MikroTik & OLT devices, and grow your business with confidence.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Social Links & Copyright Card -->
        <div class="card card-warning card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-share-alt text-warning mr-2"></i>Social Links & Copyright</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Social Description</label>
                    <input type="text" name="social_description" class="form-control" value="{{ $setting->social_description ?? 'Follow us for software updates, feature releases, and ISP industry news.' }}">
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Facebook URL</label>
                        <input type="url" name="facebook" class="form-control" value="{{ $setting->facebook ?? '#' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>YouTube URL</label>
                        <input type="url" name="youtube" class="form-control" value="{{ $setting->youtube ?? '#' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>LinkedIn URL</label>
                        <input type="url" name="linkedin" class="form-control" value="{{ $setting->linkedin ?? '#' }}">
                    </div>

                    <div class="col-md-3 form-group">
                        <label>GitHub URL</label>
                        <input type="url" name="github" class="form-control" value="{{ $setting->github ?? '#' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Copyright Text <span class="text-danger">*</span></label>
                        <input type="text" name="copyright_text" class="form-control" value="{{ $setting->copyright_text ?? 'ISP Billing Management Software' }}">
                        <span class="text-danger error-text copyright_text_error"></span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Developed By <span class="text-danger">*</span></label>
                        <input type="text" name="developed_by" class="form-control" value="{{ $setting->developed_by ?? 'Your Company Name' }}">
                        <span class="text-danger error-text developed_by_error"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" id="saveSettingBtn" class="btn btn-primary font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Save Footer Settings
                </button>
            </div>
        </div>
    </form>

    <!-- 4. Our Solutions Links Table Card -->
    <div class="card card-success card-outline shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold m-0"><i class="fas fa-link text-success mr-2"></i>"Our Solutions" Dynamic Links</h3>
            <button type="button" class="btn btn-success btn-sm font-weight-bold ml-auto" data-toggle="modal" data-target="#addSolutionModal">
                <i class="fas fa-plus mr-1"></i> Add New Solution Link
            </button>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover table-striped text-center m-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Solution Title</th>
                        <th>Target URL</th>
                        <th style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody id="solutionsTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= ADD SOLUTION MODAL ================= -->
<div class="modal fade" id="addSolutionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Add Solution Link</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSolutionForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Solution Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. MikroTik Automation">
                        <span class="text-danger error-text add_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Target URL</label>
                        <input type="text" name="url" class="form-control" value="#" placeholder="e.g. # or https://example.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addSolutionBtn" class="btn btn-success font-weight-bold"><i class="fas fa-save mr-1"></i> Save Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT SOLUTION MODAL ================= -->
<div class="modal fade" id="editSolutionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Solution Link</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSolutionForm">
                @csrf
                <input type="hidden" id="edit_solution_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Solution Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                        <span class="text-danger error-text edit_title_error"></span>
                    </div>

                    <div class="form-group">
                        <label>Target URL</label>
                        <input type="text" name="url" id="edit_url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editSolutionBtn" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i> Update Link</button>
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

    fetchSolutions();

    // Save Footer Settings Form
    $('#settingForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#saveSettingBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.footer.setting.update') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Footer Settings');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.' + key + '_error').text(err[0]); });
                } else if (res.status === 200) {
                    Swal.fire('Success!', res.message, 'success');
                }
            }
        });
    });

    // Fetch Solutions Links
    function fetchSolutions() {
        $.ajax({
            url: "{{ route('admin.footer.solutions.get') }}",
            type: "GET",
            success: function (res) {
                let html = '';
                if (res.solutions.length > 0) {
                    $.each(res.solutions, function (key, item) {
                        html += `
                            <tr>
                                <td>${key + 1}</td>
                                <td class="font-weight-bold text-left">${item.title}</td>
                                <td class="text-left"><span class="badge badge-light border">${item.url}</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="4" class="text-center text-muted">No Solution Links Found!</td></tr>`;
                }
                $('#solutionsTableBody').html(html);
            }
        });
    }

    // Add Solution
    $('#addSolutionForm').on('submit', function (e) {
        e.preventDefault();
        let btn = $('#addSolutionBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $('.error-text').text('');

        $.ajax({
            url: "{{ route('admin.footer.solution.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Link');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.add_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#addSolutionModal').modal('hide');
                    $('#addSolutionForm')[0].reset();
                    Swal.fire('Success!', res.message, 'success');
                    fetchSolutions();
                }
            }
        });
    });

    // Edit Solution Trigger
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');$.ajax({
            url: `{{ url('admin/footer-section/solution-edit') }}/${id}`,
            type: "GET",
            success: function (res) {
                if (res.status === 200) {
                    $('#edit_solution_id').val(res.solution.id);
                    $('#edit_title').val(res.solution.title);
                    $('#edit_url').val(res.solution.url);
                    $('#editSolutionModal').modal('show');
                }
            }
        });
    });

    // Update Solution
    $('#editSolutionForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#edit_solution_id').val();
        let btn = $('#editSolutionBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
        $('.error-text').text('');

        $.ajax({
            url: `{{ url('admin/footer-section/solution-update') }}/${id}`,
            type: "POST",
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Link');
                if (res.status === 400) {
                    $.each(res.errors, function (key, err) { $('.edit_' + key + '_error').text(err[0]); });                 } else if (res.status === 200) {$('#editSolutionModal').modal('hide');
                    Swal.fire('Success!', res.message, 'success');
                    fetchSolutions();
                }
            }
        });
    });

    // Delete Solution
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This solution link will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/footer-section/solution-delete') }}/${id}`,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (res) {
                        if (res.status === 200) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchSolutions();
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection