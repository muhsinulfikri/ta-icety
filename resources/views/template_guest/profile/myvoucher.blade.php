@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#AD0B0B">{{ __('profile.txt_voucher') }}</h3>
    <table class="table" style="color: #8A8A8E">
        <thead>
            <tr class="fw-normal text-black">
                <td scope="col" class="fw-semibold fs-5" width="60%">Voucher</td>
                <td scope="col" class="fw-semibold fs-5" width="20%">{{ __('profile.txt_expired') }}</td>
            </tr>
        </thead>

        <?php foreach ($vouchers as $item): ?>
            @if ($item->STATUS == 0 && $item->STATUS == 2)
                <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <span class="ms-2">
                                    Voucher tidak tersedia
                                </span>
                            </div>
                        </td>
                        <td class="py-3">
                            -
                        </td>
                </tbody>
            @elseif ($item->STATUS == 1)
                <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                    <td class="py-3" hidden><?= $item->ID_PROMO; ?></td>
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            <span class="ms-2">
                                <?= $item->PROMO_NAME ?>
                            </span>
                        </div>
                    </td>
                    <td class="py-3">
                        <?= date('j F Y', strtotime($item->EXP_DATE)) ?>
                    </td>
                </tbody>
            @endif
        <?php endforeach; ?>
    </table>
    <span class="text-danger">* {{ __('profile.txt_accessible') }}</span>
    <?php
    if (empty($vouchers)) {
        echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>No Vouchers Available</div>";
    }
    ?>
</div>
@endsection
