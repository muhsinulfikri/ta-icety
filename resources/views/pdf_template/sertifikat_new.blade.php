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
        margin-top: 40px;
        }

        .name {
        font-size: 32px;
        font-weight: bold;
        }

        .description {
        font-size: 18px;
        margin-top: 30px;
        max-width: 80%;
        }

        .course-title {
        font-size: 28px;
        font-weight: bold;
        margin-top: 100px;
        }

        .modules {
        position: absolute;
        left: 5%;
        top: 55%;
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
        margin-top: 10px;
        color: #333; /* Warna lebih netral */
        }
        .qr-container {
            position: absolute;
            margin-top: 30px;
            width: 100px;
            height: 100px;
        }

        .qr-container img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="certificate">
      <div class="certificate-number">{{ $NO_SERTIF }}</div>
      <div class="modules">
        {!! $INFO_SERTIF !!}
      </div>

      <div class="text-container">
        <div class="date">{{ date('d F Y',strtotime($DATE)) }}</div>
        <div class="name">{{ $NAME }}</div>
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
        <div class="qr-container">
            <img src="data:image/svg+xml;base64,<?= $QR ?>" alt="QR Code">
        </div>
      </div>
    </div>
  </body>
</html>
