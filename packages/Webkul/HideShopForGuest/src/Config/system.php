<?php

return [
    [
        'key' => 'hideshopforguest',
        'name' => 'hideshopforguest::app.name',
        'sort' => 5
    ], [
        'key' => 'hideshopforguest.settings',
        'name' => 'hideshopforguest::app.settings',
        'sort' => 1,
    ], [
        'key' => 'hideshopforguest.settings.settings',
        'name' => 'hideshopforguest::app.settings',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'hide-shop-before-login',
                'title' => 'hideshopforguest::app.hide-shop-before-login',
                'type' => 'boolean',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'hide-shop-before-login.notification',
                'title' => 'hideshopforguest::app.notification',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'hide-shop-before-login.group',
                'title' => 'hideshopforguest::app.group',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ]
        ]
    ]
];