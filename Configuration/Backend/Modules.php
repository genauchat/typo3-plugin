<?php

declare(strict_types=1);

use Genauchat\Typo3Plugin\Controller\SettingsController;

return [
    'genauchat_settings' => [
        'parent' => 'tools',
        'path' => '/module/tools/genauchat',
        'access' => 'admin',
        'extensionName' => 'Genauchat',
        'iconIdentifier' => 'genauchat-module',
        'labels' => 'LLL:EXT:genauchat/Resources/Private/Language/locallang_mod.xlf',
        'controllerActions' => [
            SettingsController::class => ['index', 'save'],
        ],
    ],
];
