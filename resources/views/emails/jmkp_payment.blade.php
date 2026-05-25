<p>Halo Admin,<br>

Ada peserta yang sudah melakukan pembayaran Final Exam JMKP.<br>

Detail Peserta:<br>

* Nama: {{ $user->NAME }}<br>
* Email: {{ $user->EMAIL }}<br>
* No HP: {{ $user->TELP }}<br>
* Course: {{ $course->TITLE_ACTIVITY }}<br>
* Tanggal Bayar: {{ now()->format('d M Y H:i') }}<br>

Silakan dicek di sistem.<br>

Terima kasih.<br>
</p>
