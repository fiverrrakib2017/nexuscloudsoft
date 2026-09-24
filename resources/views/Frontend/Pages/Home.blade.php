@extends('Frontend.Layout.App')

@section('title', 'Nexus Cloud Soft | Home')

@section('content')
    <!-- /Hero Section -->
    @include('Frontend.Component.Hero_section');

    <!-- About Section -->
    @include('Frontend.Component.About_section');

    <!-- Values Section -->
    @include('Frontend.Component.Values_section');

    <!-- Stats Section -->
    @include('Frontend.Component.Stats_section');

    <!-- Features Section -->
     @include('Frontend.Component.Features_section');

    <!-- Alt Features Section -->
    @include('Frontend.Component.Alt_features_section');

    <!-- Services Section -->
    @include('Frontend.Component.Services_section');

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Pricing</h2>
            <p>Choose the Perfect Plan for Your ISP Business</p>
        </div>

        <div class="container">

            <!-- Unique Scoped CSS -->
            <style>
              /* Wrapper Isolation */
              .rp-price-wrapper {
                --rp-basic: #0d6efd;
                --rp-standard: #20c997;
                --rp-premium: #6f42c1;
                font-family: inherit;
              }

              .rp-price-wrapper .rp-price-card {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 16px !important;
                padding: 32px 24px !important;
                position: relative !important;
                transition: transform 0.3s ease, box-shadow 0.3s ease !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04) !important;
                display: flex !important;
                flex-direction: column !important;
                height: 100% !important;
                margin: 0 !important;
              }

              .rp-price-wrapper .rp-price-card:hover {
                transform: translateY(-6px) !important;
                box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08) !important;
              }

              /* Featured Standard Card */
              .rp-price-wrapper .rp-price-card.rp-featured {
                border: 2px solid var(--rp-standard) !important;
                box-shadow: 0 12px 30px rgba(32, 201, 151, 0.15) !important;
              }

              .rp-price-wrapper .rp-featured-badge {
                position: absolute !important;
                top: -14px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                background: var(--rp-standard) !important;
                color: #ffffff !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.8px !important;
                padding: 4px 16px !important;
                border-radius: 20px !important;
                white-space: nowrap !important;
                z-index: 2 !important;
              }

              /* Header Section */
              .rp-price-wrapper .rp-card-header {
                text-align: center !important;
                border-bottom: 1px dashed #e2e8f0 !important;
                padding-bottom: 20px !important;
                margin-bottom: 20px !important;
                background: transparent !important;
              }

              .rp-price-wrapper .rp-card-icon {
                width: 48px !important;
                height: 48px !important;
                border-radius: 12px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 1.4rem !important;
                margin-bottom: 12px !important;
              }

              .rp-price-card.rp-basic .rp-card-icon {
                background: rgba(13, 110, 253, 0.1) !important;
                color: var(--rp-basic) !important;
              }
              .rp-price-card.rp-standard .rp-card-icon {
                background: rgba(32, 201, 151, 0.1) !important;
                color: var(--rp-standard) !important;
              }
              .rp-price-card.rp-premium .rp-card-icon {
                background: rgba(111, 66, 193, 0.1) !important;
                color: var(--rp-premium) !important;
              }

              .rp-price-wrapper .rp-plan-title {
                font-size: 1.35rem !important;
                font-weight: 700 !important;
                margin-bottom: 6px !important;
              }

              .rp-price-wrapper .rp-setup-fee {
                font-size: 1.75rem !important;
                font-weight: 800 !important;
                color: #0f172a !important;
                margin: 0 !important;
                line-height: 1.2 !important;
              }

              .rp-price-wrapper .rp-setup-label {
                font-size: 0.825rem !important;
                color: #64748b !important;
                font-weight: 500 !important;
                display: block !important;
                margin-top: 2px !important;
              }

              /* Tier List */
              .rp-price-wrapper .rp-tier-list {
                list-style: none !important;
                padding: 0 !important;
                margin: 0 0 24px 0 !important;
                flex-grow: 1 !important;
              }

              .rp-price-wrapper .rp-tier-item {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 9px 0 !important;
                border-bottom: 1px dashed #f1f5f9 !important;
                font-size: 0.875rem !important;
                background: none !important;
              }

              .rp-price-wrapper .rp-tier-item:last-child {
                border-bottom: none !important;
              }

              .rp-price-wrapper .rp-tier-users {
                color: #475569 !important;
                font-weight: 500 !important;
              }

              .rp-price-wrapper .rp-tier-price {
                font-weight: 700 !important;
                color: #0f172a !important;
              }

              /* Custom Action Buttons */
              .rp-price-wrapper .rp-btn {
                width: 100% !important;
                padding: 10px 16px !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                text-align: center !important;
                text-decoration: none !important;
                display: block !important;
                border: none !important;
                transition: opacity 0.2s ease !important;
              }

              .rp-btn-basic { background-color: var(--rp-basic) !important; color: #ffffff !important; }
              .rp-btn-standard { background-color: var(--rp-standard) !important; color: #ffffff !important; }
              .rp-btn-premium { background-color: var(--rp-premium) !important; color: #ffffff !important; }

              .rp-btn:hover { opacity: 0.9 !important; color: #ffffff !important; }
            </style>

            <!-- HTML Structure -->
            <div class="row gy-4 rp-price-wrapper align-items-stretch">

              <!-- Basic Plan -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="rp-price-card rp-basic">
                  <div class="rp-card-header">
                    <div class="rp-card-icon"><i class="bi bi-box"></i></div>
                    <div class="rp-plan-title" style="color: var(--rp-basic);">Basic</div>
                    <div class="rp-setup-fee">৳2,000</div>
                    <span class="rp-setup-label">One-time Setup Charge</span>
                  </div>

                  <ul class="rp-tier-list">
                    <li class="rp-tier-item"><span class="rp-tier-users">1 - 300 Users</span><span class="rp-tier-price">৳1,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">301 - 500 Users</span><span class="rp-tier-price">৳1,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">501 - 1,000 Users</span><span class="rp-tier-price">৳2,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">1,001 - 2,000 Users</span><span class="rp-tier-price">৳3,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">2,001 - 3,000 Users</span><span class="rp-tier-price">৳4,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">3,001 - 5,000 Users</span><span class="rp-tier-price">৳6,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">5,001 - 8,000 Users</span><span class="rp-tier-price">৳8,000 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">8,001 - 12,000 Users</span><span class="rp-tier-price">৳10,000 / mo</span></li>
                  </ul>

                  <a href="#" class="rp-btn rp-btn-basic">Get Started</a>
                </div>
              </div>

              <!-- Standard Plan -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="rp-price-card rp-standard rp-featured">
                  <span class="rp-featured-badge">Most Popular</span>
                  <div class="rp-card-header">
                    <div class="rp-card-icon"><i class="bi bi-star-fill"></i></div>
                    <div class="rp-plan-title" style="color: var(--rp-standard);">Standard</div>
                    <div class="rp-setup-fee">৳3,000</div>
                    <span class="rp-setup-label">One-time Setup Charge</span>
                  </div>

                  <ul class="rp-tier-list">
                    <li class="rp-tier-item"><span class="rp-tier-users">1 - 300 Users</span><span class="rp-tier-price">৳1,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">301 - 500 Users</span><span class="rp-tier-price">৳2,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">501 - 1,000 Users</span><span class="rp-tier-price">৳3,250 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">1,001 - 2,000 Users</span><span class="rp-tier-price">৳4,750 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">2,001 - 3,000 Users</span><span class="rp-tier-price">৳6,250 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">3,001 - 5,000 Users</span><span class="rp-tier-price">৳9,250 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">5,001 - 8,000 Users</span><span class="rp-tier-price">৳12,250 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">8,001 - 12,000 Users</span><span class="rp-tier-price">৳16,500 / mo</span></li>
                  </ul>

                  <a href="#" class="rp-btn rp-btn-standard">Choose Standard</a>
                </div>
              </div>

              <!-- Premium Plan -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="rp-price-card rp-premium">
                  <div class="rp-card-header">
                    <div class="rp-card-icon"><i class="bi bi-gem"></i></div>
                    <div class="rp-plan-title" style="color: var(--rp-premium);">Premium</div>
                    <div class="rp-setup-fee">৳5,000</div>
                    <span class="rp-setup-label">One-time Setup Charge</span>
                  </div>

                  <ul class="rp-tier-list">
                    <li class="rp-tier-item"><span class="rp-tier-users">1 - 300 Users</span><span class="rp-tier-price">৳2,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">301 - 500 Users</span><span class="rp-tier-price">৳3,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">501 - 1,000 Users</span><span class="rp-tier-price">৳4,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">1,001 - 2,000 Users</span><span class="rp-tier-price">৳6,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">2,001 - 3,000 Users</span><span class="rp-tier-price">৳8,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">3,001 - 5,000 Users</span><span class="rp-tier-price">৳12,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">5,001 - 8,000 Users</span><span class="rp-tier-price">৳16,500 / mo</span></li>
                    <li class="rp-tier-item"><span class="rp-tier-users">8,001 - 12,000 Users</span><span class="rp-tier-price">৳20,000 / mo</span></li>
                  </ul>

                  <a href="#" class="rp-btn rp-btn-premium">Get Started</a>
                </div>
              </div>

            </div>

        </div>

    </section>

    <!-- Faq Section -->
    <section id="faq" class="faq section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>FAQ</h2>
            <p>Frequently Asked Questions</p>
        </div>

        <div class="container">

            <div class="row">

                <!-- Left FAQ -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>What is ISP Billing Management Software?</h3>
                            <div class="faq-content">
                                <p>
                                    Our ISP Billing Management Software helps Internet Service Providers automate customer billing,
                                    MikroTik management, payment collection, network monitoring, and business reporting from a
                                    single dashboard.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Does the software support MikroTik routers?</h3>
                            <div class="faq-content">
                                <p>
                                    Yes. The software integrates directly with MikroTik RouterOS API, allowing automatic customer
                                    activation, suspension, bandwidth control, queue management, and PPPoE user management.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Can I manage GPON & EPON OLT devices?</h3>
                            <div class="faq-content">
                                <p>
                                    Absolutely. Our software supports multiple OLT brands with real-time ONU monitoring, optical
                                    power, MAC address, VLAN, customer status, and network information.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                    </div>

                </div>

                <!-- Right FAQ -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                    <div class="faq-container">

                        <div class="faq-item">
                            <h3>Which payment gateways are supported?</h3>
                            <div class="faq-content">
                                <p>
                                    The software supports popular online payment gateways including bKash, Nagad, Rocket,
                                    SSLCommerz, and other supported payment providers.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Can multiple ISP companies use the same platform?</h3>
                            <div class="faq-content">
                                <p>
                                    Yes. Our Multi-Tenant architecture allows multiple ISP companies to operate independently
                                    with separate databases, branding, and complete data isolation.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3>Do you provide installation and technical support?</h3>
                            <div class="faq-content">
                                <p>
                                    Yes. We provide complete installation, configuration, software updates, technical support,
                                    and training to ensure your ISP business runs smoothly.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    What Our Clients Say
                </h2>

                <div class="mx-auto bg-primary rounded-pill mt-3"
                    style="width:80px;height:5px;"></div>

                <p class="text-muted mt-3 mx-auto" style="max-width:650px;">

                    Hear from Internet Service Providers who trust our Billing &
                    Network Management Software every day.

                </p>

            </div>

            <div class="row g-4">

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

                            "Excellent billing software. MikroTik automation,
                            customer management and reports are outstanding."

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

                            "OLT monitoring and online payment integration saved
                            us countless hours every month."

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

                            "Very easy to use. Billing, SMS, reports and customer
                            support are all available in one dashboard."

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

                            "Reliable, modern and responsive. Perfect solution for
                            growing ISP businesses."

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

            </div>

        </div>

    </section>

    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Our hard working team</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Walter White</h4>
                <span>Chief Executive Officer</span>
              
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Sarah Jhonson</h4>
                <span>Product Manager</span>
              
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>William Anderson</h4>
                <span>CTO</span>
              
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Amanda Jepson</h4>
                <span>Accountant</span>
               
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Clients</h2>
        <p>We work with best clients<br></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Clients Section -->

  

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>A108 Adam Street</p>
                  <p>New York, NY 535022</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>+1 5589 55488 55</p>
                  <p>+1 6678 254445 41</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="400">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p>info@example.com</p>
                  <p>contact@example.com</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="500">
                  <i class="bi bi-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Monday - Friday</p>
                  <p>9:00AM - 05:00PM</p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->
@endsection