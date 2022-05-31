<?php

namespace Dexalt142\SendTalk;

use Exception;
use GuzzleHttp\Client;

class SendTalk {

    /**
     * The base url of SendTalk API.
     */
    const BASE_URL = 'https://sendtalk-api.taptalk.io/api/v1/message';

    /**
     * GuzzleHttp client instance.
     *
     * @var Client
     */
    private static $guzzleClient;

    /**
     * The API key for SendTalk API.
     * 
     * @var string
     */
    private static $apiKey;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @return void
     */
    public function __construct($apiKey, $guzzleClient = null) {
        self::$guzzleClient = $guzzleClient ?? new Client();
        self::$apiKey = $apiKey;
    }

    /**
     * Send text message.
     *
     * @param string $phoneNumber
     * @param string $content
     * @return string
     */
    public static function sendTextMessage($phoneNumber, $content) {
        $requestBody = [
            'phone' => self::formatPhoneNumber($phoneNumber),
            'messageType' => 'text',
            'body' => $content
        ];

        $response = self::sendRequest('send_whatsapp', 'POST', $requestBody);

        return $response->data->id;
    }

    /**
     * Send image message.
     *
     * @param string $phoneNumber
     * @param string $imageUrl
     * @param string $fileName
     * @param string $caption
     * @return string
     */
    public static function sendImageMessage($phoneNumber, $imageUrl, $fileName, $caption = null) {
        $requestBody = [
            'phone' => self::formatPhoneNumber($phoneNumber),
            'messageType' => 'image',
            'body' => $imageUrl,
            'fileName' => $fileName,
            'caption' => $caption
        ];

        $response = self::sendRequest('send_whatsapp', 'POST', $requestBody);

        return $response->data->id;
    }

    /**
     * Send OTP message.
     *
     * @param string $phoneNumber
     * @param string $content
     * @return string
     */
    public static function sendOTPMessage($phoneNumber, $content) {
        $requestBody = [
            'phone' => self::formatPhoneNumber($phoneNumber),
            'messageType' => 'otp',
            'body' => $content
        ];

        $response = self::sendRequest('send_whatsapp', 'POST', $requestBody);

        return $response->data->id;
    }

    /**
     * Get message status.
     * 
     * @param string $id
     * @return object
     */
    public static function getMessageStatus($id) {
        $requestBody = [
            'id' => $id
        ];

        $response = self::sendRequest('get_status', 'POST', $requestBody);

        return $response->data;
    }

    /**
     * Get the default request headers.
     *
     * @return array
     */
    private static function getHeaders() {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'API-Key' => self::$apiKey
        ];
    }

    /**
     * Send a HTTP request.
     * 
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return object
     */
    private static function sendRequest($endpoint, $method, $data = null) {
        $request = self::$guzzleClient->request($method, self::BASE_URL . '/' . $endpoint, [
            'headers' => self::getHeaders(),
            'json' => $data
        ]);

        $response = json_decode($request->getBody()->getContents());
        if($response->status !== 200) {
            throw new Exception($response->error->message, $response->error->code);
        }

        return $response;
    }

    /**
     * Format a phone number to the correct format.
     *
     * @param string $phoneNumber
     * @return string
     */
    private static function formatPhoneNumber($phoneNumber) {
        if(!$phoneNumber) return null;

        $phoneNumber = preg_replace('/[\s\-\(\)]+/', '', $phoneNumber);

        $stringReplacements = [
            '08' => '628',
            '+628' => '628'
        ];

        foreach($stringReplacements as $key => $value) {
            if(strpos($phoneNumber, $key) === 0) {
                $phoneNumber = substr_replace($phoneNumber, $value, 0, strlen($key));
            }
        }

        return $phoneNumber;
    }

}