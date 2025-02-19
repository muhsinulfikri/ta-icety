<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .certificate {
            width: 800px;
            background: white;
            display: flex;
            border: 2px solid #ccc;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .left {
            width: 30%;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .left h2 {
            font-size: 24px;
            margin: 20px 0;
        }
        .left .modules {
            font-size: 14px;
            text-align: left;
            margin-top: 20px;
        }
        .left .modules ul {
            padding: 0;
            list-style-type: none;
        }
        .left .modules li {
            margin: 10px 0;
        }
        .right {
            width: 70%;
            padding: 30px;
        }
        .right h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .right h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }
        .right p {
            font-size: 16px;
            line-height: 1.5;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="wrapper-page">
        <div class="box">
            <div class="image">
                <img src="<?= $IMAGE ?>">
            </div>
        </div>
        <div class="certificate">
            <div class="left">
                <h2>Certificate of Completion</h2>
                <p>Approximately <?= $DURATION ?> months <?= $HOURS ?> hours to complete</p>
                <div class="modules">
                    <h3>Modules Completed</h3>
                    <ol>
                        @foreach($INFO_SERTIF as $title)
                            <li>{{ $title }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="right">
                <p><strong>12 April 2024</strong></p>
                <h1>{{ $NAME }}</h1>
                <p>has successfully completed all required modules of the online learning program on Icety.</p>
                <h2><?= $ACTIVITY ?></h2>
                <p><?= $SUMMARY ?></p>
                <div class="signature">
                    <p><strong>Dr. Eva Handriyantini, S.Kom., M.MT</strong></p>
                    <p>Director of Learning & Innovation</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
