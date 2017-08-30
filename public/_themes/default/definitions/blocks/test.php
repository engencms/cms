<?php

return [
    'test'  => [
        'type'  => 'string',
        'label' => 'Test',
    ],

    /*
    'rep' => [
        'type'   => 'repeater',
        'label'  => 'Repeater',
        'fields' => [
            'title' => [
                'type'  => 'string',
                'label' => 'Repeater Title',
            ],
        ],
    ],
    */

    'nested' => [
        'type'   => 'repeater',
        'label'  => 'Nested repeater',
        'fields' => [
            'blurbs2' => [
                'type'   => 'repeater',
                'label'  => 'Sub repeater',
                'fields' => [
                    'title' => [
                        'type'  => 'string',
                        'label' => 'Title',
                    ],
                ],
            ],
        ],
    ],
];
