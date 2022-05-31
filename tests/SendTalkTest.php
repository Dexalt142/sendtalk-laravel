<?php

namespace Dexalt142\SendTalk\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

class SendTalkTest extends TestCase {

    /**
     * The API key to use for testing.
     *
     * @var string
     */
    private $apiKey;

    public function setUp(): void {
        $this->apiKey = 'test';
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_api_key_is_not_set() {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'status' => 400,
                'error' => [
                    'code' => '40001',
                    'message' => 'Request headers are required (API-Key)',
                    'field' => '',
                ],
                'data' => []
            ]))
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode('40001');
        $this->expectExceptionMessage('Request headers are required (API-Key)');

        $sendTalk = new \Dexalt142\SendTalk\SendTalk(null, new Client(['handler' => HandlerStack::create($mock)]));
        $sendTalk->sendTextMessage('+6281234567890', 'Hello World!');
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_api_key_is_invalid() {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'status' => 400,
                'error' => [
                    'code' => '49103',
                    'message' => 'API-Key is not found',
                    'field' => '',
                ],
                'data' => []
            ]))
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode('49103');
        $this->expectExceptionMessage('API-Key is not found');

        $sendTalk = new \Dexalt142\SendTalk\SendTalk('invalid', new Client(['handler' => HandlerStack::create($mock)]));
        $sendTalk->sendTextMessage('+6281234567890', 'Hello World!');
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_phone_is_not_set() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 400,
                'error' => [
                    'code' => '40002',
                    'message' => 'Phone is required',
                    'field' => 'phone',
                ],
                'data' => []
            ]))
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode('40002');
        $this->expectExceptionMessage('Phone is required');

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $sendTalk->sendTextMessage('+6281234567890', 'Hello World!');
    }

    /**
     * @test
     */
    public function it_should_send_a_text_message() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 200,
                'error' => [
                    'code' => '',
                    'message' => '',
                    'field' => '',
                ],
                'data' => [
                    'success' => true,
                    'message' => 'The message has been added to queue',
                    'reason' => '',
                    'id' => 'f26ccf7a-d867-b3a4-d333-117ec668718d',
                ]
            ]))
        ]);

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $response = $sendTalk->sendTextMessage('+6281234567890', 'Hello World!');
        $this->assertNotNull($response);
    }

    /**
     * @test
     */
    public function it_should_send_an_image_message() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 200,
                'error' => [
                    'code' => '',
                    'message' => '',
                    'field' => '',
                ],
                'data' => [
                    'success' => true,
                    'message' => 'The message has been added to queue',
                    'reason' => '',
                    'id' => 'f26ccf7a-d867-b3a4-d333-117ec668718d',
                ]
            ]))
        ]);

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $response = $sendTalk->sendImageMessage('+6281234567890', 'https://example.com/image.png', 'hello_world.png', 'Hello World!');
        $this->assertNotNull($response);
    }

    /**
     * @test
     */
    public function it_should_send_an_otp_message() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 200,
                'error' => [
                    'code' => '',
                    'message' => '',
                    'field' => '',
                ],
                'data' => [
                    'success' => true,
                    'message' => 'The message has been added to queue',
                    'reason' => '',
                    'id' => 'f26ccf7a-d867-b3a4-d333-117ec668718d',
                ]
            ]))
        ]);

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $response = $sendTalk->sendOTPMessage('+6281234567890', 'Hello World!');
        $this->assertNotNull($response);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_message_id_is_not_set() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 400,
                'error' => [
                    'code' => '40002',
                    'message' => 'Message ID is required',
                    'field' => 'id',
                ],
                'data' => []
            ]))
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode('40002');
        $this->expectExceptionMessage('Message ID is required');

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $sendTalk->getMessageStatus(null);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_message_is_not_found() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 400,
                'error' => [
                    'code' => '40401',
                    'message' => 'Message is not found',
                    'field' => '',
                ],
                'data' => []
            ]))
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionCode('40401');
        $this->expectExceptionMessage('Message is not found');

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $sendTalk->getMessageStatus('f26ccf7a-d867-b3a4-d333-117ec668718d');
    }

    /**
     * @test
     */
    public function it_should_return_a_message_status_when_getting_a_message() {
        $mock = new MockHandler([
            new Response(200, ['API-Key' => $this->apiKey], json_encode([
                'status' => 200,
                'error' => [
                    'code' => '',
                    'message' => '',
                    'field' => '',
                ],
                'data' => [
                    'success' => 'sent',
                    'isPending' => false,
                    'isSent' => true,
                    'sentTime' => 1635774548482,
                    'currency' => "IDR",
                    'price' => 100,
                    'createdTime' => 1635774547004,
                ]
            ]))
        ]);

        $sendTalk = new \Dexalt142\SendTalk\SendTalk($this->apiKey, new Client(['handler' => HandlerStack::create($mock)]));
        $response = $sendTalk->getMessageStatus('f26ccf7a-d867-b3a4-d333-117ec668718d');
        $this->assertNotNull($response->success);
        $this->assertNotNull($response->isPending);
        $this->assertNotNull($response->isSent);
        $this->assertNotNull($response->sentTime);
        $this->assertNotNull($response->currency);
        $this->assertNotNull($response->price);
        $this->assertNotNull($response->createdTime);
    }

}