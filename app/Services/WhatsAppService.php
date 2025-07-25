<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Http\CurlClient;
use Twilio\Http\GuzzleClient;
use GuzzleHttp\Client as Guzzle;

class WhatsAppService
{
    protected Client $client;

    public function __construct()
    {
        // Use Guzzle and disable SSL verification (for local only!)
        $guzzle = new Guzzle(['verify' => false]); //Guzzle is a PHP HTTP client used to make HTTP requests
        $httpClient = new GuzzleClient($guzzle);

        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token'),
            null,
            null,
            $httpClient
        );
    }

    public function sendMessage(string $to, string $message): void
    {
        $this->client->messages->create("whatsapp:$to", [
            'from' => config('services.twilio.whatsapp_from'),
            'body' => $message,
        ]);
    }
}
