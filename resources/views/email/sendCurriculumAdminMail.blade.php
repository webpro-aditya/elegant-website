<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Curriculum Download Request</title>
    <style type="text/css">
        @media (max-width:767px) {
            .table-xs {
                width: 100% !important;
            }
        }

        body {
            background: #edf2f7;
            margin: 0;
            padding: 0;
        }

        table {
            width: 600px !important;
            word-break: break-word !important;
            background: #fff;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table width="600" bgcolor="#f9f9f9" style="margin: 0 auto; background: transparent;">
        <tbody>
            <tr>
                <td align="center" style="padding: 5px 15px 0px 15px;">
                    <table border="0" cellpadding="0" align="center" cellspacing="0" style="width: 100%;background-color: #2d3748;">
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ asset('images/web/elegant-svg/elegant-logo.svg') }}" 
                                         style="padding: 5px 10px;max-width: 130px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Body -->
    <table width="600" bgcolor="#fff" style="font-size:13px;font-family: Arial, sans-serif; margin: 0 auto;">
        <tbody>
            <tr>
                <td style="padding:20px 30px 30px 30px;">
                    <p style="font-size:16px; color:#000; font-weight:bold;">New Curriculum Download Request</p>
                    <p style="font-size:14px; color:#000;">Hello Admin,</p>
                    <p style="font-size:14px; color:#000;">A user has downloaded the curriculum. Below are the details:</p>

                    <table style="width:100%; margin-top:15px; font-size:14px; color:#000;">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>+{{ $country_code ?? 'N/A' }} {{ $phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Message:</strong></td>
                            <td>{{ $user_message ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Course:</strong></td>
                            <td>{{ $course_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>{{ $date->format('Y-m-d') }}</td>
                        </tr>
                    </table>

                    <br>
                    <p style="font-size:14px; color:#000;">Please log into the admin panel for more details if needed.</p>
                </td>
            </tr>
        </tbody>

        <!-- Footer -->
        <tfoot>
            <tr>
                <td style="padding: 10px 15px; background: #2d3748; text-align: center;">
                    <p style="font-size:10px; color: #fff;">
                        Copyright © {{ $company_name }} {{ date('Y') }}. All Rights Reserved
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
