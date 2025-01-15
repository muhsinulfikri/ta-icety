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
            <div class="font ms-2 fw-semibold" style="font-size: 0.75rem !important;line-height: 22px;">
                <?php
                $date = new DateTime($item->DATE_UPLOAD);
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                $formatter->setPattern('EEEE, dd MMMM yyyy');
                echo $formatter->format($date);
                ?>
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
