<?php

namespace App\Logging;

use Monolog\Processor\IntrospectionProcessor;
use Monolog\Logger;

class CustomizeFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            // Questo processore aggiunge file, line, class e function automaticamente
            $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']));
        }
    }
}