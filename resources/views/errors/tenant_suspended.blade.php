<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 500px; width: 100%; }
        .icon-box { font-size: 60px; color: #dc3545; }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="card p-5 mx-auto">
        <div class="icon-box mb-4">
            <i class="fas fa-ban"></i>
        </div>
        <h3 class="text-danger fw-bold">Service Temporarily Suspended</h3>
        <p class="text-muted mt-3">
            Dear <strong>{{ $tenant_name }}</strong>,  subscription or portal access has been temporarily suspended by the administrator.
        </p>
        <p class="text-secondary small">
            Please resolve your pending invoices or contact customer support for assistance.
        </p>
        <hr class="my-4">
        <div class="d-grid">
            <a href="mailto:support@yourdomain.com" class="btn btn-outline-danger">
                <i class="fas fa-envelope me-2"></i> Contact Support
            </a>
        </div>
    </div>
</div>

</body>
</html>
