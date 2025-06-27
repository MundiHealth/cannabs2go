<?php

return [
    [
        'key' => 'sales.paymentmethods.ebanx',
        'name' => 'Ebanx',
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
                'name' => 'integration_key',
                'title' => 'Token',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true
            ],
            [
                'name' => 'mode',
                'title' => 'Mode',
                'type' => 'select',
                'channel_based' => true,
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