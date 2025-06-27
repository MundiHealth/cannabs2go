<?php

return [

    [
        'key' => 'sales.installmentsinterest',
        'name' => 'Installments Interest',
        'sort' => 5
    ],
    [
        'key' => 'sales.paymentmethods.prevenda',
        'name' => 'Pre Venda',
        'sort' => 5,
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
            ]



        ]
    ]
];