<?php

return [
    'body'  => [
        'type'  => 'textarea',
        'label' => 'Body',
    ],

    'blurbs' => [
        'type'   => 'repeater',
        'label'  => 'Blurbs',
        'fields' => [
            'title' => [
                'type'  => 'string',
                'label' => 'Title',
            ],
            'content' => [
                'type'  => 'textarea',
                'label' => 'Content',
                'settings' => [
                    'attributes' => 'style="min-height: 150px"',
                ],
            ],
        ],
    ],
];
