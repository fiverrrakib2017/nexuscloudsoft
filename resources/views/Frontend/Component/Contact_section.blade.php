@php
    $contactSetting = \App\Models\ContactSetting::first();
@endphp

<!-- Contact Section -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $contactSetting->title ?? 'Contact' }}</h2>
        <p>{{ $contactSetting->sub_title ?? 'Contact Us' }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-6">

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="200">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Address</h3>
                            <p>{{ $contactSetting->address_line1 ?? 'A108 Adam Street' }}</p>
                            <p>{{ $contactSetting->address_line2 ?? 'New York, NY 535022' }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="300">
                            <i class="bi bi-telephone"></i>
                            <h3>Call Us</h3>
                            <p>{{ $contactSetting->phone1 ?? '+1 5589 55488 55' }}</p>
                            <p>{{ $contactSetting->phone2 ?? '+1 6678 254445 41' }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="400">
                            <i class="bi bi-envelope"></i>
                            <h3>Email Us</h3>
                            <p>{{ $contactSetting->email1 ?? 'info@example.com' }}</p>
                            <p>{{ $contactSetting->email2 ?? 'contact@example.com' }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="500">
                            <i class="bi bi-clock"></i>
                            <h3>Open Hours</h3>
                            <p>{{ $contactSetting->open_hours_days ?? 'Monday - Friday' }}</p>
                            <p>{{ $contactSetting->open_hours_time ?? '9:00AM - 05:00PM' }}</p>
                        </div>
                    </div><!-- End Info Item -->

                </div>

            </div>

            <div class="col-lg-6">
                <form id="frontendContactForm" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                    @csrf
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
                            <div class="loading" style="display: none;">Loading...</div>
                            
                            <div class="sent-message" style="display: none;">Your message has been sent. Thank you!</div>

                            <button type="submit" id="submitContactBtn">Send Message</button>
                        </div>

                    </div>
                </form>
            </div><!-- End Contact Form -->

        </div>

    </div>

</section><!-- /Contact Section -->

<!-- AJAX Contact Form Handling Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#frontendContactForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let loading = form.find('.loading');
        let errorMessage = form.find('.error-message');
        let sentMessage = form.find('.sent-message');
        let submitBtn = $('#submitContactBtn');

        loading.show();
        errorMessage.hide();
        sentMessage.hide();
        submitBtn.prop('disabled', true);

        $.ajax({
            url: "{{ route('contact.send') }}",
            type: "POST",
            data: form.serialize(),
            success: function (res) {
                loading.hide();
                submitBtn.prop('disabled', false);

                if (res.status === 200) {
                    sentMessage.text(res.message).show();
                    form[0].reset();
                } else if (res.status === 400) {
                    let errText = '';
                    $.each(res.errors, function (key, err) {
                        errText += err[0] + '<br>';
                    });
                    errorMessage.html(errText).show();
                }
            },
            error: function () {
                loading.hide();
                submitBtn.prop('disabled', false);
                errorMessage.text('An error occurred. Please try again!').show();
            }
        });
    });
});
</script>