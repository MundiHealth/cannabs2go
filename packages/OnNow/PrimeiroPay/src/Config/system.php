<?php

return [
//    [
//        'key' => 'sales',
//        'name' => 'Sales',
//        'sort' => 1
//    ],
    [
        'key' => 'sales.installmentsinterest',
        'name' => 'Installments Interest',
        'sort' => 5
    ],
    [
        'key' => 'sales.paymentmethods.primeiropay',
        'name' => 'PrimeiroPay',
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
                'name' => 'entityIDCreditCard',
                'title' => 'Entity ID (Credit Card)',
                'type' => 'text',
                'validation' => 'required'
            ],
            [
                'name' => 'entityIDBankSlip',
                'title' => 'Entity ID (Bank Slip)',
                'type' => 'text',
                'validation' => 'required'
            ],
            [
                'name' => 'token',
                'title' => 'Token',
                'type' => 'text',
                'validation' => 'required'
            ],
            [
                'name' => 'endpoint',
                'title' => 'Endpoint',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Live',
                        'value' => true
                    ],
                    [
                        'title' => 'Test',
                        'value' => false
                    ]
                ],
                'validation' => 'required'
            ]
        ]
    ]
];