@php
    $altFeatureHeader = \App\Models\AltFeatureHeader::first();
    $altFeatureItems  = \App\Models\AltFeatureItem::where('status', 1)->get();
@endphp

<!-- Alt Features Section -->
<section id="alt-features" class="alt-features section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Alt Features Section</h2>
        
    </div>

    <div class="container">

        <div class="row gy-5">

            <!-- Features Grid -->
            <div class="col-xl-7 d-flex order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

                <div class="row align-self-center gy-5">

                    @forelse($altFeatureItems as $item)
                        <div class="col-md-6 icon-box">
                            <i class="{{ $item->icon }} {{ $item->color }}"></i>
                            <div>
                                <h4>{{ $item->title }}</h4>
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback 6 Default Items when database is empty -->

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-router-fill text-primary"></i>
                            <div>
                                <h4>MikroTik Integration</h4>
                                <p>Manage PPPoE users, profiles, queues, and customer connections directly from your billing panel.</p>
                            </div>
                        </div>

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-hdd-network-fill text-success"></i>
                            <div>
                                <h4>OLT & ONU Management</h4>
                                <p>Monitor EPON & GPON devices, optical power, MAC address, VLAN, and ONU status in real time.</p>
                            </div>
                        </div>

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-credit-card-fill text-warning"></i>
                            <div>
                                <h4>Online Payment Gateway</h4>
                                <p>Accept payments through SSLCommerz, bKash, Nagad, Rocket and other supported gateways.</p>
                            </div>
                        </div>

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-envelope-paper-fill text-danger"></i>
                            <div>
                                <h4>SMS & Email Alerts</h4>
                                <p>Automatically send payment reminders, invoices, due notices, and service notifications.</p>
                            </div>
                        </div>

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-bar-chart-line-fill text-info"></i>
                            <div>
                                <h4>Advanced Reports</h4>
                                <p>Generate customer, income, expense, recharge, bandwidth, and business reports instantly.</p>
                            </div>
                        </div>

                        <div class="col-md-6 icon-box">
                            <i class="bi bi-cloud-check-fill text-primary"></i>
                            <div>
                                <h4>Cloud Multi-Tenant SaaS</h4>
                                <p>Run multiple ISP companies from a single platform with complete data isolation and security.</p>
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>

            <!-- Side Image -->
            <div class="col-xl-5 d-flex align-items-center order-1 order-xl-2"
                data-aos="fade-up"
                data-aos-delay="100">
                <img src="{{ isset($altFeatureHeader->image) && file_exists(public_path($altFeatureHeader->image)) ? asset($altFeatureHeader->image) : asset('Frontend/assets/img/alt-features.png') }}" class="img-fluid" alt="ISP Billing Dashboard">
            </div>

        </div>

    </div>

</section><!-- /Alt Features Section -->