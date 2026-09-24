@php
    $serviceHeader = \App\Models\ServiceHeader::first();
    $serviceItems  = \App\Models\ServiceItem::where('status', 1)->get();
@endphp

<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $serviceHeader->title ?? 'Our Service Solutions' }}</h2>
        <p>{{ $serviceHeader->sub_title ?? 'Everything You Need to Run Your ISP Business' }}</p>
    </div>

    <div class="container">

        <div class="row gy-4">

            @forelse($serviceItems as $index => $item)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="service-item {{ $item->color_class ?? 'item-cyan' }} position-relative">
                        <i class="{{ $item->icon }} icon"></i>

                        <h3>{{ $item->title }}</h3>

                        <p>{{ $item->description }}</p>

                        <a href="{{ $item->btn_link ?? '#' }}" class="read-more stretched-link">
                            <span>{{ $item->btn_text ?? 'Learn More' }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>
            @empty
                <!-- Fallback 6 Default Services when database is empty -->

                <!-- Service 1 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <i class="bi bi-router-fill icon"></i>

                        <h3>MikroTik Automation</h3>

                        <p>
                            Automate PPPoE user creation, suspension, activation,
                            queue management and bandwidth control directly from
                            your billing software.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- Service 2 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative">
                        <i class="bi bi-hdd-network-fill icon"></i>

                        <h3>OLT & ONU Management</h3>

                        <p>
                            Monitor EPON & GPON OLTs, optical power, ONU status,
                            MAC address, VLAN and customer connectivity in real time.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- Service 3 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative">
                        <i class="bi bi-credit-card-2-front-fill icon"></i>

                        <h3>Billing & Payments</h3>

                        <p>
                            Automatic invoice generation, recurring billing,
                            online payment gateway integration and due management.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- Service 4 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item item-red position-relative">
                        <i class="bi bi-graph-up-arrow icon"></i>

                        <h3>Business Reports</h3>

                        <p>
                            View income, expenses, collections, customer statistics,
                            bandwidth usage and financial reports from one dashboard.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- Service 5 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-indigo position-relative">
                        <i class="bi bi-building-fill-gear icon"></i>

                        <h3>Multi-Tenant SaaS</h3>

                        <p>
                            Manage multiple ISP companies from a single platform
                            with separate databases, branding and complete security.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <!-- Service 6 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item item-pink position-relative">
                        <i class="bi bi-headset icon"></i>

                        <h3>Customer Support Tools</h3>

                        <p>
                            Built-in ticket system, SMS & Email notifications,
                            customer portal and real-time connection status.
                        </p>

                        <a href="#" class="read-more stretched-link">
                            <span>Learn More</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                </div>

            @endforelse

        </div>

    </div>

</section><!-- /Services Section -->