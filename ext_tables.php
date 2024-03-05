<?php

defined('TYPO3') || die();

use TYPO3\CMS\Core\Information\Typo3Version;

(static function () {
    if (version_compare((new Typo3Version())->getVersion(), '12.0.0', '<=')) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'Lalalytics',
            'site',
            'backend',
            '',
            [
                \Z7\Lalalytics\Controller\EventController::class => 'list, new, create, edit, update, delete',
            ],
            [
                'access' => 'user,group',
                'icon'   => 'EXT:lalalytics/Resources/Public/Icons/user_mod_lala.svg',
                'labels' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf',
            ]
        );
    }
})();
