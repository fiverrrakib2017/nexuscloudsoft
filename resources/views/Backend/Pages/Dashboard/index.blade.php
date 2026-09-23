@extends('Backend.Layout.App')

@section('title', 'Nexus Cloud Soft | Admin Dashboard')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@section('content')

<!-- Main Content -->
<div class="container-fluid">
    <!-- Top Stat Info-Boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-layer-group"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CMS Sections</span>
                    <span class="info-box-number">7 Active</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Demo Requests</span>
                    <span class="info-box-number">5 Pending</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-globe"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Website Status</span>
                    <span class="info-box-number text-success">Live Online</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Team Members</span>
                    <span class="info-box-number">4 Members</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Section Manager Cards -->
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Quick Section Editor</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Hero Section Card -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-primary"><i class="fas fa-star mr-1"></i> Hero Banner</h5>
                            <p class="text-muted small">Simplify Your ISP Business with One Powerful Platform...</p>
                            <a href="" class="btn btn-sm btn-outline-primary font-weight-bold">
                                Edit Hero Section <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- About Us Card -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-success"><i class="fas fa-building mr-1"></i> About Us</h5>
                            <p class="text-muted small">We Are a Team of Innovators Dedicated to Empowering Your Brand...</p>
                            <a href="" class="btn btn-sm btn-outline-success font-weight-bold">
                                Edit About Section <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Features Card -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-info"><i class="fas fa-cogs mr-1"></i> Features & Solutions</h5>
                            <p class="text-muted small">MikroTik Automation, OLT/ONU Management, Payment Gateways...</p>
                            <a href="" class="btn btn-sm btn-outline-info font-weight-bold">
                                Edit Features <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection