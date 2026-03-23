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
        'labels' => [
            'title' => 'genau.chat',
        ],
        'controllerActions' => [
            SettingsController::class => ['index', 'save'],
        ],
    ],
];
