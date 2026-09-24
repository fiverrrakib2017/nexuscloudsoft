@php
    $faqHeader = \App\Models\FaqHeader::first();
    $faqItems  = \App\Models\FaqItem::where('status', 1)->get();

    if($faqItems->isNotEmpty()) {
        $half = ceil($faqItems->count() / 2);
        $leftFaqs  = $faqItems->slice(0, $half);
        $rightFaqs = $faqItems->slice($half);
    }
@endphp

<!-- FAQ Section -->
<section id="faq" class="faq section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $faqHeader->title ?? 'FAQ' }}</h2>
        <p>{{ $faqHeader->sub_title ?? 'Frequently Asked Questions' }}</p>
    </div>

    <div class="container">

        <div class="row">

            @if($faqItems->isNotEmpty())

                <!-- Left FAQ Column -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="faq-container">
                        @foreach($leftFaqs as $index => $item)
                            <div class="faq-item {{ $loop->first ? 'faq-active' : '' }}">
                                <h3>{{ $item->question }}</h3>
                                <div class="faq-content">
                                    <p>{{ $item->answer }}</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right FAQ Column -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="faq-container">
                        @foreach($rightFaqs as $item)
                            <div class="faq-item">
                                <h3>{{ $item->question }}</h3>
                                <div class="faq-content">
                                    <p>{{ $item->answer }}</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @endforeach
                    </div>
                </div>

            @else
                <!-- Fallback 6 Default Static FAQs when database is empty -->

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

            @endif

        </div>

    </div>

</section><!-- /FAQ Section -->

<!-- Accordion Toggle JS -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqContainer = document.querySelector('#faq');
        if (faqContainer) {
            faqContainer.addEventListener('click', (e) => {
                const faqItem = e.target.closest('.faq-item');
                if (faqItem) {
                    faqItem.classList.toggle('faq-active');
                }
            });
        }
    });
</script>