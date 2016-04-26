<?php

return [
    'driver'            => env('MAIL_DRIVER', 'sendgrid'),
    'host'              => env('MAIL_HOST', 'smtp.sendgrid.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => env('MAIL_FROM', 'help@balin.id'), 
                            'name'              => 'Balin.ID'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME',''),
    'password'          => env('MAIL_PASSWORD',''),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => env('MAIL_PRETEND', 'false'),
];
