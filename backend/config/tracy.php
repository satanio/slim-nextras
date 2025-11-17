<?php declare(strict_types=1);

use Tracy\Debugger;


return [
    'enabled' => ($_ENV['APP_ENV'] ?? 'development') === 'development',
    
    'development' => ($_ENV['APP_DEBUG'] ?? 'true') === 'true',
    
    'logDirectory' => __DIR__ . '/../var/log',
    
    'showBar' => true,
    
];

