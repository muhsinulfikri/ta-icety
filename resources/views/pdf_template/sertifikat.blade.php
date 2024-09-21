<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }

        html,
        body {
            font-family: Arial, Helvetica;
            font-size: 14px;
        }

        .box {
            position: absolute;
        }

        .image img {
            width: 1122px;
            height: 793px;
        }

        .text-align-center {
            text-align: center;
        }

        .text {
            width: 580px;
        }
        .number {
            font-size: 22px;
            font-weight: bold;
            color: black;
            word-wrap: break-word;
            margin-top: -3%;
        }

        .box .valign-middle .name{
            padding: 19% 0px;
        }

        .name {
            font-size: 29px;
            font-weight: bold;
            color: black;
            line-height: 121%;
        }

        .description {
            font-size: 20px;
            font-weight: lighter;
            margin-top: 30%;
        }

        .detail-description {
            font-size: 25px;
            font-weight: bold;
            color: black;
            word-wrap: break-word;
            margin: auto;
        }

        .valign-middle {
            vertical-align: middle;
            color: black;
            padding: 40% 45%;
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

        <div class="box">
            <table class="valign-middle">
                <tr>
                    <th class="text-align-center">
                        <div class="text number">
                            <?= $NO_SERTIF ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>


        <div class="box">
            <table class="valign-middle">
                <tr>
                    <th class="text-align-center">
                        <div class="text name">
                            <?= $NAME ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>

        <div class="box">
            <table class="valign-middle">
                <tr>
                    <th class="text-align-center">
                        <div class="text description">
                            Congratulations on joining the <?= ($TYPE == "CRS") ? "course" : "event"; ?> entitled
                        </div>
                    </th>
                </tr>
                <tr>
                    <th class="text-align-center">
                        <div class="text detail-description">
                            <?= $ACTIVITY ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>