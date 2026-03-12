<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .content p {
            margin: 5px 0;
        }

        .footer {
            background: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>New Course Enquiry</h2>
        </div>
        <div class="content">
            <h1>Dear Admin,</h1>
            <p>A new enquiry has been submitted for the following course:</p>
            <p><strong>Enquirer Name:</strong> {{ $enquiryData->name }}</p>
            <p><strong>Email:</strong> {{ $enquiryData->email }}</p>
            <p><strong>Phone:</strong> +{{ $enquiryData->country_code }} {{ $enquiryData->phone }}</p>
            <p><strong>Course:</strong> {{ $enquiryData->course_name ?? 'Not Provided' }}</p>

            <p><strong>Message:</strong></p>
            <p>{{  $enquiryData->message ?? '' }}</p>
        </div>

    </div>
</body>

</html>