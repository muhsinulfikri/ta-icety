<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        @page {
        size: A4 landscape;
        margin: 0;
        }

        body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
        }

        .certificate {
        position: relative;
        width: 1122px;
        height: 793px;
        background: url({{ $IMAGE }}) no-repeat center center;
        background-size: cover;
        }
        .certificate-number {
        position: absolute;
        top: 5%;
        right: 5%;
        font-size: 16px;
        font-weight: bold;
        }

        .text-container {
        position: absolute;
        width: 70%;
        left: 32.5%;
        top: 20%;
        right: 10%;
        }

        .date {
        font-size: 16px;
        font-style: italic;
        margin-top: 15px;
        }

        .name {
        font-size: 32px;
        font-weight: bold;
        }

        .intitusi {
        font-size: 16px;
        padding-top: 5px;
        font-weight: bold;
        }

        .description {
        font-size: 18px;
        margin-top: 20px;
        max-width: 80%;
        }

        .course-title {
        font-size: 28px;
        font-weight: bold;
        margin-top: 75px;
        }

        .modules {
        position: absolute;
        left: 6%;
        top: 47.5%;
        width: 250px;
        color: white;
        font-size: 16px;
        text-align: left;
        }

        .modules ul {
        list-style-type: none;
        padding: 0;
        margin-left: 10px;
        }

        .modules li {
        margin-bottom: 10px;
        }

        .signature {
        position: absolute;
        bottom: 10%;
        right: 10%;
        font-size: 14px;
        text-align: center;
        }

        .signature .name {
        font-weight: bold;
        }

        .signature .title {
        font-style: italic;
        }
        .duration-info {
        font-size: 16px;
        font-style: italic;
        margin-top: 7px;
        color: #333;
        }
        .qr-container {
            position: absolute;
            left: 32.5%;
            top: 70%;
            width: 100px;
            height: 100px;
        }

        .qr-container img {
            width: 100%;
            height: auto;
        }

        .modules-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .total-materi {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-number">{{ $NO_SERTIF }}</div>
        @php
            $infoLines = explode('</p>', $INFO_SERTIF);
            $firstLine = strip_tags($infoLines[0]);
            $totalMateri = explode(',', $firstLine)[0];
            array_shift($infoLines);
            $InfoSertif = implode('</p>', $infoLines);
        @endphp
        <div class="modules">
            <div class="modules-header">
                <div class="total-materi">
                    <p style="font-size: 16px; color: white;">{{ $totalMateri }}</p>
                </div>
        </div>
        <div class="modules-list">
            {!! $InfoSertif !!}
        </div>
    </div>


    <div class="text-container">
        <div class="date">{{ date('d F Y',strtotime($DATE)) }}</div>
        <div class="name">{{ $NAME }}</div>
        @if (!empty($INTITUSI))
            <div class="intitusi">{{ strtoupper($INTITUSI) }}</div>
        @endif
        <div class="course-title">{{ $ACTIVITY }}</div>
        <div class="description">
            {{ strip_tags($SUMMARY) }}
        </div>
        <div class="duration-info">
            @if ($DURATION == 0)
            <p>Has been completed this course in 1 days.</p>
            @else
            <p>Has been completed this course in <?= $DURATION ?> days.</p>
            @endif
        </div>
    </div>
        <div class="qr-container">
            <img src="data:image/svg+xml;base64,<?= $QR ?>" alt="QR Code">
        </div>
    </div>
</body>
</html>
