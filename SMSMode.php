<?php
const ERROR_API = "Error calling API";
const URL = "https://api.smsmode.com/http/1.6/";
const PATH_CREDIT_SMS = "credit.do";
const PATH_SEND_SMS = "sendSMS.do";

/**
 * 
 * @author Touil ALi
 */
class SMSMode
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
    public function checkCredit(): string
    {
        $url = URL . PATH_CREDIT_SMS . '?accessToken=' . $this->accessToken;
        $result = $this->cURL($url);

        if (!$result) {
            return ERROR_API;
        }

        return $result;
    }

    /**
     * @param string $message
     * @param string $recipients
     * 
     * @return string
     */
    public function sendSmsGet(string $message, array $recipients = []): string
    {
        $this->serialize($recipients);
        $message = iconv("UTF-8", "ISO-8859-15", $message);
        $url = URL . PATH_SEND_SMS . '?accessToken=' . $this->accessToken . '&message=' . urlencode($message) . '&numero=' . $recipients;
        $result = $this->cURL($url);

        if (!$result) {
            return ERROR_API;
        }

        return $result;
    }

    /**
     * @param string $url
     * 
     * @return string
     */
    public function cURL(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if ($output === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        return $output;
    }

    /**
     * @param array $recipients
     */
    public function serialize(&$recipients): void
    {
        $recipients = implode(',', $recipients);
    }
}
