<?php
const ERROR_API = "Error calling API";
const URL = "https://apirest.isendpro.com/cgi-bin/";
const PATH_CREDIT_SMS = "credit";
const PATH_SEND_SMS = "sms";

class ISendPro
{
    /**
     * @var string
     */
    private $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function checkCredit(): array
    {
        $url = URL . PATH_CREDIT_SMS . '?keyid=' . $this->accessToken . '&credit=2';
        $response = $this->cURL($url);

        if (!$response) {
            return ERROR_API;
        }

        return $response;
    }

    /**
     * @param string $message
     * @param string $recipients
     * 
     * @return string
     */
    public function sendSms($transmitter, string $message, array $recipients = []): array
    {
        $url = URL . PATH_SEND_SMS;
        $payload = [
            'keyid' => $this->accessToken,
            'num' => $recipients,
            'sms' => $message,
            'emetteur' => $transmitter
        ];
        $response = $this->cURL($url, $payload);

        if (!$response) {
            return ERROR_API;
        }

        return $response;
    }

    /**
     * @param string $url
     * @param array $payload
     * 
     * @return array
     */
    public function cURL(string $url, $payload = []): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
        }
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($output === false)
            throw new Exception(curl_error($ch), curl_errno($ch));

        curl_close($ch);

        return [
            'HTTP_STATUS_CODE' => $info['http_code'],
            'BODY' => json_decode($output)
        ];
    }
}
