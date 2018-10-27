<?php

return [
    'config' => [
        'app_id' => env('FACEBOOK_APP_ID', 347197218808623),
        'app_secret' => env('FACEBOOK_APP_SECRET'),
        'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION', 'v3.2'),
        'default_access_token' => env('FACEBOOK_LONG_LIFE_TOKEN'),
    ],
];
