<?php

$GLOBALS['SiteConfiguration']['site_language']['columns']['lalalytics_enabled'] = [
    'label' => 'Enabled?',
    'description' => 'Enable to add lalalytics tracking to this site.',
    'onChange' => 'reload',
    'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'default' => 0,
        'items' => [
            [
                0 => '',
                1 => ''
            ]
        ]
    ],
];

$GLOBALS['SiteConfiguration']['site_language']['columns']['lalalytics_code'] = [
    'label' => 'Analytics Code',
    'description' => 'Log in to your lalalytics account, select a website or create one. Then go to the site settings. Take the code and paste it here.',
    'config' => [
        'type' => 'input',
        'eval' => 'required,trim',
    ],
    'displayCond' => 'FIELD:lalalytics_enabled:=:1'
];

$GLOBALS['SiteConfiguration']['site_language']['columns']['lalalytics_proxy'] = [
    'label' => 'Use proxy?',
    'description' => 'Activate this option if you want to route tracking requests via your server. This is recommended with regard to data protection. ATTENTION: You must also activate this in the settings of your website on lalalytics.com.',
    'onChange' => 'reload',
    'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'default' => 0,
        'items' => [
            [
                0 => '',
                1 => ''
            ]
        ]
    ],
    'displayCond' => 'FIELD:lalalytics_enabled:=:1'
];

$GLOBALS['SiteConfiguration']['site_language']['columns']['lalalytics_filterip'] = [
    'label' => 'Filter IPs?',
    'description' => 'Activate this option if you want to filter IPs. This is recommended with regard to data protection, especially if you want to avoid cookie consent banners.',
    'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'default' => 0,
        'items' => [
            [
                0 => '',
                1 => ''
            ]
        ]
    ],
    'displayCond' => 'FIELD:lalalytics_proxy:=:1'
];

$GLOBALS['SiteConfiguration']['site_language']['types']['1']['showitem'] .= ',--div--;lalalytics, lalalytics_enabled, lalalytics_code, lalalytics_proxy, lalalytics_filterip';
