@php
    $valueHeader = \App\Models\ValueHeader::first();
    $valueItems  = \App\Models\ValueItem::where('status', 1)->get();
@endphp

<!-- Values Section -->
<section id="values" class="values section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $valueHeader->title ?? 'Why Choose Us' }}</h2>
        <p>{{ $valueHeader->subtitle ?? 'Built to Simplify & Grow Your ISP Business' }}</p>
    </div>

    <div class="container">
        <div class="row gy-4">

            @forelse($valueItems as $item)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="card">
                        <img src="{{ isset($item->image) && file_exists(public_path($item->image)) ? asset($item->image) : asset('Frontend/assets/img/values-1.png') }}" class="img-fluid" alt="{{ $item->title }}">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
            @empty
                <!-- Fallback 3 Static Cards (When Database Table is Empty) -->
                
                <!-- Card 1 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img src="{{ asset('Frontend/assets/img/values-1.png') }}" class="img-fluid" alt="Complete ISP Automation">
                        <h3>Complete ISP Automation</h3>
                        <p>Automate customer billing, invoice generation, service activation, auto-suspension, and bandwidth control—all from a single centralized dashboard.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card">
                        <img src="{{ asset('Frontend/assets/img/values-2.png') }}" class="img-fluid" alt="MikroTik & OLT Integration">
                        <h3>MikroTik & OLT Integration</h3>
                        <p>Seamlessly integrate with your MikroTik routers, OLTs, and ONUs for real-time queue sync, active session management, and automated IP/MAC binding.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card">
                        <img src="{{ asset('Frontend/assets/img/values-3.png') }}" class="img-fluid" alt="Multi-Gateway & Customer Portal">
                        <h3>Smart Payment & Self Care</h3>
                        <p>Empower clients with a dedicated portal for instant bKash, Nagad, or card bill payments, complaint tracking, and automatic reconnection upon payment.</p>
                    </div>
                </div>

            @endforelse

        </div>
    </div>

</section><!-- /Values Section -->