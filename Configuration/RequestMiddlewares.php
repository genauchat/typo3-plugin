<?php

declare(strict_types=1);

return [
    'frontend' => [
        'genauchat/script-injector' => [
            'target' => \Genauchat\Typo3Plugin\Middleware\ScriptInjector::class,
            'after' => [
                'typo3/cms-frontend/output-compression',
            ],
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
