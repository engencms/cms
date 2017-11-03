<?php

return [
    'hero-image'  => [
        'type'  => 'image',
        'label' => 'Hero image',
    ],

    'body'  => [
        'type'  => 'markdown',
        'label' => 'Body',
    ],

    'blurbs' => [
        'type'   => 'repeater',
        'label'  => 'Blurbs',
        'fields' => [
            'title'   => [
                'type'  => 'string',
                'label' => 'Title',
            ],
            'icon'    => [
                'type'  => 'string',
                'label' => 'Icon',
            ],
            'content' => [
                'type'  => 'markdown',
                'label' => 'Content',
            ],
        ],
    ],
];
