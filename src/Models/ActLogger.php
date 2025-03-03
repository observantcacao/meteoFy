<?php

namespace Models;

use ErrorException;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ActLogger
{
    public static function log(string $message, string $type = "info")
    {
        $level = ["debug", "info", "notice", "warning", "error", "critical", "alert", "emergency"];
        if (in_array($type,$level ) === false) {
            throw new ErrorException("mauvais type de log : " . $type);
        } else {

            $logger = new Logger("logMeteoFy");
            $stream_handler = new StreamHandler(__DIR__ . "/../log/logMeteoFy.log");
            $formatter = new JsonFormatter();
            $stream_handler->setFormatter($formatter);
            $logger->pushHandler($stream_handler);

            switch ($type) {
                case 'debug':
                    $logger->debug($message);
                    break;
                case 'info':
                    $logger->info($message);
                    break;
                case 'notice':
                    $logger->notice($message);
                    break;
                case 'warning':
                    $logger->warning($message);
                    break;
                case 'error':
                    $logger->error($message);
                    break;
                case 'critical':
                    $logger->critical($message);
                    break;
                case 'alert':
                    $logger->alert($message);
                    break;
                case 'emergency':
                    $logger->emergency($message);
                    break;
                default:
                    $logger->info($message);
                    break;
            }
        }
    }
}