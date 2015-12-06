<?php

return [
    'driver'            => env('MAIL_DRIVER', 'mandrill'),
    'host'              => env('MAIL_HOST', 'smtp.mandrillapp.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => 'help@balin.id', 
                            'name'              => 'Balin'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME',''),
    'password'          => env('MAIL_PASSWORD',''),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => false,
];
