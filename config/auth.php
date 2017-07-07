<?php

return [
	'secret' => 'c8cb6ae1fb193e1e9d3d2d6553479755bbe59e34e2b965629ee4346e4c4902646c93ccd6cd7fd6d2392f300d251632e64bf1a1c260adf1b7219e8caa6dc7d27e',
    'lifetime' => 1440,
    'algo' => 'HS256',
    'tokenName' => 'X-Token',
    'exceptUrls' => [
        '/',
        'auth',
        'auth/login',
        'auth/logout',
        'auth/register'
    ]
];
