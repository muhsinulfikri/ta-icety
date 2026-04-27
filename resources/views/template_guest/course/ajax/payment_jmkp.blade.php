<div class="p-3">
    @if($payment && $payment->status == 'paid')
        <h5 class="fw-bold mb-3">Final Exam JMKP</h5>
        <p>1. Pendaftaran berkas peserta APL 01 dapat dilakukan maksimal H-3 hari kerja pada link <a href="https://bit.ly/Pendaftaran_Sertifikasi_JMKP_2026" target="_blank">https://bit.ly/Pendaftaran_Sertifikasi_JMKP_2026</a> dan APL 02 disubmit maksimal di H-1 hari kerja ..</p>
        <p>2. APL 02 akan masuk ke email masing2 peserta saat APL 01 sudah d terima oleh tim kami</p>
    @else
        <h5 class="fw-bold mb-3">Payment Final Exam JMKP</h5>

        <p>Course: <strong>{{ $course->TITLE_ACTIVITY }}</strong></p>
        <p>Price: <strong>Rp {{ number_format($course->PRICE_JMKP) }}</strong></p>
        <hr>
        <button class="btn btn-success w-100"
            onclick="processPaymentJMKP('{{ $course->ID_COURSE }}')">
            Pay Now
        </button>
    @endif
</div>
<script>
    function processPaymentJMKP(courseId) {
        $.get(`/course/${courseId}/create-invoice`, function(res) {
            window.location.href = res.invoice_url;
        });
    }

    const params = new URLSearchParams(window.location.search);

    if (params.get('payment') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil',
            text: 'Final Exam sudah terbuka 🎉'
        }).then(() => {
            params.delete('payment');

            const newUrl = window.location.pathname + '?' + params.toString();
            window.history.replaceState({}, document.title, newUrl);
        });

    } else if (params.get('payment') === 'failed') {
        Swal.fire({
            icon: 'error',
            title: 'Pembayaran Gagal',
            text: 'Ulangi Pembayaran!'
        }).then(() => {
            params.delete('payment');

            const newUrl = window.location.pathname + '?' + params.toString();
            window.history.replaceState({}, document.title, newUrl);
        });
    }
</script>
