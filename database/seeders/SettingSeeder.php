<?php

namespace Database\Seeders;

use App\Enums\SettingName;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(
            [
                'name' => SettingName::APP_NAME(),
            ],
            [
                'name' =>  SettingName::APP_NAME(),
                'value' => "Soft Resource",
            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::APP_EMAIL(),
            ],
            [
                'name' => SettingName::APP_EMAIL(),
                'value' => "admin@admin.com",
            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::APP_MOBILE(),
            ],
            [
                'name' => SettingName::APP_MOBILE(),
                'value' => "01780134797",
            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::APP_DECLAIMER(),
            ],
            [
                'name' => SettingName::APP_DECLAIMER(),
                'value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::ABOUT_US(),
            ],
            [
                'name' => SettingName::ABOUT_US(),
                'value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",

            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::QUOTE(),
            ],
            [
                'name' => SettingName::QUOTE(),
                'value' => "The purpose of our lives is to be happy",

            ]
        );

        Setting::updateOrCreate(
            [
                'name' => SettingName::ACKNOWLEDGE(),
            ],
            [
                'name' => SettingName::ACKNOWLEDGE(),
                'value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
            ]
        );

    }
}
