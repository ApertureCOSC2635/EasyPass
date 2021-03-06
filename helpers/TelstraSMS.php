<?php

// TelstraSMS-PHP Wrapper
// This is the original work of Zach de Koning (Melbourne, Australia) - Last update 9 July 2016.
// Original source code is at https://github.com/Zachoz/TelstraSMS-PHP
// As there is no licence declaration standard copyright applies.
// Accordingly the code is used with the permission of the owner and is not to be reused for any other purpose.

class TelstraSMS
{
    private $appKey = "", $appSecret = "", $recipient = "", $message = "", $accessToken = "", $messageId = "";
    function __construct($appKey, $appSecret, $recipient, $message)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->recipient = $recipient;
        $this->message = $message;
        $this->recipient = str_replace(" ", "", $recipient); // Remove space characters in phone number if present
    }
    public function send()
    {
        $this->accessToken = $this->authenticate(); // Get auth token
        $this->messageId = $this->sendMessage(); // Send the message
    }
    public function authenticate()
    {
        $base = "https://api.telstra.com/v1/oauth/token?client_id=" . $this->appKey . "&client_secret=" .
            $this->appSecret . "&grant_type=client_credentials&scope=SMS";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Telstra SMS");
        //curl_setopt($curl, CONNECTTIMEOUT, 1);
        $content = curl_exec($curl);
        if (!$content){
           echo 'cURL error (' . curl_errno($curl) . '): ' . curl_error($curl);
        }
        curl_close($curl);
        return json_decode($content, true)["access_token"];
    }
    private function sendMessage()
    {
        $base = "https://api.telstra.com/v1/sms/messages";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Telstra SMS");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(("Authorization: Bearer " . $this->accessToken)));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            "to" => $this->recipient,
            "body" => $this->message
        )));
        //curl_setopt($curl, CONNECTTIMEOUT, 1);
        $content = curl_exec($curl);
        curl_close($curl);
        return json_decode($content, true)["messageId"];
    }
    public function getStatus()
    {
        $base = "https://api.telstra.com/v1/sms/messages/" . $this->messageId;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $base);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Telstra SMS");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(("Authorization: Bearer " . $this->accessToken)));
        //curl_setopt($curl, CONNECTTIMEOUT, 1);
        $content = curl_exec($curl);
        curl_close($curl);
        return json_decode($content, true);
    }
}
?>
