<?php

return [
    'driver'            => env('MAIL_DRIVER', 'mandrill'),
    'host'              => env('MAIL_HOST', 'smtp.mandrillapp.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => env('MAIL_USERNAME', 587), 
                            'name'              => 'Balin.id'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME',''),
    'password'          => env('MAIL_PASSWORD',''),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => false,
];
