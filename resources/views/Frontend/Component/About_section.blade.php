@php
    $about = \App\Models\AboutSection::first();
@endphp

<!-- About Section -->
<section id="about" class="about section">

    <div class="container" data-aos="fade-up">
        <div class="row gx-0">

            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content">
                    <h3>{{ $about->sub_title ?? 'WHO WE ARE' }}</h3>
                    <h2>{{ $about->title ?? 'We Are a Team of Innovators Dedicated to Empowering Your Brand' }}</h2>
                    <p>
                        {{ $about->description ?? 'We combine strategy, creativity, and technology to help your business thrive in the digital world. Our team crafts customized web solutions, driving measurable results and building meaningful connections between you and your customers.' }}
                    </p>
                    <div class="text-center text-lg-start">
                        <a href="{{ $about->btn_url ?? '#services' }}" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>{{ $about->btn_text ?? 'Read More' }}</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ isset($about->image) && file_exists(public_path($about->image)) ? asset($about->image) : asset('Frontend/assets/img/services.jpg') }}" class="img-fluid" alt="{{ $about->title ?? 'About Our Company' }}">
            </div>

        </div>
    </div>

</section><!-- /About Section -->