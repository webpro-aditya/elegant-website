<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <style type="text/css">
        @media (max-width:767px) {
            .table-xs {
                width: 100% !important;
            }
        }

        iframe {
            background: #fff !important;
        }

        body {
            background: #edf2f7;
        }

        table {
            width: 600px !important;
            word-break: break-word !important;
            background: #fff;
        }
    </style>
</head>

<body>
    <table width="600" bgcolor="#f9f9f9" style="font-family: MyriadPro-Regular, 'Myriad Pro Regular', MyriadPro, 'Myriad Pro', Helvetica, Arial, sans-serif;  margin: 0 auto;
        background: transparent;">
        <tbody>
            <tr>
                <td align="center" style="padding: 5px 15px 0px 15px;" class="section-padding">
                    <table border="0" cellpadding="0" align="center" cellspacing="0" class="responsive-table" style="width: 100%;background-color: #2d3748;">
                        <tbody>
                            <tr>
                                <td style="">
                                    <img src="{{ asset('images/web/elegant-svg/elegant-logo.svg') }}" style="padding: 5px 10px;max-width: 130px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table width="600" bgcolor="#fff" style="font-size:13px;font-family: MyriadPro-Regular, 'Myriad Pro Regular', MyriadPro, 'Myriad Pro', Helvetica, Arial, sans-serif; background-color: #fff !important; margin: 0 auto;">
        <tbody>
            <tr>
                <td style="padding:20px 30px 30px 30px;">
                    <p style="font-size:14px; color:#000;">
                    <p>
                    <p>Hello   !</p>
                    </p>
                    <p>Thank you for subscribing to our newsletter!</p>
                    <p>We are excited to have you on board. As a subscriber, you will receive the latest updates, exclusive offers, and valuable insights right in your inbox.
                    Stay tuned for our upcoming newsletters and don't hesitate to reach out if you have any questions or feedback.
                    </p>
                    <br>
                   
                    <p>Date: {{ $date->format('Y-m-d') }}</p>
                </td>
            </tr>            
            <tr></tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="padding: 10px 15px;
                    background: #2d3748;
                    text-align: center;">
                    <p style="font-size:10px; color: #fff;">
                        Copyright © {{ $company_name }} {{ Date('Y') }}
                        . All Rights Reserved</p>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
