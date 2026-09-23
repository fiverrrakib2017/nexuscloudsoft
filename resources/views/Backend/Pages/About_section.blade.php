@extends('Backend.Layout.App')

@section('title', 'Manage About Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">About Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">About Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-building text-primary mr-2"></i>Edit About Section Details</h3>
        </div>

        <form id="aboutForm" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">

                    <!-- Sub Title / Tagline -->
                    <div class="col-md-6 form-group">
                        <label for="sub_title">Tagline / Small Heading <span class="text-danger">*</span></label>
                        <input type="text" name="sub_title" id="sub_title" class="form-control" value="{{ $about->sub_title ?? 'WHO WE ARE' }}" placeholder="e.g. WHO WE ARE">
                        <span class="text-danger error-text sub_title_error"></span>
                    </div>

                    <!-- Main Title -->
                    <div class="col-md-6 form-group">
                        <label for="title">Main Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $about->title ?? 'We Are a Team of Innovators Dedicated to Empowering Your Brand' }}" placeholder="Main Title">
                        <span class="text-danger error-text title_error"></span>
                    </div>

                    <!-- Description / Paragraph -->
                    <div class="col-md-12 form-group">
                        <label for="description">About Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter detailed about description">{{ $about->description ?? 'We combine strategy, creativity, and technology to help your business thrive in the digital world. Our team crafts customized web solutions, driving measurable results and building meaningful connections between you and your customers.' }}</textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>

                    <!-- Button Text -->
                    <div class="col-md-6 form-group">
                        <label for="btn_text">Button Text <span class="text-danger">*</span></label>
                        <input type="text" name="btn_text" id="btn_text" class="form-control" value="{{ $about->btn_text ?? 'Read More' }}">
                        <span class="text-danger error-text btn_text_error"></span>
                    </div>

                    <!-- Button URL -->
                    <div class="col-md-6 form-group">
                        <label for="btn_url">Button Link / Target Anchor <span class="text-danger">*</span></label>
                        <input type="text" name="btn_url" id="btn_url" class="form-control" value="{{ $about->btn_url ?? '#services' }}">
                        <span class="text-danger error-text btn_url_error"></span>
                    </div>

                    <!-- About Section Image -->
                    <div class="col-md-6 form-group">
                        <label for="image">About Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="aboutImageInput" accept="image/*">
                            <label class="custom-file-label" for="aboutImageInput">Choose image...</label>
                        </div>
                        <span class="text-danger error-text image_error"></span>

                        <!-- Image Live Preview -->
                        <div class="mt-3">
                            <img id="aboutImagePreview" src="{{ isset($about->image) && file_exists(public_path($about->image)) ? asset($about->image) : asset('Frontend/assets/img/services.jpg') }}" alt="About Preview" width="150" class="img-thumbnail rounded shadow-sm">
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" id="saveAboutBtn" class="btn btn-primary font-weight-bold px-4">
                    <i class="fas fa-save mr-1"></i> Update About Section
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Image Live Preview & Input Label Change
        $('#aboutImageInput').change(function (e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Choose image...';
            $(this).next('.custom-file-label').html(fileName);

            let reader = new FileReader();
            reader.onload = function (e) {
                $('#aboutImagePreview').attr('src', e.target.result);
            }
            if (e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // AJAX Form Submission
        $('#aboutForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            let btn = $('#saveAboutBtn');

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
            $('.error-text').text('');

            $.ajax({
                url: "{{ route('admin.about.update') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update About Section');

                    if (response.status === 400) {
                        $.each(response.errors, function (key, err) {
                            $('.' + key + '_error').text(err[0]);
                        });
                    } else if (response.status === 200) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            timer: 2000
                        });
                    }
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update About Section');
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating.',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>
@endsection