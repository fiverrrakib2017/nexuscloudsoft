/*------------Re useable Customer name Column---------------*/
window.render_customer_name_column = function(row) {
    let icon = '';
    let last_seen = '';
    var customerId = row.customer ? row.customer.id : '0';
    var viewUrl = CUSTOMER_VIEW_URL.replace(':id', row.customer.id);
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




function __time_ago(datetime) {
    const now = new Date();
    const then = new Date(datetime);
    const diff = Math.floor((now - then) / 1000); // diff in seconds

    if (diff < 60) {
        return `${diff} sec${diff !== 1 ? 's' : ''} ago`;
    }

    const minutes = Math.floor(diff / 60);
    if (minutes < 60) {
        return `${minutes} min${minutes !== 1 ? 's' : ''} ago`;
    }

    const hours = Math.floor(diff / 3600);
    if (hours < 24) {
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
    }

    const days = Math.floor(diff / 86400);
    if (days < 7) {
        return `${days} day${days !== 1 ? 's' : ''} ago`;
    }

    return then.toLocaleString();
};
