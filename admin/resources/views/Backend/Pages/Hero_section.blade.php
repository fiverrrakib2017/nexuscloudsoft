@extends('Backend.Layout.App')

@section('title', 'Nexus Cloud Soft | Admin Dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">Hero Section Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Hero Section</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-star text-warning mr-2"></i>Edit Hero Section Content</h3>
        </div>

        <form id="heroForm" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Title -->
                    <div class="col-md-12 form-group">
                        <label for="title">Hero Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $hero->title ?? 'Simplify Your ISP Business with One Powerful Platform' }}" placeholder="Enter main heading">
                        <span class="text-danger error-text title_error"></span>
                    </div>

                    <!-- Subtitle / Paragraph -->
                    <div class="col-md-12 form-group">
                        <label for="subtitle">Description / Paragraph <span class="text-danger">*</span></label>
                        <textarea name="subtitle" id="subtitle" class="form-control" rows="3" placeholder="Enter hero description">{{ $hero->subtitle ?? 'Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments, generate real-time reports, and grow your Internet Service Provider business effortlessly.' }}</textarea>
                        <span class="text-danger error-text subtitle_error"></span>
                    </div>

                    <!-- CTA Button Text -->
                    <div class="col-md-6 form-group">
                        <label for="btn_text">Button Text <span class="text-danger">*</span></label>
                        <input type="text" name="btn_text" id="btn_text" class="form-control" value="{{ $hero->btn_text ?? 'Get Started' }}">
                        <span class="text-danger error-text btn_text_error"></span>
                    </div>

                    <!-- CTA Button URL -->
                    <div class="col-md-6 form-group">
                        <label for="btn_url">Button Link / URL <span class="text-danger">*</span></label>
                        <input type="text" name="btn_url" id="btn_url" class="form-control" value="{{ $hero->btn_url ?? '#about' }}">
                        <span class="text-danger error-text btn_url_error"></span>
                    </div>

                    <!-- Video URL -->
                    <div class="col-md-6 form-group">
                        <label for="video_url">YouTube Video URL</label>
                        <input type="text" name="video_url" id="video_url" class="form-control" value="{{ $hero->video_url ?? 'https://www.youtube.com/watch?v=Y7f98aduVJ8' }}" placeholder="https://www.youtube.com/watch?v=...">
                        <span class="text-danger error-text video_url_error"></span>
                    </div>

                    <!-- Hero Image -->
                    <div class="col-md-6 form-group">
                        <label for="image">Hero Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="heroImageInput" accept="image/*">
                            <label class="custom-file-label" for="heroImageInput">Choose file...</label>
                        </div>
                        <span class="text-danger error-text image_error"></span>

                        <!-- Image Preview -->
                        <div class="mt-3">
                            <img id="imagePreview" src="{{ isset($hero->image) && file_exists(public_path($hero->image)) ? asset($hero->image) : asset('images/hero_section.png') }}" alt="Hero Preview" width="140" class="img-thumbnail rounded shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" id="saveBtn" class="btn btn-primary font-weight-bold px-4">
                    <i class="fas fa-save mr-1"></i> Update Hero Section
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
        // Image Live Preview & Label Update
        $('#heroImageInput').change(function (e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file...';
            $(this).next('.custom-file-label').html(fileName);

            let reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            if (e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form Submission via AJAX
        $('#heroForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            let btn = $('#saveBtn');

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
            $('.error-text').text('');

            $.ajax({
                url: "{{ route('admin.hero.update') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Hero Section');

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
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Update Hero Section');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>
@endsection