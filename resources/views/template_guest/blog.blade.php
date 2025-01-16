<style>
    .font {
        font-family: "Noto Sans", serif !important;
        color: black !important;
        line-height: 22px !important;
    }

    p {
        font-family: "Noto Sans", serif !important;
        color: black !important;
    }
</style>

<section class="container d-flex flex-column gap-6 my-5">
    @foreach($blog as $item)
    <div class="d-flex flex-column">
        <div class="d-flex flex-column-reverse flex-md-row justify-content-between">
            <div class="bg-black shadow text-white px-2 py-0 mb-2 card-badge font" style="color: white !important;">{{ $item->CATEGORY_BLOG }}</div>
            <div class="font ms-2 fw-semibold formatted-date" data-date="{{ $item->DATE_UPLOAD }}" style="font-size: 0.75rem !important;line-height: 22px;">
            </div>
        </div>

        <div class="mt-3">
            <h2 class="font" style=" line-height: 40px !important;">
                {{ $item->TITLE_BLOG }}
            </h2>
        </div>

        <!-- Creator blog -->
        <!-- <div class="d-flex gap-2 mt-4">
            <div>
                <img src="{{ asset('icety_assets') }}/avatar.svg" class="img-fluid" style="width:50px;height:50px" />
            </div>
            <div class="d-flex flex-column justify-content-center">
                <div class="font fw-bold">Siti Marlina</div>
                <div class="font" style="font-size: 0.7rem;">Ahli Sanitasi Makanan dan Kebersihan</div>
            </div>
        </div> -->

        <div class="mt-4">
            <img src="{{  $item->IMAGE_BLOG  }}" class="img-fluid w-100" />
        </div>

        <div class="mt-4">
            <p style="text-align: justify">{{ $item->TEXT_BLOG }}</p>
            <div class="font" style="font-size: 0.8rem">Kunjungi ICETy.org untuk kursus dan ebook eksklusif tentang <span class="text-lowercase">{{ $item->TITLE_BLOG }}</span>.</div>
        </div>
    </div>
    @endforeach

</section>
<script>
    //format date indonesia
    document.addEventListener('DOMContentLoaded', () => {
    // Array untuk hari dan bulan dalam Bahasa Indonesia
    const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Ambil semua elemen dengan kelas "formatted-date"
    const dateElements = document.querySelectorAll('.formatted-date');

    // Loop melalui setiap elemen dan format tanggalnya
    dateElements.forEach(el => {
        const dateUpload = el.getAttribute('data-date'); // Ambil tanggal dari atribut data
        const date = new Date(dateUpload); // Buat objek Date

        if (!isNaN(date.getTime())) { // Pastikan tanggal valid
            const hariIndo = hari[date.getDay()];
            const tanggal = date.getDate();
            const bulanIndo = bulan[date.getMonth()];
            const tahun = date.getFullYear();

            // Format akhir
            const formattedDate = `${hariIndo}, ${tanggal} ${bulanIndo} ${tahun}`;

            // Tampilkan hasil di elemen
            el.innerText = formattedDate;
        } else {
            el.innerText = 'Tanggal tidak valid'; // Jika tanggal tidak valid
        }
    });
});


</script>
