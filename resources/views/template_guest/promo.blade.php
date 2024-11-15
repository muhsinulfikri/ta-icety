<div class="container px-4 px-md-0 py-4 pb-6 pt-3">
    <h5 class="py-2 fw-semibold">Voucher Promo</h5>
    <hr class="opacity-25">

    <div class="row gap-4 mt-5">
            @if ($promo == null)
                <div class="col d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets_new') }}/images/empty.svg" width="350">
                </div>
                <h4 class="font-sm text-center">Belum Ada Voucher</h4>
            @endif
            @foreach ($promo as $item)
            <div class="col d-flex justify-content-center align-items-center border border-4 rounded-3 border-primary"
                style="background-color:#E9E9E9">
                <div class="py-4" style="">
                    <img src="<?= ('assets\images\promo-black.svg') ?>" style="color:black;height:80%" />
                    <div class="fw-semibold" style="margin-top:20px; font-size:0.9rem">Valid Until : {{ $item->EXP_DATE }}</div>
                </div>
                <div class="d-flex flex-column align-items-center border-start border-5 mx-4 ps-4 border-dark">
                    <div class="fw-bold" style="font-size:5rem;margin-top: 30px;">{{ $item->PROMO_NAME }}</div>
                    @if ($item->UNIT == 'persen')
                    <div class="fw-bold" style="font-size:2rem;margin-top: 30px;">{{ $item->AMMOUNT }}%</div>
                    @else
                    <div class="fw-bold" style="font-size:2rem;margin-top: 30px;">Rp.{{ $item->AMMOUNT }}</div>
                    @endif
                    @if ($item->PROMO_FOR == 0)
                    <div class="fw-bold" style="font-size:1.5rem;margin-top: 10px;">For All Purchase</div>
                    @elseif ($item->PROMO_FOR == 1)
                    <div class="fw-bold" style="font-size:1.5rem;margin-top: 10px;">For Courses</div>
                    @elseif ($item->PROMO_FOR == 2)
                    <div class="fw-bold" style="font-size:1.5rem;margin-top: 10px;">For Events</div>
                    @elseif ($item->PROMO_FOR == 3)
                    <div class="fw-bold" style="font-size:1.5rem;margin-top: 10px;">For Books</div>
                    @endif
                    <form action="voucher/store" method="POST" enctype="multipart/form-data" id="form_claim">
                        @csrf
                        <div class="d-flex align-items-center mt-4">
                            <input type="text" name="id_promo" value="{{ $item->ID_PROMO }}" hidden>
                            <input type="text" name="status" id="status_claim" value="1" hidden>
                            <button type="submit" id="btn_claim"
                            class="h-auto d-flex align-items-center justify-content-center btn btn-primary rounded-1 fs-6 text-center fw-semibold text-white border-0"
                            style="--bs-btn-padding-x: 2rem">Claim</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
    </div>
</div>

<script>
    @if(session()->has('err_msg'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('err_msg') }}'
        })
    @endif
    @if(session()->has('succ_msg'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('succ_msg') }}'
        })
    @endif
</script>


