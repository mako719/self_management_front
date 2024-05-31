<?php

namespace App\Services;

use App\Traits\Calendar;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalendarService
{
    use Calendar;

    public function __construct()
    {
    }

    public function calendarComponents(string $recordDate = null)
    {
        if ($recordDate) {
            if(preg_match('/\A[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}\z/', $recordDate) == false) {
                abort(404);
            }
        }

        return $this->calendar($recordDate);
    }

    public function getcalendarContents(string $recordDate = null)
    {
        // Guzzleを使ってAPIに接続
        $client = new Client();
        $apiUrl = config('app.api_url');
        $secretKey = config('app.api_secret_key');
        $userId = Auth()->id();
        $response = $client->request(
            'GET',
            "{$apiUrl}daily-report/{$recordDate}",
            [
                'headers' =>
                [
                    'Authorization' => "Bearer {$secretKey}",
                    'personal_id' => $userId,
                ],
                'debug' => false,
            ]
        );

        $responseBody = $response->getBody()->getContents();

        return json_decode($responseBody);
    }
}
