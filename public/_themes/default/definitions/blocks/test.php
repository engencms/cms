<?php

return [
    'test'  => [
        'type'  => 'string',
        'label' => 'Test',
    ],

    'repeater' => [
        'type'   => 'repeater',
        'label'  => 'Repeater test',
        'fields' => [
            'title' => [
                'type'  => 'string',
                'label' => 'Title',
            ],
        ],
    ],

    'image' => [
        'type'   => 'image',
        'label'  => 'Image test',
    ],

    'file' => [
        'type'   => 'file',
        'label'  => 'File test',
    ],

    'link' => [
        'type'   => 'link',
        'label'  => 'Link test',
    ],

    'checkbox' => [
        'type'    => 'checkbox',
        'label'   => 'Checkbox test',
        'default' => 'second',
        'values'  => [
            'First'  => 'first',
            'Second' => 'second',
            'Third'  => 'third',
        ],
    ],

    'radio' => [
        'type'   => 'radio',
        'label'  => 'Radio test',
    ],

    'select' => [
        'type'   => 'select',
        'label'  => 'Select test',
        'default' => 'second',
        'values'  => [
            'First'  => 'first',
            'Second' => 'second',
            'Third'  => 'third',
        ],
    ],
];
