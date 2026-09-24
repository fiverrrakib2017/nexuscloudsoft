@extends('Backend.Layout.App')

@section('title', 'Nexus Cloud Soft | Admin Dashboard')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection

@php
    // কন্ট্রোলার ছাড়া সরাসরি ব্লেড থেকে ডেটাবেজ কুয়েরি (Fallbacks সহ)
    $pendingDemoCount   = class_exists('\App\Models\DemoRequest') ? \App\Models\DemoRequest::where('status', 'pending')->count() : 0;
    $totalDemoCount     = class_exists('\App\Models\DemoRequest') ? \App\Models\DemoRequest::count() : 0;
    
    $totalMessageCount  = class_exists('\App\Models\ContactMessage') ? \App\Models\ContactMessage::count() : 0;
    $teamMemberCount    = class_exists('\App\Models\TeamMember') ? \App\Models\TeamMember::where('status', 1)->count() : 0;
    $clientCount        = class_exists('\App\Models\ClientItem') ? \App\Models\ClientItem::where('status', 1)->count() : 0;
    $faqCount           = class_exists('\App\Models\FaqItem') ? \App\Models\FaqItem::where('status', 1)->count() : 0;
    $testimonialCount   = class_exists('\App\Models\TestimonialItem') ? \App\Models\TestimonialItem::where('status', 1)->count() : 0;

    // সাম্প্রতিক ৫টি ডেমো রিকোয়েস্ট ও কন্টাক্ট মেসেজ
    $recentDemos        = class_exists('\App\Models\DemoRequest') ? \App\Models\DemoRequest::latest()->take(5)->get() : collect();
    $recentMessages     = class_exists('\App\Models\ContactMessage') ? \App\Models\ContactMessage::latest()->take(5)->get() : collect();
@endphp

@section('content')

