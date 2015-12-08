<?php

return [
    'driver'            => env('MAIL_DRIVER', 'mandrill'),
    'host'              => env('MAIL_HOST', 'smtp.mandrillapp.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => 'gopego550@gmail.com', 
                            'name'              => 'Balin'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME',''),
    'password'          => env('MAIL_PASSWORD',''),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => false,
];
