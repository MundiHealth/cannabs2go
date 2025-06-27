<?php

return [
    [
        'key' => 'sales.paymentmethods.cambioreal',
        'name' => 'CambioReal',
        'sort' => 4,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'Title',
                'type' => 'text',
                'validation' => 'required'
            ],
            [
                'name' => 'active',
                'title' => 'Enable for checkout',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'True',
                        'value' => true,
                    ],
                    [
                        'title' => 'False',
                        'value' => false,
                    ]
                ],
                'validation' => 'required'
            ],
            [
                'name' => 'app_id',
                'title' => 'App ID',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false
            ],
            [
                'name' => 'app_secret',
                'title' => 'App Secret',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false
            ],
            [
                'name' => 'mode',
                'title' => 'Mode',
                'type' => 'select',
                'channel_based' => false,
                'options' => [
                    [
                        'title' => 'Teste',
                        'value' => true
                    ],
                    [
                        'title' => 'Produção',
                        'value' => false
                    ]
                ],
                'validation' => 'required'
            ]
        ]
    ]
];