<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-tachometer-alt text-primary mr-2"></i>Admin Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid">

    <!-- Top Real-time Stat Info-Boxes -->
    <div class="row">
        <!-- Pending Demo Requests Box -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-desktop"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending Demos</span>
                    <span class="info-box-number text-danger font-weight-bold">{{ $pendingDemoCount }} <small class="text-muted">/ {{ $totalDemoCount }} Total</small></span>
                </div>
            </div>
        </div>

        <!-- Contact Messages Box -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Contact Messages</span>
                    <span class="info-box-number font-weight-bold">{{ $totalMessageCount }}</span>
                </div>
            </div>
        </div>

        <!-- Team Members Box -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-warning elevation-1 text-white"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Team</span>
                    <span class="info-box-number font-weight-bold">{{ $teamMemberCount }} Members</span>
                </div>
            </div>
        </div>

        <!-- Client Logos Box -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-handshake"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Client Brands</span>
                    <span class="info-box-number font-weight-bold">{{ $clientCount }} Logos</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Section Manager Cards -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Quick CMS Management Panel</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Demo Requests -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-danger"><i class="fas fa-desktop mr-1"></i> Demo Requests</h5>
                            <p class="text-muted small">Manage client live software demo requests...</p>
                            <a href="{{ Route::has('admin.demo_requests.index') ? route('admin.demo_requests.index') : '#' }}" class="btn btn-sm btn-outline-danger font-weight-bold">
                                Manage Demos <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact & Messages -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-info"><i class="fas fa-envelope mr-1"></i> Contact & Messages</h5>
                            <p class="text-muted small">View incoming messages and update contact details...</p>
                            <a href="{{ Route::has('admin.contact.index') ? route('admin.contact.index') : '#' }}" class="btn btn-sm btn-outline-info font-weight-bold">
                                View Messages <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-warning"><i class="fas fa-question-circle mr-1"></i> FAQ Section</h5>
                            <p class="text-muted small">Add or edit questions & answers for ISPs (Active: {{ $faqCount }})...</p>
                            <a href="{{ Route::has('admin.faq.index') ? route('admin.faq.index') : '#' }}" class="btn btn-sm btn-outline-warning font-weight-bold text-dark">
                                Edit FAQs <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Testimonials -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-primary"><i class="fas fa-comment-dots mr-1"></i> Testimonials</h5>
                            <p class="text-muted small">Manage client reviews & ratings (Active: {{ $testimonialCount }})...</p>
                            <a href="{{ Route::has('admin.testimonials.index') ? route('admin.testimonials.index') : '#' }}" class="btn btn-sm btn-outline-primary font-weight-bold">
                                Edit Reviews <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-indigo"><i class="fas fa-users mr-1"></i> Team Members</h5>
                            <p class="text-muted small">Update team member profiles and social links...</p>
                            <a href="{{ Route::has('admin.team.index') ? route('admin.team.index') : '#' }}" class="btn btn-sm btn-outline-primary font-weight-bold">
                                Edit Team <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Clients Section -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-success"><i class="fas fa-handshake mr-1"></i> Client Brands</h5>
                            <p class="text-muted small">Manage client company logos for Swiper slider...</p>
                            <a href="{{ Route::has('admin.clients.index') ? route('admin.clients.index') : '#' }}" class="btn btn-sm btn-outline-success font-weight-bold">
                                Edit Clients <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Management -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100 hover-card">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-secondary"><i class="fas fa-shoe-prints mr-1"></i> Footer & CTA</h5>
                            <p class="text-muted small">Update footer details, links & CTA banner...</p>
                            <a href="{{ Route::has('admin.footer.index') ? route('admin.footer.index') : '#' }}" class="btn btn-sm btn-outline-secondary font-weight-bold">
                                Edit Footer <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Live Website Quick Link -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card bg-success border-0 shadow-sm h-100 hover-card">
                        <div class="card-body text-white">
                            <h5 class="font-weight-bold"><i class="fas fa-globe mr-1"></i> Live Website</h5>
                            <p class="small opacity-75">View main website frontend live in new tab...</p>
                            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-light font-weight-bold text-success">
                                Visit Site <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Tables Row -->
    <div class="row">
        <!-- Recent Demo Requests -->
        <div class="col-lg-6 mb-4">
            <div class="card card-danger card-outline shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold m-0"><i class="fas fa-desktop text-danger mr-2"></i>Recent Demo Requests</h3>
                    <a href="{{ Route::has('admin.demo_requests.index') ? route('admin.demo_requests.index') : '#' }}" class="btn btn-sm btn-danger ml-auto">View All</a>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped text-center m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>ISP Company</th>
                                <th>Phone</th>
                                <th>Users</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDemos as $demo)
                                <tr>
                                    <td class="font-weight-bold text-left">{{ $demo->company_name }}</td>
                                    <td><a href="tel:{{ $demo->phone }}">{{ $demo->phone }}</a></td>
                                    <td><span class="badge badge-light border">{{ $demo->user_count ?? 'N/A' }}</span></td>
                                    <td>
                                        @if($demo->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($demo->status == 'contacted')
                                            <span class="badge badge-info">Contacted</span>
                                        @elseif($demo->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-3">No recent demo requests found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Contact Messages -->
        <div class="col-lg-6 mb-4">
            <div class="card card-info card-outline shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold m-0"><i class="fas fa-envelope text-info mr-2"></i>Recent Contact Messages</h3>
                    <a href="{{ Route::has('admin.contact.index') ? route('admin.contact.index') : '#' }}" class="btn btn-sm btn-info ml-auto">View All</a>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped text-center m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Sender Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMessages as $msg)
                                <tr>
                                    <td class="font-weight-bold text-left">{{ $msg->name }}</td>
                                    <td class="text-left">{{ Str::limit($msg->email, 18) }}</td>
                                    <td class="text-left">{{ Str::limit($msg->subject, 20) }}</td>
                                    <td><span class="badge badge-light border">{{ $msg->created_at->format('d M') }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-3">No recent contact messages found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection