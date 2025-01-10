<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .page-header-custom {
        background: url('<?= asset('assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: initial;
    }
</style>

<section class="page-header page-header-custom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 pe-3">
                <div class="title-block">
                    <h1>Checkout</h1>
                    <ul class="header-bradcrumb justify-content-center">
                        <li><a href="{{ url('') }}">Home</a></li>
                        <li class="active" aria-current="page">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="woocommerce single page-wrapper">
    <div class="container">
        <div id="alert_div"></div>
        <div class="row">
            <div class="col-12 col-lg-9 ">
                <form id="form-purchase" method="POST" action="<?= url('check_payment_status') ?>">
                    @csrf
                    <div class="woocommerce-cart">
                        <div class="woocommerce-cart-form">
                            <table
                                class="shop_table shop_table_responsive cart woocommerce-cart-form__contents table-responsive w-100"
                                cellspacing="0">
                                <thead>
                                    <tr class="fw-normal">
                                        <th scope="col" width="43%">Product</th>
                                        <th scope="col" width="18%"></th>
                                        <th scope="col" width="18%"></th>
                                        <th scope="col" width="18%">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider text-black"
                                    style="border-color:#C8C8C8; border-top-width: 2px !important">
                                    <?php
                                    $TotalBayar = 0;
                                    foreach ($order[0] as $item) :
                                        $TotalBayar += $item->PRICE_ORDER;
                                    ?>
                                        <tr class="">
                                            <td class="flex-row d-flex align-items-center">
                                                <img src="<?= !empty($item->IMAGE_ACTIVITY) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK ?>"
                                                    class="d-block img-fluid rounded-2 w-25">
                                                <span
                                                    class="ms-2"><?= !empty($item->TITLE_ACTIVITY) ? $item->TITLE_ACTIVITY : $item->JUDUL ?></span>
                                            </td>
                                            <td>
                                            </td>
                                            <td></td>
                                            <td class="product-subtotal">
                                                <?= 'Rp ' . number_format($item->PRICE_ORDER, 0, ',', '.') ?></td>
                                        </tr>
                                        <input type="hidden" name="tot_bayar" value="<?= $TotalBayar ?>">
                                        <input type="hidden" name="id_activity[]" value="<?= $item->ID_PRODUCT ?>">
                                        <input type="hidden" name="price[]" value="<?= $item->PRICE_ORDER ?>">
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="id_trans" value="<?= $id_trans ?>">
                    <input type="hidden" name="id_pay" value="<?= $id_trans ?>">
                    <input type="hidden" name="id_promo_code" id="id_promo_code">
                    <input type="hidden" name="id_pay_method"
                        value="<?= !empty($checking_trans) ? $checking_trans[0]->ID_PAY_METHOD : '' ?>">
                    <?php foreach ($order[0] as $item) { ?>
                        <input type="hidden" name="id_order_whenPay[]" value="<?= $item->ID_ORDER ?>">
                    <?php } ?>
                </form>
                <div class="d-flex flex-column flex-md-row justify-content-end mt-4">
                    <form action="<?= !empty($checking_trans) ? url('delete/pay') : url('checkout') ?>" method="POST"
                        id="form-cancel-trans">
                        @csrf
                        <input type="hidden" name="id_trans" value="<?= !empty($checking_trans) ? $id_trans : '' ?>">
                        <?php foreach ($order[0] as $item) { ?>
                            <input type="hidden" name="id_order[]" value="<?= $item->ID_ORDER ?>">
                        <?php } ?>
                    </form>
                    {{-- <div class="wc-proceed-to-checkout mx-auto">
                        <div class="coupon">
                            <input type="text" class="form control" name="coupon_code" id="coupon_code"
                                value="" placeholder="Promo Code">
                            <button type="button" class="button" name="apply_coupon" id="apply-coupon"
                                onclick="applyCode()" style="width: 200px;">Use Promo Code</button>
                        </div>
                    </div> --}}

                </div>
            </div>
            <div class="col-12 col-lg-3 ">
                <div class="cart-collaterals">
                    <div class="cart_totals ">
                        <h2>Order Summary</h2>
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                            <tbody>
                                <tr class="order-diskon">
                                    <th>Diskon</th>
                                    <td data-title="Diskon">
                                        <strong>
                                            <span class="woocommerce-Price-amount amount" id="diskon_pay">
                                                Rp 0
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td data-title="Total">
                                        <strong>
                                            <span class="woocommerce-Price-amount amount" id="total_pay">
                                                <?= 'Rp ' . number_format($TotalBayar, 0, ',', '.') ?>
                                                <input type="hidden" name="total_bayar" id="total_bayar"
                                                    value="<?= $TotalBayar ?>">
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($TotalBayar != 0)
                        <div style="margin-top: 20px">
                            <span class="fw-bold">Voucher Promo</span>
                            <select name="promo_use" id="promoSelect" class="form-control my-2"
                                style="background: white">
                                <?php if (!empty($promo) && $promo[0]->STATUS == 2) { ?>
                                    <option value="">No Voucher Available</option>
                                <?php } else if (!empty($promo)) { ?>
                                    <option value="0" selected>Not Using Promo Voucher</option>
                                    @foreach ($promo as $item)
                                    @if ($TotalBayar > $item->AMMOUNT)
                                    <option data-unit="<?= $item->UNIT ?>" data-amount="<?= $item->AMMOUNT ?>"
                                        value="<?= $item->ID_PROMO ?>"><?= $item->PROMO_NAME ?>
                                    </option>
                                    @endif
                                    @endforeach
                                <?php } else { ?>
                                    <option value="">No Voucher Available</option>
                                <?php } ?>
                            </select>
                        </div>
                        @endif
                        <div class="wc-proceed-to-checkout">
                            <button type="button" class="checkout-button btn btn-secondary" style="padding: 0.718047em 1.41575em;" id="pay">
                                {{ $TotalBayar == 0 ? 'Add Now' : 'Purchase Now' }}
                            </button>
                        </div>
                        <div class="wc-proceed-to-checkout">
                            <div class="alt btn btn-danger w-100 rounded" style="padding: 0.718047em 1.41575em;"
                                onclick="$('#form-cancel-trans').submit()">
                                Cancel Transaction
                            </div>
                        </div>
                        {{-- BUTTON PURCHASE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var idPromoCode = 0;
    if (<?= $TotalBayar ?> != 0) {
        document.getElementById('promoSelect').addEventListener('change', function() {
            idPromoCode = parseInt(this.value);
            var selectedOption = this.options[this.selectedIndex];
            var amountValue = selectedOption.getAttribute('data-amount');
            var unitValue = selectedOption.getAttribute('data-unit');
            var totalPay = <?= $TotalBayar ?>;

            if (idPromoCode === 0) {
                document.getElementById('id_promo_code').value = idPromoCode;
                document.getElementById('diskon_pay').textContent = "Rp 0";
                document.getElementById('total_pay').textContent = "Rp " + totalPay;
            }
            if (unitValue === 'persen') {
                discount = totalPay * (amountValue / 100);
                discount = Math.round(discount);
                totalPay = totalPay - (totalPay * (amountValue / 100));
                totalPay = Math.round(totalPay);

                document.getElementById('id_promo_code').value = idPromoCode;
                document.getElementById('diskon_pay').textContent = "Rp " + discount;
                document.getElementById('total_pay').textContent = "Rp " + (totalPay);
            }
            if (unitValue === 'nominal') {
                document.getElementById('id_promo_code').value = idPromoCode;
                document.getElementById('diskon_pay').textContent = "Rp " + amountValue;
                document.getElementById('total_pay').textContent = "Rp " + (totalPay - amountValue);
            }
        });
    }

    $('#pay').on('click', function() {
        Swal.fire({
            title: 'Loading Payment!',
            html: 'Please Wait ...',
            timerProgressBar: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        if (<?= $TotalBayar ?> == 0) {
            $('#form-purchase').submit();
            return;
        }

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // AJAX call to get the order ID
        $.ajax({
            url: '/get_order_id',
            type: "POST",
            data: {
                _token: csrfToken,
                TotPrice: <?= $TotalBayar ?>,
                Diskon: idPromoCode,
                id_order: $('input:hidden[name="id_order[]"]').map(function() {
                    return $(this).val();
                }).get()
            },
            dataType: 'json',
            success: function(response) {
                console.log(response.invoice.id);
                getInvoiceXendit(response.invoice.id, csrfToken); // Pass csrfToken for fetch
            },
            error: function(xhr, status, error) {
                displayError('Payment Error', xhr.responseJSON?.message || 'An error occurred while getting the order ID.');
                console.error(error);
                Swal.close();
            }
        });
    });

    // Function to handle the second step: fetching the invoice
    async function getInvoiceXendit(data, csrfToken) {
        try {
            const invoiceData = {
                xendit_id: data,
            };
            console.log(invoiceData);

            // Fetch call to create the invoice
            const fetchResponse = await fetch('/payment/get', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(invoiceData),
            });

            const responseData = await fetchResponse.json();
            console.log(fetchResponse);

            if (fetchResponse.ok && responseData.invoice_url) {
                window.location.href = responseData.invoice_url; // Redirect to the invoice URL
            } else {
                displayError('Payment Error', responseData?.message || 'An error occurred while creating the invoice.');
                console.error(responseData);
                Swal.close();
            }
        } catch (error) {
            displayError('Payment Error', error.message || 'An unexpected error occurred.');
            console.error(error);
            Swal.close();
        }
    }


    // Helper function to display error messages
    function displayError(title, message) {
        const alertContainer = document.getElementById('alert_div');
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                <i class="mdi mdi-block-helper label-icon"></i><strong>${title}</strong> - ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" 
                    style="transition: none; background-color: transparent; color: inherit;">
                </button>
            </div>
        `;
    }
</script>