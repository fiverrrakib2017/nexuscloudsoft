// var customerViewRoute = "{{ route('admin.customer.view', ':id') }}";

function render_customer_column(data, type, row, ) {
    var customerId = row.customer ? row.customer.id : '0';
    //var baseUrl = window.location.origin;
    var viewUrl = baseUrl + "/admin/customer/view/" + customerId;

    switch (row.customer.status) {
        case 'online':
            icon = '<i class="fas fa-unlock" style="font-size:15px;color:green;margin-right:8px;" title="Online"></i>';
            break;

        case 'offline':
            icon = '<i class="fas fa-lock" style="font-size:15px;color:red;margin-right:8px;" title="Offline"></i>';
            if (row.customer.last_seen) {
                last_seen = `<small style="color:gray;margin-top:2px;">(${__time_ago(row.customer.last_seen)})</small>`;
            }
            break;

        case 'expired':
            icon = '<i class="fas fa-clock" style="font-size:15px;color:orange;margin-right:8px;" title="Expired"></i>';
            break;

        case 'blocked':
            icon = '<i class="fas fa-ban" style="font-size:15px;color:darkred;margin-right:8px;" title="Blocked"></i>';
            break;

        case 'disabled':
            icon = '<i class="fas fa-user-slash" style="font-size:15px;color:gray;margin-right:8px;" title="Disabled"></i>';
            break;

        case 'discontinue':
            icon = '<i class="fas fa-times-circle" style="font-size:15px;color:#ff6600;margin-right:8px;" title="Discontinue"></i>';
            break;

        default:
            icon = '<i class="fa fa-question-circle" style="font-size:18px;color:gray;margin-right:8px;" title="Unknown"></i>';
            break;
    }

    return `
        <a href="${viewUrl}" style="display:flex;align-items:center;text-decoration:none;color:#333;">
            ${icon}
            <span style="display:flex;flex-direction:column;line-height:1.1;">
                <span style="font-size:16px;font-weight:bold;">${row.customer.fullname}</span>
                ${last_seen}
            </span>
        </a>
    `;
}
