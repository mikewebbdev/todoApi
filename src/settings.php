<?php
// @TODO these should be moved to environment/httpconf for production
return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'host' => '127.0.0.1', // $_SERVER['DB_HOST],
            'dbname' => 'orlo', // $_SERVER['DB_NAME'],
            'user' => 'phpmyadmin', // $_SERVER['DB_USER'],
            'pass' => 'qwer1234' // $_SERVER['DB_PASS'],
        ],
    ],
];

?>