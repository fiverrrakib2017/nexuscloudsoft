@php
    $footerSetting   = \App\Models\FooterSetting::first();
    $footerSolutions = \App\Models\FooterSolution::where('status', 1)->get();
@endphp

<!-- Footer -->
<footer id="footer" class="footer">

    <!-- CTA Section -->
    <div class="footer-newsletter">

        <div class="container">

            <div class="row justify-content-center text-center">

                <div class="col-lg-8">

                    <h3 class="fw-bold">
                        {{ $footerSetting->cta_title ?? 'Ready to Grow Your ISP Business?' }}
                    </h3>

                    <p class="mt-3">
                        {{ $footerSetting->cta_description ?? 'Automate billing, manage customers, monitor networks, and scale your ISP with our all-in-one Billing Management Software.' }}
                    </p>

                    <div class="mt-4">

                        <a href="{{ $footerSetting->cta_btn1_url ?? '#pricing' }}" class="btn btn-primary me-2">
                            {{ $footerSetting->cta_btn1_text ?? 'View Pricing' }}
                        </a>

                        <a href="{{ $footerSetting->cta_btn2_url ?? '#contact' }}" class="btn btn-outline-primary">
                            {{ $footerSetting->cta_btn2_text ?? 'Contact Us' }}
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Footer Top -->

    <div class="container footer-top">

        <div class="row gy-4">

            <!-- About -->

            <div class="col-lg-4 col-md-6 footer-about">

                <a href="{{ url('/') }}" class="d-flex align-items-center">

                    <span class="sitename">
                        {{ $footerSetting->site_name ?? 'ISP Billing' }}
                    </span>

                </a>

                <div class="footer-contact pt-3">

                    <p>
                        {{ $footerSetting->about_text ?? 'A complete ISP Billing & Network Management solution for Internet Service Providers. Automate billing, manage customers, monitor MikroTik & OLT devices, and grow your business with confidence.' }}
                    </p>

                    <p class="mt-3">

                        <strong>Phone :</strong>

                        <span>{{ $footerSetting->phone ?? '+880 1700-000000' }}</span>

                    </p>

                    <p>

                        <strong>Email :</strong>

                        <span>{{ $footerSetting->email ?? 'support@yourdomain.com' }}</span>

                    </p>

                </div>

            </div>

            <!-- Quick Links -->

            <div class="col-lg-2 col-md-3 footer-links">

                <h4>Quick Links</h4>

                <ul>

                    <li><i class="bi bi-chevron-right"></i> <a href="#hero">Home</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#about">About</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#features">Features</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#pricing">Pricing</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>

                </ul>

            </div>

            <!-- Services / Solutions -->

            <div class="col-lg-3 col-md-3 footer-links">

                <h4>Our Solutions</h4>

                <ul>

                    @forelse($footerSolutions as $solution)
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ $solution->url }}">{{ $solution->title }}</a></li>
                    @empty
                        <!-- Fallback 5 Default Static Solutions when database is empty -->
                        <li><i class="bi bi-chevron-right"></i> <a href="#">ISP Billing</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">MikroTik Automation</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">OLT Monitoring</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Payment Gateway</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Customer Portal</a></li>
                    @endforelse

                </ul>

            </div>

            <!-- Follow / Social -->

            <div class="col-lg-3 col-md-12">

                <h4>Connect With Us</h4>

                <p>
                    {{ $footerSetting->social_description ?? 'Follow us for software updates, feature releases, and ISP industry news.' }}
                </p>

                <div class="social-links d-flex">

                    <a href="{{ $footerSetting->facebook ?? '#' }}" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="{{ $footerSetting->youtube ?? '#' }}" target="_blank">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <a href="{{ $footerSetting->linkedin ?? '#' }}" target="_blank">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="{{ $footerSetting->github ?? '#' }}" target="_blank">
                        <i class="bi bi-github"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Copyright -->

    <div class="container copyright text-center mt-4">

        <p>

            © {{ date('Y') }} <strong class="px-1">{{ $footerSetting->copyright_text ?? 'ISP Billing Management Software' }}</strong>

            All Rights Reserved.

        </p>

        <div class="credits">

            Designed & Developed by
            <strong>{{ $footerSetting->developed_by ?? 'Your Company Name' }}</strong>

        </div>

    </div>

</footer><!-- /Footer -->