<style>
.search-results-container {
    padding: 0;
    margin-top: 10px;
    max-height: 300px;
    overflow-y: auto;
}

.search-result-item {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: background-color 0.3s ease;
}

.search-result-item:hover {
    background-color: #f1f1f1;
}

.search-result-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
}

.search-result-link .user-info {
    margin-left: 10px;
    font-size: 14px;
}

.user-name {
    font-weight: bold;
    font-size: 16px;
    color: #333;
}

.user-meta {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}

.user-meta .user-id, .user-meta .user-phone {
    margin-right: 10px;
}

.last-seen {
    font-size: 12px;
    color: #888;
}

/* Status Avatar Badges */
.status-avatar-badge {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin-right: 12px;
    flex-shrink: 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    /* box-shadow: 0 0 0 0 rgba(46, 164, 79, 0.7); */
    animation: pulse-green 1.5s infinite;
}

/* Status Icon Styles */
.badge-status-active      { background-color: #e6f4ea; color: #28a745; border: 1px solid #b7e1cd; }
.badge-status-offline     { background-color: #fce8e6; color: #dc3545; border: 1px solid #f5c2c7; }
.badge-status-expired     { background-color: #fef7e0; color: #fd7e14; border: 1px solid #ffeba8; }
.badge-status-blocked     { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.badge-status-disabled    { background-color: #e9ecef; color: #6c757d; border: 1px solid #dee2e6; }
.badge-status-discontinue { background-color: #fff3cd; color: #ff6600; border: 1px solid #ffe8a1; }

.search-result-item:hover .user-name {
    color: #007bff;
}

/* Not Found Alert Box Style */
.no-result-found {
    padding: 15px;
    text-align: center;
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}
</style>

<!-- SidebarSearch Form -->
<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input id="search_input" class="form-control form-control-sidebar" type="search" placeholder="Search by Name, ID, or Phone" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar" id="search_button">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>

<!-- Search Results -->
<ul id="search_results" class="list-group" style="display: none;">
    <!-- Dynamic search results will be appended here -->
</ul>

<script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('Backend/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#search_input').on('input', function() {
            var search_term = $(this).val().trim();

            if (search_term.length > 0) {
                $.ajax({
                    url: "{{ route('admin.customer.search') }}",
                    method: 'GET',
                    data: { query: search_term },
                    success: function(response) {
                        var results = response.data;
                        var resultList = $('#search_results');
                        resultList.empty();

                        if (results && results.length > 0) {
                            resultList.show();
                            results.forEach(function(user) {
                                var statusBadge = '';
                                var last_seen = '';
                                var viewUrl = '{{ route('admin.customer.view', ':id') }}'.replace(':id', user.id);

                                if (user.status === 'active') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-active" title="Online/Active"><i class="fas fa-unlock"></i></div>';
                                } else if (user.status === 'offline') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-offline" title="Offline"><i class="fas fa-lock"></i></div>';
                                    if (user.last_seen) {
                                        last_seen = `<small style="color:gray;margin-top:2px;">(${__time_ago(user.last_seen)})</small>`;
                                    }
                                } else if (user.status === 'expired') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-expired" title="Expired"><i class="fas fa-clock"></i></div>';
                                } else if (user.status === 'blocked') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-blocked" title="Blocked"><i class="fas fa-ban"></i></div>';
                                } else if (user.status === 'disabled') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-disabled" title="Disabled"><i class="fas fa-user-slash"></i></div>';
                                } else if (user.status === 'discontinue') {
                                    statusBadge = '<div class="status-avatar-badge badge-status-discontinue" title="Discontinue"><i class="fas fa-times-circle"></i></div>';
                                }

                                resultList.append(`
                                    <li class="list-group-item search-result-item" data-id="${user.id}">
                                        <a href="${viewUrl}" style="display:flex;align-items:center;text-decoration:none;color:#333;">
                                            ${statusBadge}
                                            <span style="display:flex;flex-direction:column;line-height:1.2;">
                                                <span style="font-size:15px;font-weight:bold;">${user.username}</span>
                                                ${last_seen}
                                                <small style="color:#6c757d; margin-top:2px;">User ID: ${user.id} | Phone: ${user.phone ?? 'N/A'}</small>
                                            </span>
                                        </a>
                                    </li>
                                `);
                            });
                        } else {
                            resultList.show();
                            resultList.append(`
                                <li class="list-group-item no-result-found">
                                    <i class="fas fa-exclamation-circle text-warning mr-1"></i> No customer found
                                </li>
                            `);
                        }
                    },
                    error: function() {
                        console.error('Error fetching search results');
                    }
                });
            } else {
                $('#search_results').hide();
            }
        });

        $('#search_results').on('click', '.search-result-item', function() {
            var customer_id = $(this).data('id');
            if(customer_id) {
                window.location.href = "{{ route('admin.customer.view', ':id') }}".replace(':id', customer_id);
            }
        });
        /*-----Drop Down Off when click empty space---------*/
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.form-inline').length) {
                $('#search_results').hide();
            }
        });
    });
</script>