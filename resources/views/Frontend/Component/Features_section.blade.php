@php
    $featureHeader = \App\Models\FeatureHeader::first();
    $featureItems  = \App\Models\FeatureItem::where('status', 1)->get();
@endphp

<!-- Features Section -->
<section id="features" class="features section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $featureHeader->title ?? 'Features Section' }}</h2>
        <p>{{ $featureHeader->subtitle ?? 'Powerful ISP Billing & Network Management Features' }}</p>
    </div>

    <div class="container">

        <div class="row gy-5">

            <!-- Featured Image -->
            <div class="col-xl-6" data-aos="zoom-out" data-aos-delay="100">
                <img src="{{ isset($featureHeader->image) && file_exists(public_path($featureHeader->image)) ? asset($featureHeader->image) : asset('Frontend/assets/img/features.png') }}" class="img-fluid" alt="{{ $featureHeader->title ?? 'Features' }}">
            </div>

            <!-- Features Grid -->
            <div class="col-xl-6 d-flex">
                <div class="row align-self-center gy-4">

                    @forelse($featureItems as $item)
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + ($loop->index * 100) }}">
                            <div class="feature-box d-flex align-items-center">
                                <i class="{{ $item->icon }}"></i>
                                <h3>{{ $item->title }}</h3>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback 8 Default Features (When database table is empty) -->

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>Automated Customer Billing</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>MikroTik API Integration</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>Radius Authentication Support</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>OLT & ONU Monitoring</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>Online Payment Gateway</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>SMS & Email Notifications</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="800">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>Multi-Tenant Architecture</h3>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="900">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check-circle-fill"></i>
                                <h3>Real-Time Dashboard & Reports</h3>
                            </div>
                        </div>

                    @endforelse

                </div>
            </div>

        </div>

    </div>

</section><!-- /Features Section -->