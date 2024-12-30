<style>
    .card-badge {
        width: fit-content;
        font-size: 0.75rem !important;
        line-height: 22px;
        border-radius: 30px;
        box-shadow: 1px 1px 8px rgb(0 0 0 / 25%) !important;
    }

    .card-course {
        box-shadow: 2px 2px 2px rgb(0 0 0 / 25%) !important;
        border: none;
        height: 286px;
        max-height: 286px;
    }

    .card-course .t-section:hover {
        position: absolute;
        bottom: 0;
        height: 100%;
        background-color: rgb(255, 255, 255);
        transition: transform 0.3s ease, height 0.3s ease;
    }

    .card-link {
        text-decoration: underline !important;
        color: #0B0B0B !important;
        font-weight: 600;
    }

    .card-link:hover {
        color: #AD0B0B !important;
    }
</style>

<div class="card card-course overflow-hidden " id="{{ $id }}" style="width: 276px; max-width: 276px;justify-self: center">
    <div>
        <img src="{{ asset('icety_assets') }}/{{ $banner }}" class="img-fluid" style="aspect-ratio: 23/13;" />
    </div>
    <div class="t-section h-100">
        <div class="p-3 h-100">
            <div class="bg-black shadow text-white px-2 py-0 mb-3 card-badge">{{ $badge }}</div>
            <div class="fw-semibold text-black fs-5 mb-3" style="line-height: 22px;">{{ $title }}</div>
            <div class="card-info" style="display: none;">
                <div class="text-black fs-6 mb-2" style="line-height: 20px;">{{ $description }}</div>
                <div class="d-flex justify-content-between mb-1">
                    <div>
                        <img src="{{ asset('icety_assets') }}/icon-team.svg" class="img-fluid" style="height: 12px;" />
                        <span class="text-black" style="font-size: 0.9rem">{{ $students }} Students</span>
                    </div>
                    <div>
                        <img src="{{ asset('icety_assets') }}/star-black.svg" class="img-fluid" style="height: 12px;" />
                        <img src="{{ asset('icety_assets') }}/star-black.svg" class="img-fluid" style="height: 12px;" />
                        <img src="{{ asset('icety_assets') }}/star-black.svg" class="img-fluid" style="height: 12px;" />
                        <img src="{{ asset('icety_assets') }}/star-black.svg" class="img-fluid" style="height: 12px;" />
                        <img src="{{ asset('icety_assets') }}/star-gray.svg" class="img-fluid" style="height: 12px;" />
                    </div>
                </div>
                <a href="{{ $link }}" class="card-link">Find out more</a>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#{{ $id }} .t-section').hover(
            function() {
                $("#{{ $id }} .card-info").css({
                    display: "block",
                });
            },
            function() {
                $("#{{ $id }} .card-info").css({
                    display: "none",
                });
            },
        );
    });
</script>