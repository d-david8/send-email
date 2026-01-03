<?php
return [
    'default' => 'hello',
    'accounts' => [
        'hello' => [
            'email' => 'hello@domain.tld',
            'password' => 'CHANGE_ME',
            'name' => 'Hello'
        ]
    ,],
    'host' => $env['MAIL_HOST'],
    'port' => $env['MAIL_PORT']
];