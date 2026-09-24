@php
    $clientHeader = \App\Models\ClientHeader::first();
    $clientItems  = \App\Models\ClientItem::where('status', 1)->get();
@endphp

<!-- Clients Section -->
<section id="clients" class="clients section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $clientHeader->title ?? 'Clients' }}</h2>
        <p>{!! $clientHeader->sub_title ?? 'We work with best clients<br>' !!}</p>
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

                @forelse($clientItems as $client)
                    <div class="swiper-slide">
                        @if($client->url)
                            <a href="{{ $client->url }}" target="_blank">
                                <img src="{{ asset($client->logo) }}" class="img-fluid" alt="{{ $client->client_name }}">
                            </a>
                        @else
                            <img src="{{ asset($client->logo) }}" class="img-fluid" alt="{{ $client->client_name }}">
                        @endif
                    </div>
                @empty
                    <!-- Fallback 8 Default Static Clients when database is empty -->
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-1.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-2.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-3.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-4.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-5.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-6.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-7.png') }}" class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('Frontend/assets/img/clients/client-8.png') }}" class="img-fluid" alt=""></div>
                @endforelse

            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Clients Section -->