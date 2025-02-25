<div class="container my-5">
    <div class="row">
        <!-- Kolom kiri: Informasi Sertifikat -->
        <div class="col-md-6">
            <div class="certificate p-4 shadow-sm bg-light">
                <div class="text-center">
                    <img src="{{ asset('assets/images/person-circle.svg') }}" alt="User Image" class="rounded-circle mb-3">
                    <h2 class="fw-bold">{{$sertifikat->NAME}}</h2>
                    <p class="text-muted">Completed on: <strong>{{$sertifikat->DATE_COMPLETED}}</strong></p>
                </div>
                <h4 class="mt-4 fw-bold">Kegiatan yang Diikuti</h4>
                <p>{{$sertifikat->TITLE_ACTIVITY}}</p>

                <h4 class="mt-3 fw-bold">Sertifikat yang Telah Diselesaikan</h4>
                <ul class="list-unstyled">
                    @foreach ($all_sertif as $item)
                        <li>📌 {{ $item->TITLE_ACTIVITY }}</li>
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
