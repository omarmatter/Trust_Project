<?php

namespace Modules\User\Serveices\SmsServeice;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class cequensSms implements smsInterface
{
    private $apiKey;
    private $username;

    public function __construct()
    {
        $this->apiKey = env('CEQUENS_API_KEY');
        $this->username = env('CEQUENS_USERNAME');
    }

    public function SigningIn()
    {


        $response = Http::withHeaders(['Accept' => 'application/json',
            'Content-Type' => ' application/json'
        ])->post('https://apis.cequens.com/auth/v1/tokens/', [
            'apiKey' => $this->apiKey,
            'userName' => $this->username
        ]);
        $res = json_decode($response->body());

        if ($res->replyCode != -1) {
            Log::info('found error');
            return $res->data->access_token;

        }

    }


    public function send($phone, $message)
    {

        $token = $this->SigningIn();
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer' . $token,
            'Content-Type' => 'application/json'
        ])->post('https://apis.cequens.com/sms/v1/messages', [
            'senderName' => 'senderName',
            'recipients' => $phone,
            'messageText' => $message
        ]);
        $res = json_decode($response->body());
        if ($res->replyCode != 0) {
            return coustom_response(false, $res->replyMessage, [], 500);
        } else {
            return coustom_response(true, $res->replyMessage, [], 200);
        }


    }

    public function getBalance()
    {

        $token = $this->SigningIn();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer' . $token
        ])->get('https://apis.cequens.com/sms/v1/account/balance');

        $res = json_decode($response->body());

        return coustom_response(true, 'Balance', $res->data);
    }
}
