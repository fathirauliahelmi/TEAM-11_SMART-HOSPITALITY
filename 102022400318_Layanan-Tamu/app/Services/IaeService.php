<?php

namespace App\Services;

class IaeService
{
    public function getM2MToken()
    {
        $payload = json_encode([
            'api_key' => env('IAE_API_KEY')
        ]);

        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $payload
            ]
        ];

        $context = stream_context_create($opts);

        $response = file_get_contents(
            env('IAE_SSO_URL') . '/api/v1/auth/token',
            false,
            $context
        );

        $data = json_decode($response, true);

        return $data['token'] ?? null;
    }

    public function auditSoap(array $data)
    {
        $token = $this->getM2MToken();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:iae="http://iae.central/audit">
  <soap:Body>
    <iae:AuditRequest>
      <iae:TeamID>' . env('IAE_TEAM_ID') . '</iae:TeamID>
      <iae:ActivityName>GuestSessionCreated</iae:ActivityName>
      <iae:LogContent><![CDATA[' . json_encode($data) . ']]></iae:LogContent>
    </iae:AuditRequest>
  </soap:Body>
</soap:Envelope>';

        $opts = [
            'http' => [
                'method' => 'POST',
                'header' =>
                    "Authorization: Bearer {$token}\r\n" .
                    "Content-Type: text/xml\r\n",
                'content' => $xml
            ]
        ];

        $context = stream_context_create($opts);

        $response = file_get_contents(
            env('IAE_SSO_URL') . '/soap/v1/audit',
            false,
            $context
        );

        preg_match(
            '/<iae:ReceiptNumber>(.*?)<\/iae:ReceiptNumber>/',
            $response,
            $matches
        );

        return $matches[1] ?? null;
    }

    public function publishRabbitMq(array $message)
    {
        $token = $this->getM2MToken();

        $payload = json_encode([
            'routing_key' => 'guest.session.created',
            'message' => $message
        ]);

        $opts = [
            'http' => [
                'method' => 'POST',
                'header' =>
                    "Authorization: Bearer {$token}\r\n" .
                    "Content-Type: application/json\r\n",
                'content' => $payload
            ]
        ];

        $context = stream_context_create($opts);

        $response = file_get_contents(
            env('IAE_SSO_URL') . '/api/v1/messages/publish',
            false,
            $context
        );

        return json_decode($response, true);
    }
}