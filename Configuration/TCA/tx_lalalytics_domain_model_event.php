<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:tx_lalalytics_domain_model_event',
        'label' => 'name',
        'label_alt_force' => true,
        'label_alt' => 'type, selector',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'site,type,selector,name,description,tags,attribute',
        'iconfile' => 'EXT:lalalytics/Resources/Public/Icons/gif'
    ],
    'types' => [
        '1' => ['showitem' => 'site, type, selector, name, description, tags, attribute, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_lalalytics_domain_model_event',
                'foreign_table_where' => 'AND {#tx_lalalytics_domain_model_event}.{#pid}=###CURRENT_PID### AND {#tx_lalalytics_domain_model_event}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'site' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:site',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],

        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'click', 'value' => 'click'],
                    ['label' => 'submit', 'value' => 'submit'],
                    ['label' => 'hashchange', 'value' => 'hashchange'],
                ],
                'eval' => 'trim',
                'required' => true,
                'default' => ''
            ],
        ],
        'selector' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:selector',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'default' => ''
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:tags',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'attribute' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:attribute',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],

    ],
];
