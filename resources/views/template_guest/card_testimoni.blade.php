<div class="d-flex flex-column p-4 bg-white rounded mx-3">
    <div class="info d-flex gap-3">
        <div>
            <img src="{{ asset('icety_assets') }}/{{ $banner }}" class="img-fluid" style="aspect-ratio: 1/1;max-height: 68px" />
        </div>
        <div class="align-self-center">
            <div class="text-black fw-semibold">{{ $name }}</div>
            <div class="text-black" style="font-size: 0.8rem;line-height: 16px;">{{ $position }}</div>
        </div>
    </div>
    <div class="testi d-flex flex-column pt-4">
        <div>
            <img src="{{ asset('icety_assets') }}/quote2.svg" class="img-fluid" style="max-height: 16px;" />
        </div>
        <div class="text-black py-2 text-center" style="line-height: 22px;">
            {{ $testimoni }}
        </div>
        <div class="align-self-end">
            <img src="{{ asset('icety_assets') }}/quote1.svg" class="img-fluid" style="max-height: 16px;" />
        </div>
    </div>
</div>