<?php

namespace Dexalt142\SendTalk\Facades;

use Dexalt142\SendTalk\SendTalk as SendTalkClass;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string sendTextMessage($phoneNumber, $content)
 * @method static string sendImageMessage($phoneNumber, $imageUrl, $fileName, $caption = null)
 * @method static string sendOTPMessage($phoneNumber, $content)
 * @method static object getMessageStatus($id)
 * 
 * @see \Dexalt142\SendTalk\SendTalk
 */
class SendTalk extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return SendTalkClass::class;
    }

}