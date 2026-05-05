<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mailchimp',
    'description' => 'Simple Mailchimp newsletter subscription form',
    'category' => 'plugin',
    'author' => 'Marek Skopal',
    'author_email' => 'skopal.marek@gmail.com',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
