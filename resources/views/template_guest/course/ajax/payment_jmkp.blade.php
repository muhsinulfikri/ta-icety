@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('info'))
    <div class="alert alert-warning">{{ session('info') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="p-3">
    <h5 class="fw-bold mb-3">Payment Final Exam JMKP</h5>

    <p>Course: <strong>{{ $course->TITLE_ACTIVITY }}</strong></p>
    <p>Price: <strong>Rp {{ number_format($course->PRICE_JMKP) }}</strong></p>

    <hr>

    @if($payment && $payment->status == 'paid')
        <button class="btn btn-primary w-100">
            Cek Final Exam
        </button>
    @else
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
</script>
