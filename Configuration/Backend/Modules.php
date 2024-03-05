<?php

defined('TYPO3') || die();

use TYPO3\CMS\Core\Information\Typo3Version;
use Z7\Lalalytics\Controller\EventController;

if (version_compare((new Typo3Version())->getVersion(), '12.0.0', '>=')) {
    return [
        'site_lalalytics' => [
            'parent' => 'site',
            'position' => ['after' => '*'],
            'access' => 'admin',
            'iconIdentifier' => 'module-lalalytics',
            'labels' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf',
            'extensionName' => 'Lalalytics',
            'controllerActions' => [
                EventController::class => [
                    'list', 'new', 'create', 'edit', 'update', 'delete' ]
            ],
        ],
    ];
}
return [];
