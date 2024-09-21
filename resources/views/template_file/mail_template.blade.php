<!DOCTYPE html>
<html>

<head>
    <title>PMI</title>
</head>
<style type="text/css">
    @media only screen and (min-width: 620px) {
        .u-row {
            width: 600px !important;
        }

        .u-row .u-col {
            vertical-align: top;
        }

        .u-row .u-col-100 {
            width: 600px !important;
        }

    }

    @media (max-width: 620px) {
        .u-row-container {
            max-width: 100% !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        .u-row .u-col {
            min-width: 320px !important;
            max-width: 100% !important;
            display: block !important;
        }

        .u-row {
            width: 100% !important;
        }

        .u-col {
            width: 100% !important;
        }

        .u-col>div {
            margin: 0 auto;
        }
    }

    body {
        margin: 0;
        padding: 0;
    }

    table,
    tr,
    td {
        vertical-align: top;
        border-collapse: collapse;
    }

    p {
        margin: 0;
    }

    .ie-container table,
    .mso-container table {
        table-layout: fixed;
    }

    * {
        line-height: inherit;
    }

    a[x-apple-data-detectors='true'] {
        color: inherit !important;
        text-decoration: none !important;
    }

    table,
    td {
        color: #000000;
    }

    #u_body a {
        color: #0000ee;
        text-decoration: underline;
    }
</style>

<body>
    <p>
        <?= $details['body'] ?>
        <br>
        <?php if (!empty($details['link'])) { ?>
    <div align="left">
        <a href="{{ $details['link'] }}" target="_blank" class="v-button" style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #387de5; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:49%; max-width:15%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word;font-size: 14px;">
            <span style="display:block;padding:10px 20px;line-height:120%;"><span style="line-height: 16.8px;">{{ $details['title'] }}</span></span>
        </a>
    </div>
<?php } ?>
<br>
Terima kasih. Semoga sukses.
<br>
<br>
Salam,<br>
Panitia LOKREATIF 2023 <?= date('Y') ?>
</p>
<h1></h1>
</body>

</html>