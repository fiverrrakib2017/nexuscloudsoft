@php
    $teamHeader  = \App\Models\TeamHeader::first();
    $teamMembers = \App\Models\TeamMember::where('status', 1)->get();
@endphp

<!-- Team Section -->
<section id="team" class="team section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $teamHeader->title ?? 'Team' }}</h2>
        <p>{{ $teamHeader->sub_title ?? 'Our hard working team' }}</p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-4">

            @forelse($teamMembers as $index => $member)
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ isset($member->image) && file_exists(public_path($member->image)) ? asset($member->image) : asset('Frontend/assets/img/team/team-' . (($index % 4) + 1) . '.jpg') }}" class="img-fluid" alt="{{ $member->name }}">
                            <div class="social">
                                @if($member->twitter) <a href="{{ $member->twitter }}" target="_blank"><i class="bi bi-twitter-x"></i></a> @endif
                                @if($member->facebook) <a href="{{ $member->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a> @endif
                                @if($member->instagram) <a href="{{ $member->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a> @endif
                                @if($member->linkedin) <a href="{{ $member->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a> @endif
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>{{ $member->name }}</h4>
                            <span>{{ $member->designation }}</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->
            @empty
                <!-- Fallback 4 Default Members when database is empty -->

                <!-- Member 1 -->
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('Frontend/assets/img/team/team-1.jpg') }}" class="img-fluid" alt="Walter White">
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

                <!-- Member 2 -->
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('Frontend/assets/img/team/team-2.jpg') }}" class="img-fluid" alt="Sarah Jhonson">
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

                <!-- Member 3 -->
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('Frontend/assets/img/team/team-3.jpg') }}" class="img-fluid" alt="William Anderson">
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

                <!-- Member 4 -->
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('Frontend/assets/img/team/team-4.jpg') }}" class="img-fluid" alt="Amanda Jepson">
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

            @endforelse

        </div>

    </div>

</section><!-- /Team Section -->