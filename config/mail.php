<?php

return [
    'driver'            => env('MAIL_DRIVER', 'smtp'),
    'host'              => env('MAIL_HOST', 'smtp.gmail.com'),
    'port'              => env('MAIL_PORT', 587),
    'from'              => [
                            'address'           => 'gopego550@gmail.com', 
                            'name'              => 'Balin'
                            ],
    'encryption'        => env('MAIL_ENCRYPTION', 'tls'),
    'username'          => env('MAIL_USERNAME','gopego550@gmail.com'),
    'password'          => env('MAIL_PASSWORD','gopego.com'),
    'sendmail'          => '/usr/sbin/sendmail -bs',
    'pretend'           => false,
];
