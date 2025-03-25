<div class="container my-5">
    <div class="row">
        <!-- Kolom kiri: Informasi Sertifikat -->
        <div class="col-md-6">
            <div class="p-4 shadow-sm bg-light rounded">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/person-circle.svg') }}" alt="User Image"
                        class="rounded-circle me-3" style="width: 60px; height: 60px;">
                    <div>
                        <h4 class="fw-bold mb-1">Completed by {{ $sertifikat->NAME }}</h4>
                        <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($sertifikat->DATE_COMPLETED)->format('F d, Y') }}</p>
                    </div>
                </div>
                <p class="mt-2 text-muted">Approximately 6 months at 10 hours a week to complete</p>
                <p class="mt-3">
                    {{ $sertifikat->NAME }}'s account is verified. ICETy certifies their successful completion of
                    <a href="#" class="text-decoration-none fw-bold">{{ $sertifikat->TITLE_ACTIVITY }}</a>.
                </p>
                <h5 class="mt-4 fw-bold">Course Certificates Completed</h5>
                <ul class="list-unstyled">
                    @foreach ($all_sertif as $item)
                        <li class="mb-1">✅ {{ $item->TITLE_ACTIVITY }}</li>
                    @endforeach
                </ul>
            </div>
        </div>


        <!-- Kolom kanan: Sertifikat -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div id="document-frame" class="w-100">
                <p class="text-center loader">Memuat dokumen...</p>
                <img class="loader" style="max-height: 70px; max-width: 70px;" src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const file = '<?= $sertifikat->FILE_SERTIFIKAT ?>';
        const maxRetries = 3;
        let attempts = 0;
        let isLoaded = false;

        function loadIframe() {
            if (isLoaded) return;

            attempts++;
            const iframeHTML = `<iframe id="document-iframe" src="https://docs.google.com/gview?embedded=true&url=${file}"
                        style="width:100%; height:500px;"
                        frameborder="0"></iframe>`;
            $('#document-frame').html(iframeHTML);

            $('#document-iframe').on('load', function() {
                $('.loader').hide();
                isLoaded = true;
            });

            if (attempts < maxRetries && !isLoaded) {
                setTimeout(loadIframe, 20000);
            } else if (!isLoaded) {
                $('#document-frame').html('<p class="text-center">Gagal memuat dokumen. Silakan coba lagi nanti.</p>');
            }
        }

        loadIframe();
    });
</script>
