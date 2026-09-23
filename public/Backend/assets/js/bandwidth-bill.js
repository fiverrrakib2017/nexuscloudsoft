$(document).ready(function () {

    _init_select2();
    calculateAll();

    $('#bill_form').submit(function(e) {
        e.preventDefault();

        let submitBtn = $(this).find('button[type="submit"]');
        let originalBtnText = submitBtn.html();

        submitBtn.html('<span class="spinner-border spinner-border-sm"></span>');
        submitBtn.prop('disabled', true);

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,

            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                }
            },

            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                } else {
                    toastr.error('An error occurred.');
                }
            },

            complete: function() {
                submitBtn.html(originalBtnText);
                submitBtn.prop('disabled', false);
            }
        });
    });


    /* --------------- CALCULATION ---------------- */

    function calculateAll() {

        let subTotal = 0;
        let totalVat = 0;

        $('#itemsTable tbody tr').each(function () {

            let qty  = parseFloat($(this).find('.qty').val()) || 0;
            let rate = parseFloat($(this).find('.rate').val()) || 0;
            let vat  = parseFloat($(this).find('.vat').val()) || 0;

            let rowSubTotal = qty * rate;
            let rowTotal    = rowSubTotal + vat;

            $(this).find('.total').val(rowTotal.toFixed(2));

            subTotal += rowSubTotal;
            totalVat += vat;
        });

        let grandTotal = subTotal + totalVat;

        $('.sub-total').val(subTotal.toFixed(2));
        $('.total-vat').val(totalVat.toFixed(2));
        $('.grand-total').val(grandTotal.toFixed(2));

        let paid     = parseFloat($('.paid_amount').val()) || 0;
        let discount = parseFloat($('.discount').val()) || 0;

        let due = grandTotal - paid - discount;

        $('.due_amount').val(due.toFixed(2));
    }


    $(document).on('input', '.qty, .rate, .vat, .paid_amount, .discount', function () {
        calculateAll();
    });


    /* ================= ADD ITEM ================= */

    $('#addItem').on('click', function () {

        let row = `
        <tr>
            <td>
                <select class="form-control item-select" name="items[]">
                    <option value="">Select Item</option>
                    ${window.itemsOptions}
                </select>
            </td>

            <td>
                <input type="number" class="form-control qty" name="qty[]" value="1" min="1">
            </td>

            <td>
                <input type="number" class="form-control rate" name="rate[]" step="0.01">
            </td>

            <td>
                <input type="number" class="form-control vat" name="vat[]" step="0.01">
            </td>

            <td>
                <input type="text" class="form-control total" readonly>
            </td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>`;

        $('#itemsTable tbody').append(row);
        _init_select2();
    });


    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
        calculateAll();
    });


    function _init_select2() {
        $('.item-select').select2({
            width: '100%',
            placeholder: 'Select Item'
        });
    }

});
