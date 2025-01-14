@extends('template_guest.profile.profile_template')
@section('content')
<div class="col ms-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <h3 class="fw-bold pb-4" style="color:#AD0B0B">My Events</h3>
    <table class="table" style="color: #8A8A8E">
        <thead>
            <tr class="fw-normal text-black">
                <td scope="col" class="fw-bold fs-5" width="70%">Event</td>
                <td scope="col" class="fw-bold fs-5" width="30%">Author</td>
            </tr>
        </thead>
        <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
            <?php foreach ($mybook as $item): ?>
            <tr onclick="window.location = '<?= url('/ebooks/view/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $item->JUDUL)) . '?id_book=' . $item->ID_BUKU) ?>'"style="cursor:pointer">
                <td class="py-3">
                    <div class="d-flex align-items-center">
                        <img src="<?= $item->IMAGE_EBOOK ?>" class="d-block img-fluid rounded-2"
                            style="width: 80px; height: 80px; object-fit: cover">
                        <span class="ms-2">
                            <?= $item->JUDUL ?>
                        </span>
                    </div>
                </td>
                <td class="py-3">
                    <div class="d-flex align-items-center" style="width: 80px; height: 80px;>
                        <span class="ms-2">
                            <?= $item->AUTHOR ?>
                        </span>
                    </div>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
if (empty($mybook)) {
    echo "<div class='text-center fs-4 fw-semibold h-75 d-flex align-items-center justify-content-center'>No Event Available</div>";
}
    ?>
@endsection
