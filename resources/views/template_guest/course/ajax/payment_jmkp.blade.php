<div class="p-3">
    <h5 class="fw-bold mb-3">Payment Final Exam JMKP</h5>

    <p>Course: <strong>{{ $course->TITLE_ACTIVITY }}</strong></p>
    <p>Price: <strong>Rp {{ number_format($course->PRICE_JMKP) }}</strong></p>

    <hr>

    <button class="btn btn-success w-100"
        onclick="processPaymentJMKP('{{ $course->ID_COURSE }}')">
        Pay Now
    </button>
</div>
<script>
    function processPaymentJMKP(courseId) {
        $.get(`/course/${courseId}/create-invoice`, function(res) {
            window.location.href = res.invoice_url;
        });
    }
</script>
