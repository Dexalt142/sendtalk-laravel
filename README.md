# SendTalk Laravel

Unofficial TapTalk's SendTalk library for Laravel.

[![PHPUnit Tests](https://github.com/Dexalt142/sendtalk-laravel/actions/workflows/test.yml/badge.svg)](https://github.com/Dexalt142/sendtalk-laravel/actions/workflows/test.yml)
[![Latest Version](https://img.shields.io/packagist/v/dexalt142/sendtalk?label=Latest%20Version&style=flat-square)](https://packagist.org/packages/dexalt142/sendtalk)
[![Packagist Downloads](https://img.shields.io/packagist/dm/dexalt142/sendtalk?label=Downloads&style=flat-square)](https://packagist.org/packages/dexalt142/sendtalk)
[![License](https://img.shields.io/github/license/dexalt142/sendtalk-laravel?label=License&style=flat-square)](https://github.com/Dexalt142/sendtalk-laravel/blob/master/LICENSE)

## 1. Installation

You can install this package through Composer CLI by running this command.

```bash
composer require dexalt142/sendtalk
```

Or you can modify the `composer.json` file and don't forget to run `composer install`.

```json
{
    "require": {
        "dexalt142/sendtalk": "1.*"
    }
}
```

## 2. Configuration

Before using this package, you need to set your SendTalk API key, you can do this by adding `SENDTALK_API_KEY` to the `.env` file.

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

SENDTALK_API_KEY=YOUR_SENDTALK_API_KEY_HERE

...
```

## 3. How to Use

There are two options to call a method, you can either use the regular class `Dexalt142\SendTalk\SendTalk` or Facade `Dexalt142\SendTalk\Facades\SendTalk`.

### 3.a. Get message status

```php
<?php

namespace App\Http\Controllers;

use Dexalt142\SendTalk\Facades\SendTalk;

class MessageController {

    public function getMessage() {
        // SendTalk::getMessageStatus($id)
        $message = SendTalk::getMessageStatus('f26ccf7a-d867-b3a4-d333-117ec668718d');
    }

}
```

If the message is exists, the method above will return a result like this example below, otherwise it will throw an exception.

```json
{
    "status": "read",
    "isPending": false,
    "isSent": true,
    "sentTime": 1653924408488,
    "currency": "IDR",
    "price": 75,
    "createdTime": 1653924407993
}
```

### 3.b. Send message

```php
<?php

namespace App\Http\Controllers;

use Dexalt142\SendTalk\Facades\SendTalk;

class MessageController {

    public function sendMessage() {

        // SendTalk::sendTextMessage($phoneNumber, $content)
        $textMessage = SendTalk::sendTextMessage('+6281234567890', 'Foo Bar');

        // SendTalk::sendImageMessage($phoneNumber, $imageUrl, $fileName, $caption = null)
        $imageMessage = SendTalk::sendImageMessage('+6281234567890', 'https://example.com/foobar.png', 'foobar.png', 'Foo Bar');

        // SendTalk::sendOTPMessage($phoneNumber, $content)
        $otpMessage = SendTalk::sendOTPMessage('+6281234567890', 'Foo Bar');
    }

}
```

If the request was sent, the method above will return the `id` of the message, otherwise it will throw an exception.
