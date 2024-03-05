<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 lalalytics',
    'description' => 'lalalytics.com is a simple and fun to use Google Analytics alternative. This plugin helps you with the integration in TYPO3.',
    'category' => 'plugin',
    'author' => 'zimmer7 GmbH',
    'author_email' => 'info@lalalytics.com',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.99.99',
            'typo3' => '11.5.26-12.5.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
