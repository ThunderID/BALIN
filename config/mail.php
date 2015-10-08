<?php

return [
    'driver'            => env('MAIL_DRIVER', 'smtp'),
    'host'              => env('MAIL_HOST', 'smtp.gmail.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => 'balin.co.id@gmail.com', 
                            'name'              => 'Balin'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME','balin.co.id@gmail.com'),
    'password'          => env('MAIL_PASSWORD','balin.id'),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => false,
];
