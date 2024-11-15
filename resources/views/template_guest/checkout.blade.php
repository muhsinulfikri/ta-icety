<style>
    .page-header-custom {
        background: url('<?= asset(' assets_new') ?>/images/bg/illustration-bg.png') 50% 50%;
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
                    <h1>Shopping Cart</h1>
                    <ul class="header-bradcrumb justify-content-center">
                        <li><a href="{{ url('') }}">Home</a></li>
                        <li class="active" aria-current="page">Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="woocommerce single page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="woocommerce-cart">
                    <div class="woocommerce-cart-form">
                        <table
                            class="shop_table shop_table_responsive cart woocommerce-cart-form__contents table-responsive w-100"
                            cellspacing="0">
                            <thead>
                                <tr class="fw-normal">
                                    <th scope="col" width="2%"></th>
                                    <th scope="col" width="43%">Product</th>
                                    <th scope="col" width="18%">Price</td>
                                    <th scope="col" width="18%"></th>
                                    <th scope="col" width="18%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider text-black"
                                style="border-color:#C8C8C8; border-top-width: 2px !important">
                                <?php if (!empty($checkout)) { ?>
                                <?php foreach ($checkout as $item) : ?>
                                <tr class="align-items-center" id="items-<?= $item->ID_ORDER ?>">
                                    <td scope="row" class="text-center align-items-center">
                                        <input class="form-check-input" type="checkbox" name="cb_order"
                                            value="<?= $item->ID_ORDER ?>" data-price="<?= $item->PRICE_ORDER ?>"
                                            style="cursor: pointer;" onchange="CountTotalPrice(this)">
                                    </td>
                                    <td class="flex-row d-flex align-items-center">
                                        <img src="<?= !empty($item->IMAGE_ACTIVITY) ? $item->IMAGE_ACTIVITY : $item->IMAGE_EBOOK ?>"
                                            class="d-block img-fluid rounded-2 w-25">
                                        <span
                                            class="ms-2"><?= !empty($item->TITLE_ACTIVITY) ? $item->TITLE_ACTIVITY : $item->JUDUL ?></span>
                                    </td>
                                    <td class="align-items-center product-subtotal">
                                        <?= $item->PRICE_ORDER != 0 ? 'Rp ' . number_format($item->PRICE_ORDER, 2, ',', '.') : 'Free' ?>
                                    </td>
                                    <td></td>
                                    <td class="align-items-center">
                                        <button type="button" class="btn btn-outline-danger"
                                            data-id="<?= $item->ID_ORDER ?>" onclick="DeleteProduct(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('assets_new') }}/images/empty.svg" width="350">
                                        </div>
                                        <h3 class="font-sm text-center">No product</h2>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 ">
                <div class="cart-collaterals">
                    <div class="cart_totals ">
                        <h2>Order Summary</h2>
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                            <tbody>
                                {{-- <tr class="order-diskon">
                                    <th>Diskon</th>
                                    <td data-title="Diskon">
                                        <strong>
                                            <span class="woocommerce-Price-amount amount" id="diskon_pay">
                                                Rp 0
                                            </span>
                                        </strong>
                                    </td>
                                </tr> --}}
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td data-title="Total">
                                        <strong>
                                            <span class="woocommerce-Price-amount amount" id="total_pay">
                                                Rp 0,00
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- <div style="margin-top: 20px">
                            <span class="fw-bold">Voucher Promo</span>
                            <select name="promo_use" id="promoSelect" class="form-control my-2"
                                style="background: white">
                                <?php if(!empty($promo)) { ?>
                                <option value="0" selected>Not Using Promo Voucher</option>
                                @foreach ($promo as $item)
                                    <option data-unit="<?= $item->UNIT ?>" data-amount="<?= $item->AMMOUNT ?>"
                                        value="<?= $item->ID_PROMO ?>"><?= $item->PROMO_NAME ?>
                                    </option>
                                @endforeach
                                <?php } else { ?>
                                <option value="">No Voucher Available</option>
                                <?php } ?>
                            </select>
                        </div> --}}
                        <form id="FormBuyNow" method="POST" action="<?= url('purchase') ?>">
                            @csrf
                            <div id="data-input"></div>
                            <div class="wc-proceed-to-checkout">
                                <button type="button" class="checkout-button button alt wc-forward" onclick="BuyNow()">
                                    Proceed to checkout
                                </button>
                            </div>
                            <?php if (!empty($checking_trans)) { ?>
                            <div class="wc-proceed-to-checkout">
                                <button class="alt btn btn-main-2 btn-sm w-100 rounded" onclick="BuyNow()">
                                    Check Last Transaction
                                </button>
                            </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= session('msg') ?>
<script>
    var data = []
    var PreviousPayment = 0
    var TotalPayment = 0

    var idPromoCode = 0;
    document.getElementById('promoSelect').addEventListener('change', function() {
        idPromoCode = parseInt(this.value);
        var selectedOption = this.options[this.selectedIndex];
        var amountValue = selectedOption.getAttribute('data-amount');
        var unitValue = selectedOption.getAttribute('data-unit');
        var totalPay = TotalPayment;

        if (idPromoCode === 0) {
            document.getElementById('diskon_pay').textContent = "Rp 0";
            document.getElementById('total_pay').textContent = "Rp " + totalPay;
        }
        if (unitValue === 'persen') {
            discount = totalPay * (amountValue / 100);
            totalPay = totalPay - (totalPay * (amountValue / 100));

            document.getElementById('diskon_pay').textContent = "Rp " + discount;
            document.getElementById('total_pay').textContent = "Rp " + (totalPay);
        }
        if (unitValue === 'nominal') {
            document.getElementById('diskon_pay').textContent = "Rp " + amountValue;
            document.getElementById('total_pay').textContent = "Rp " + (totalPay - amountValue);
        }
    });

    console.log(idPromoCode);
    window.onload = function() {
        $('input[type="checkbox"]').prop('checked', false)
    }

    function CountTotalPrice(e) {
        let id = $(e).val()
        let value = $(e).data("price")
        if ($(e).is(':checked')) {
            TotalPayment += $(e).data("price")
            data.push({
                id: id,
                value: value
            })
        } else {
            for (let index = 0; index < data.length; index++) {
                if (data[index].id == id) {
                    locationIndex = index
                    data = data.filter(function(e) {
                        return e.id !== id;
                    });
                }
            }
            TotalPayment -= $(e).data("price")
        }
        console.log(TotalPayment);

        PreviousPayment = TotalPayment
        $('#total_pay').html('Rp ' + TotalPayment)
    }

    $('#search-btn').click(function() {
        $('#search-result').html("");
        getData($('#search-form').val())
    })

    $('#search-form').focusout(function() {
        $('#search-result').hide()
    })

    $('#search-form').click(function(e) {
        $('#search-result').html("");
        getData($(this).val())
    });

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        <?php if (!empty($list_promo)) { ?>
        <?php foreach ($list_promo as $item) { ?>
        $('#search-result').append(
            `<button class="d-flex flex-row align-items-center dropdown-item py-3"
                        data-promo-name="<?= $item->PROMO_NAME ?>"
                        data-value="<?= $item->AMMOUNT ?>"
                        data-id-code="<?= $item->ID_PROMO ?>" onclick="Disc(this)">
                        <div class="col-md-9">
                            <?= $item->PROMO_NAME ?>
                        </div>
                        <div class="col-md-2 vr" style="margin-top:8px;margin-bottom:8px;"></div>
                        <div class="col-md-1 border-0 rounded-pill" style="margin-left:10px;">
                            <?= $item->AMMOUNT ?> %
                        </div>
                    </button>`
        )
        <?php } ?>
        <?php } else { ?>
        $('#search-result').append(`<a class='dropdown-item'>No promo found</a>`)
        <?php } ?>

        if ($('#search-result').html() != "") {
            $('#search-result').show();
        }
    }

    function Disc(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        idPromoCode = $(e).data('id-code')
        if (TotalPayment != 0) {
            if (TotalPayment < PreviousPayment) {
                TotalPayment = PreviousPayment
            }

            $("#search-form").focusout();
            $('#search-form').val($(e).data('promo-name') + " " + $(e).data('value') + " %")
            TotalPayment = TotalPayment - (TotalPayment * ($(e).data('value') / 100));
            $('#total_pay').html('<s>Rp ' + format(PreviousPayment) + ',00</s> <br> Rp ' + format(TotalPayment) + ',00')
        } else {
            Toast.fire({
                icon: 'error',
                title: `You Cann't Use Coupon, if total is 0`
            })
        }
    }

    function BuyNow() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (!empty($checking_trans)) { ?>
        // Toast.fire({
        //     icon: 'error',
        //     title: 'Complete your transaction first!'
        // })
        <?php } else { ?>
        if (data != "") {
            for (let index = 0; index < data.length; index++) {
                $('#data-input').append('<input type="hidden" name="id_order_purchase[' + index + ']" value="' + data[
                    index].id + '" />')
                $('#data-input').append('<input type="hidden" name="id_promo_code" value="' + idPromoCode + '" />')
            }
            $("#FormBuyNow").submit();
        } else {
            Toast.fire({
                icon: 'error',
                title: '<?= empty($checkout) != '' ? 'No product in cart!' : 'Please choose product first!' ?>'
            })
        }
        <?php } ?>
    }

    var format = function(num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ".") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(".");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

    function DeleteProduct(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let timerInterval
                Swal.fire({
                    title: 'Delete On Proccess !',
                    html: 'it will be over in a few seconds.',
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: '<?= Request::segment(0) ?>/delete/order?id_order=' + $(e)
                                .data("id"),
                            type: "GET",
                            success: function(data) {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Order Deleted"
                                })
                                $('#items-' + $(e).data("id")).remove()
                                location.reload()
                            },
                            error: function(data) {
                                Toast.fire({
                                    icon: 'error',
                                    title: "Failed to delete order"
                                })
                            }
                        });
                    }
                })
            }
        })
    }
</script>
