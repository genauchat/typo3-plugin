<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'genau.chat Widget',
    'description'      => 'AI-powered chat widget for TYPO3. Answers customer questions 24/7, generates leads automatically. Easy 5-minute setup via backend module. Supports TYPO3 12, 13 LTS, 14.',
    'category'         => 'plugin',
    'author'           => 'Andrii Golik',
    'author_email'     => 'info@genau.chat',
    'author_company' => 'Genau.Chat',
    'state'            => 'stable',
    'version'          => '1.1.1',
    'constraints'      => [
        'depends'   => [
            'typo3' => '12.0.0-14.9.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
