@php
    $pricingHeader = \App\Models\PricingHeader::first();
    $pricingPlans  = \App\Models\PricingPlan::with('tiers')->where('status', 1)->orderBy('sort_order', 'asc')->get();
@endphp

<!-- Pricing Section -->
<section id="pricing" class="pricing section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $pricingHeader->title ?? 'Pricing' }}</h2>
        <p>{{ $pricingHeader->sub_title ?? 'Choose the Perfect Plan for Your ISP Business' }}</p>
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

          /* Featured Card Styling */
          .rp-price-wrapper .rp-price-card.rp-featured {
            border: 2px solid var(--plan-color, #20c997) !important;
            box-shadow: 0 12px 30px rgba(32, 201, 151, 0.15) !important;
          }

          .rp-price-wrapper .rp-featured-badge {
            position: absolute !important;
            top: -14px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: var(--plan-color, #20c997) !important;
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
            color: #ffffff !important;
          }

          .rp-btn:hover { opacity: 0.9 !important; color: #ffffff !important; }
        </style>

        <!-- Dynamic HTML Structure -->
        <div class="row gy-4 rp-price-wrapper align-items-stretch">

            @forelse($pricingPlans as $index => $plan)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="rp-price-card {{ $plan->is_featured ? 'rp-featured' : '' }}" style="--plan-color: {{ $plan->theme_color }};">
                        
                        @if($plan->is_featured)
                            <span class="rp-featured-badge">{{ $plan->badge_text ?? 'Most Popular' }}</span>
                        @endif

                        <div class="rp-card-header">
                            <div class="rp-card-icon" style="background: {{ $plan->theme_color }}1a; color: {{ $plan->theme_color }};">
                                <i class="{{ $plan->icon }}"></i>
                            </div>
                            <div class="rp-plan-title" style="color: {{ $plan->theme_color }};">{{ $plan->name }}</div>
                            <div class="rp-setup-fee">{{ $plan->setup_fee }}</div>
                            <span class="rp-setup-label">{{ $plan->setup_label }}</span>
                        </div>

                        <ul class="rp-tier-list">
                            @foreach($plan->tiers as $tier)
                                <li class="rp-tier-item">
                                    <span class="rp-tier-users">{{ $tier->user_range }}</span>
                                    <span class="rp-tier-price">{{ $tier->price }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ $plan->btn_link ?? '#' }}" class="rp-btn" style="background-color: {{ $plan->theme_color }};">
                            {{ $plan->btn_text ?? 'Get Started' }}
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback Default Plans when Database is Empty -->

                <!-- Basic Plan -->
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="rp-price-card rp-basic">
                        <div class="rp-card-header">
                            <div class="rp-card-icon" style="background: rgba(13, 110, 253, 0.1); color: var(--rp-basic);"><i class="bi bi-box"></i></div>
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

                        <a href="#" class="rp-btn" style="background-color: var(--rp-basic);">Get Started</a>
                    </div>
                </div>

                <!-- Standard Plan -->
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="rp-price-card rp-standard rp-featured" style="--plan-color: var(--rp-standard);">
                        <span class="rp-featured-badge">Most Popular</span>
                        <div class="rp-card-header">
                            <div class="rp-card-icon" style="background: rgba(32, 201, 151, 0.1); color: var(--rp-standard);"><i class="bi bi-star-fill"></i></div>
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

                        <a href="#" class="rp-btn" style="background-color: var(--rp-standard);">Choose Standard</a>
                    </div>
                </div>

                <!-- Premium Plan -->
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="rp-price-card rp-premium">
                        <div class="rp-card-header">
                            <div class="rp-card-icon" style="background: rgba(111, 66, 193, 0.1); color: var(--rp-premium);"><i class="bi bi-gem"></i></div>
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

                        <a href="#" class="rp-btn" style="background-color: var(--rp-premium);">Get Started</a>
                    </div>
                </div>

            @endforelse

        </div>

    </div>

</section><!-- /Pricing Section -->