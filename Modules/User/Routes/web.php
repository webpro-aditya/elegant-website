<?php

namespace Modules\User\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel using SendGrid SMTP.', function ($message) {
        $message->to('webpro.aditya@gmail.com')
                ->subject('Laravel SendGrid SMTP Test');
    });

    return 'Test email sent successfully!';
});

/*

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use SendGrid\Mail\Mail as SendGridMail;

Route::get('/test-sendgrid', function () {

    $email = new SendGridMail();

    $email->setFrom(
        env('MAIL_FROM_ADDRESS'),
        env('MAIL_FROM_NAME')
    );

    $email->setSubject('SendGrid API Test Mail');
    $email->addTo('webpro.aditya@gmail.com');
    $email->addContent(
        'text/plain',
        'This is a test mail sent via SendGrid API from Hostinger server.'
    );

    $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($email);

        Log::info('SendGrid test mail sent', [
            'status' => $response->statusCode(),
            'headers' => $response->headers(),
            'body' => $response->body(),
        ]);

        return response()->json([
            'success' => true,
            'status_code' => $response->statusCode(),
            'message' => 'Mail request sent to SendGrid. Check inbox/spam.'
        ]);

    } catch (\Exception $e) {

        Log::error('SendGrid test mail failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

*/