<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'genau.chat Widget',
    'description'      => 'Adds the genau.chat AI chat widget to your TYPO3 website. Easy setup via backend module.',
    'category'         => 'plugin',
    'author'           => 'Andrii Golik',
    'author_email'     => 'info@genau.chat',
    'author_company' => 'Genau.Chat',
    'state'            => 'stable',
    'version'          => '1.1.0',
    'constraints'      => [
        'depends'   => [
            'typo3' => '12.0.0-14.9.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
