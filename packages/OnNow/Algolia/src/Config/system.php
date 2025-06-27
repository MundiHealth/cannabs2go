<?php

return [

    [
        'key' => 'catalog.search',
        'name' => 'Search',
        'sort' => 3,
    ],
    [
        'key' => 'catalog.search.algolia',
        'name' => 'Algolia',
        'sort' => 0,
        'fields' => [
            [
                'name' => 'active',
                'title' => 'Enable',
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
                'name' => 'index',
                'title' => 'Index Prefix',
                'type' => 'text',
                'validation' => 'required'
            ]
        ]
    ],

];