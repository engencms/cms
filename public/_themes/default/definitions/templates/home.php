<?php

return [
    'body'  => [
        'type'  => 'markdown',
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
                'type'  => 'markdown',
                'label' => 'Content',
                'settings' => [
                    'attributes' => 'style="height: 150px"',
                ],
            ],
        ],
    ],
];
