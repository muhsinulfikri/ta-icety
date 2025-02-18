<div class="container">
    <h1 class="text-center my-4">Detail Sertifikat</h1>
    
    <div class="certificate mb-3">
        <h2 class="text-center">Nama Pemilik Sertifikat</h2>
        <h4 class="text-center">{{$sertifikat->NAME}}</h4>
        
        <h3 class="text-center my-3">Kegiatan yang Diikuti</h3>
        <p class="text-center">{{$sertifikat->TITLE_ACTIVITY}}</p>
        
        <h3 class="text-center my-3">Sertifikat</h3>
        <div id="document-frame" class="d-flex align-self-center justify-content-center row">
            <p class="text-center loader">Memuat dokumen...</p>
            <img class="loader d-flex align-self-center justify-content-center" style="max-height: 70px; max-width: 70px;" src="https://icons8.com/preloaders/preloaders/1476/Rocket.gif" alt="Loader.gif" />
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
                        frameborder="0" sandbox="allow-same-origin allow-scripts"></iframe>`;
            $('#document-frame').html(iframeHTML);

            $('#document-iframe').on('load', function() {
                $('.loader').hide();
                isLoaded = true;
            });

            if (attempts < maxRetries && !isLoaded) {
                setTimeout(() => {
                    loadIframe();
                }, 20000);
            } else if (!isLoaded) {
                $('#document-frame').html('<p class="text-center">Gagal memuat dokumen. Silakan coba lagi nanti.</p>');
            }
        }

        loadIframe();
    });
    
</script>

