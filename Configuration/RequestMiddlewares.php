<?php

return [
    'frontend' => [
        'z7/lalalytics-proxy' => [
            'target' => \Z7\Lalalytics\Middleware\ProxyForward::class,
            'after' => [
                'typo3/cms-frontend/site',
            ],
            'before' => [
                'typo3/cms-frontend/maintenance-mode',
            ],
            'disabled' => false
        ],
    ]
];
