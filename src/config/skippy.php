<?php

return [

    /*
    |--------------------------------------------------
    | Connection settings
    |--------------------------------------------------
    |
    | The settings of your default AMQP server connection. This connection
    | will be used as default for all operations performed by Skippy.
    */
    'connection' => [
        'host'     => 'localhost',
        'port'     => 5672,
        'username' => 'guest',
        'password' => 'guest',
    ],

    /*
    |--------------------------------------------------
    | Exchange settings
    |--------------------------------------------------
    |
    | The name and type of your default AMQP exchange. This exchange will be
    | used for queues or as default for exchange messages if not provided.
    */
    'exchange'   => [
        'name' => 'amq.fanout',
        'type' => 'fanout',
    ],

    /*
    |--------------------------------------------------
    | Message settings
    |--------------------------------------------------
    |
    | The settings which should be applied to all your messages.
    */
    'message'    => [
        'content_type' => 'application/json',
    ],
];
