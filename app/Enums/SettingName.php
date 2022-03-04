<?php

namespace App\Enums;

/*
 * @method static SettingName APP_NAME()
 * @method static SettingName APP_EMAIL()
 * @method static SettingName APP_MOBILE()
 * @method static SettingName APP_DECLAIMER()
 * @method static SettingName ABOUT_US()
 * @method static SettingName QUOTE()
 */
class SettingName extends Enum
{
    private const APP_NAME   = 'app_name';
    private const APP_EMAIL    = 'app_email';
    private const APP_MOBILE    = 'app_mobile';
    private const APP_DECLAIMER    = 'app_declaimer';
    private const ABOUT_US    = 'about_us';
    private const QUOTE    = 'quote';
}