<?php
// @TODO these should be moved to environment/httpconf for production
return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'host' => '127.0.0.1', // $_SERVER['DB_HOST],
            'dbname' => 'name_of_database', // $_SERVER['DB_NAME'],
            'user' => 'mysql_user', // $_SERVER['DB_USER'],
            'pass' => 'super_secret_password' // $_SERVER['DB_PASS'],
        ],
    ],
];

?>
