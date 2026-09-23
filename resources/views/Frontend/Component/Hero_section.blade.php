@php
        $hero = \App\Models\HeroSection::first();
    @endphp

    <!-- Hero Section -->
    <section id="hero" class="hero section d-flex align-items-center">
        <div class="container">
            <div class="row gy-4 align-items-center">
              
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                    <h1 data-aos="fade-up" class="fw-bold">
                        {{ $hero->title ?? 'Simplify Your ISP Business with One Powerful Platform' }}
                    </h1>

                    <p data-aos="fade-up" data-aos-delay="100" class="lead text-muted my-3">
                        {{ $hero->subtitle ?? 'Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments, generate real-time reports, and grow your Internet Service Provider business effortlessly.' }}
                    </p>
                
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start align-items-center gap-3 mt-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ $hero->btn_url ?? '#about' }}" class="btn-get-started d-inline-flex align-items-center justify-content-center">
                            <span>{{ $hero->btn_text ?? 'Get Started' }}</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                        @if(!empty($hero->video_url))
                            <a href="{{ $hero->video_url }}" class="glightbox btn-watch-video d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-play-circle fs-4 me-2"></i>
                                <span>Watch Video</span>
                            </a>
                        @endif
                    </div>
                </div>
              
                <div class="col-lg-6 order-1 order-lg-2 hero-img text-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ isset($hero->image) && file_exists(public_path($hero->image)) ? asset($hero->image) : asset('images/hero_section.png') }}" class="img-fluid animated" alt="Hero Image">
                </div>
              
            </div>
        </div>
    </section><!-- /Hero Section -->