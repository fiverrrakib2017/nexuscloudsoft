@php
    $testimonialHeader = \App\Models\TestimonialHeader::first();
    $testimonialItems  = \App\Models\TestimonialItem::where('status', 1)->get();
@endphp

<!-- Testimonials Section -->
<section id="testimonials" class="py-5 bg-light">

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">
                {{ $testimonialHeader->title ?? 'What Our Clients Say' }}
            </h2>

            <div class="mx-auto bg-primary rounded-pill mt-3" style="width:80px;height:5px;"></div>

            <p class="text-muted mt-3 mx-auto" style="max-width:650px;">
                {{ $testimonialHeader->sub_title ?? 'Hear from Internet Service Providers who trust our Billing & Network Management Software every day.' }}
            </p>
        </div>

        <div class="row g-4">

            @forelse($testimonialItems as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 h-100 shadow-sm">

                        <div class="text-warning mb-3">
                            @for($i = 0; $i < ($item->rating ?? 5); $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>

                        <p class="small text-muted">
                            "{{ $item->review }}"
                        </p>

                        <hr>

                        <div class="d-flex align-items-center">
                            <div class="hero-avatar me-3">
                                {{ $item->avatar_letter ?? strtoupper(substr(trim($item->client_name), 0, 1)) }}
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    {{ $item->client_name }}
                                </h6>

                                <small class="text-muted">
                                    {{ $item->designation ?? 'Trusted ISP Partner' }}
                                </small>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <!-- Fallback 4 Default Reviews when database is empty -->

                <!-- Review 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 h-100 shadow-sm">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <p class="small text-muted">
                            "Excellent billing software. MikroTik automation, customer management and reports are outstanding."
                        </p>

                        <hr>

                        <div class="d-flex align-items-center">
                            <div class="hero-avatar me-3">
                                A
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    Alpha Net
                                </h6>

                                <small class="text-muted">
                                    Trusted ISP Partner
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 h-100 shadow-sm">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <p class="small text-muted">
                            "OLT monitoring and online payment integration saved us countless hours every month."
                        </p>

                        <hr>

                        <div class="d-flex align-items-center">
                            <div class="hero-avatar me-3">
                                B
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    Broadband Plus
                                </h6>

                                <small class="text-muted">
                                    Trusted ISP Partner
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 h-100 shadow-sm">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <p class="small text-muted">
                            "Very easy to use. Billing, SMS, reports and customer support are all available in one dashboard."
                        </p>

                        <hr>

                        <div class="d-flex align-items-center">
                            <div class="hero-avatar me-3">
                                N
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    NetZone ISP
                                </h6>

                                <small class="text-muted">
                                    Trusted ISP Partner
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card p-4 h-100 shadow-sm">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <p class="small text-muted">
                            "Reliable, modern and responsive. Perfect solution for growing ISP businesses."
                        </p>

                        <hr>

                        <div class="d-flex align-items-center">
                            <div class="hero-avatar me-3">
                                S
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    SkyLink Network
                                </h6>

                                <small class="text-muted">
                                    Trusted ISP Partner
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

            @endforelse

        </div>

    </div>

</section><!-- /Testimonials Section -->