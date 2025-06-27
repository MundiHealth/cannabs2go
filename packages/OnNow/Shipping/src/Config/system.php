<?php

return [
    [
        'key' => 'sales.carriers.matrixrate',
        'name' => 'Matrix rate',
        'sort' => 3,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inactive',
                        'value' => false
                    ]
                ],
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'table',
                'title' => 'Tabela',
                'type' => 'file',
            ]
        ]
    ],
    [
        'key' => 'sales.orderSettings.freeShipping',
        'name' => 'Free Shipping',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'value',
                'title' => 'Valor',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inactive',
                        'value' => false
                    ]
                ],
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false
            ]
        ]
    ]
];