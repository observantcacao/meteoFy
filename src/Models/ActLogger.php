<?php

namespace Models;

use ErrorException;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ActLogger
{
    /**
     * /
     * @param string $message, le message qui sera logué
     * @param string $type, "debug","info","notice","warning","error","critical","alert","emergency"
     * @throws \ErrorException
     * @return void
     */
    public static function log(string $message, string $type = "info")
    {
        $level = ["debug", "info", "notice", "warning", "error", "critical", "alert", "emergency"];
        if (in_array($type, $level) === false) {
            throw new ErrorException("mauvais type de log : " . $type);
        } else {

            $json = file_get_contents('../log/logMeteoFy.log');
            //var_dump($json); //ligne afin de voir les information récup
            if ($json === false) {
                die('erreur lors de la lecture du dossier log');
            }

            $json_data = json_decode($json, true);

            $lines = explode("\n", trim($json));

            // Decoder chaque ligne en tant qu'objet json
            $logs = [];
            foreach ($lines as $line) {
                $decoded = json_decode($line, true);
                if ($decoded !== null) {
                    $logs[] = $decoded; // Ajouter chaque ligne decodee dans $logs
                }
            }

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

    public static function bootstrapClass($type)
    {
        return match (strtolower($type)) {
            'debug' => 'secondary',
            'info' => 'primary',
            'notice' => 'success',
            'warning' => 'warning',
            'error', 'critical', 'alert', 'emergency' => 'danger',
            default => 'secondary',
        };
    }
}