<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendEmail
{
    public function sendEmail($view, $id, $email, $token, $subject, $response, $from_email, $from_name)
    {
        Mail::send($view, ['reactBaseURL' => config('app_env.REACT_BASE_URL'), 'id' => $id, 'email' => $email, 'token' => $token, 'response' => $response, 'from_email' => $from_email, 'from_name' => $from_name], function ($message) use ($response, $subject, $email, $from_email, $from_name) {
            $message->to($email);
            $message->from($from_email, $from_name);
            $message->subject($subject);
            if ($response != null) {
                return response()->json([
                    'status' => 1,
                    'message' => $response
                ]);
            }
        });
    }
}
