<div class="main-content">
    <h3>Hasil Jawaban {{ $act->TITLE_ACTIVITY }}</h3>
    <h4>Nama : {{ $user->NAME }}</h4>
    @if (!empty($jawabanAll))
        <div class="d-flex justify-content-between my-3">
            <button class="btn btn-sm btn-outline-primary" id="prev-btn">Previous</button>
            <span>Hasil ke-<span id="current-index">1</span> dari {{ count($jawabanAll) }}</span>
            <button class="btn btn-sm btn-outline-primary" id="next-btn">Next</button>
        </div>
        <div id="hasil-container"></div>
        <script>
            const jawabanAll = @json($jawabanAll);
            let currentIndex = 0;

            function renderJawaban(index) {
                const hasil = jawabanAll[index];
                const container = document.getElementById('hasil-container');
                let html = '';

                hasil.hasil.forEach((detail, i) => {
                    html += `
                        <div class="mb-3">
                            <div class="d-flex flex-row mb-1">
                                <input type="text" class="form-control" value="${i + 1}. ${detail.soal}" disabled>
                            </div>
                            <p><strong>Jawaban = ${detail.kunci}</strong></p>
                    `;

                    detail.pilihan.forEach((pilihan, j) => {
                        const isDipilih = pilihan.trim() === detail.jawaban_tertulis.trim();
                        const isBenar = detail.kunci === String.fromCharCode(97 + j);
                        html += `
                            <div class="form-group row mb-2 align-items-center">
                                <label class="col-auto col-form-label pr-1">${String.fromCharCode(97 + j)}.</label>
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control form-control-sm" value="${pilihan}" readonly
                                            style="${isDipilih ? 'font-weight: bold; color: ' + (isBenar ? 'green' : 'red') : ''}">
                                        ${isDipilih ? `<small class="ml-2">(Jawaban ${isBenar ? 'Benar' : 'Salah'})</small>` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += `</div>`;
                });

                container.innerHTML = html;
                document.getElementById('current-index').innerText = index + 1;
            }

            document.addEventListener('DOMContentLoaded', () => {
                renderJawaban(currentIndex);

                document.getElementById('next-btn').addEventListener('click', () => {
                    if (currentIndex < jawabanAll.length - 1) {
                        currentIndex++;
                        renderJawaban(currentIndex);
                    }
                });

                document.getElementById('prev-btn').addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                        renderJawaban(currentIndex);
                    }
                });
            });
        </script>
    @else
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data hasil jawaban tidak ditemukan.',
                allowOutsideClick: false,
                showConfirmButton: true,
            });
        </script>
    @endif

    {{-- <div class="form-soal py-4 my-3 pl-4" style="border: 1px solid #edf2f9; border-radius: .25rem; cursor: grab">
        <div class="form-group row">
            <div class="container d-flex justify-content-left align-items-left flex-column my-4">
                @foreach ($jawabanAll as $item)
                    @foreach ($item['hasil'] as $index => $detail)
                        <div class="d-flex flex-row">
                            <div class="pe-3 flex-1 w-100">
                                <input type="text" class="form-control"
                                    value="{{ $index + 1 . '. ' . $detail['soal'] }}" disabled>
                            </div>
                        </div>
                        <p><strong>Jawaban = {{ $detail['kunci'] }}</strong></p>
                        @foreach ($detail['pilihan'] as $index => $pilihan)
                            <div class="form-group row mb-2 align-items-center">
                                <label class="col-auto col-form-label pr-1">
                                    {{ chr(97 + $index) }}.
                                </label>
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{ $pilihan }}" readonly
                                            style="@if (trim($pilihan) === trim($detail['jawaban_tertulis'])) font-weight: bold; color: {{ $detail['kunci'] == chr(97 + $index) ? 'green' : 'red' }}; @endif">
                                        @if (trim($pilihan) === trim($detail['jawaban_tertulis']))
                                            <small class="ml-2">
                                                (Jawaban {{ $detail['kunci'] == chr(97 + $index) ? 'Benar' : 'Salah' }})
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
    </div> --}}
</div>

