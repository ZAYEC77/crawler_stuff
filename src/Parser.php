<?php
/**
 * Base class for parser instance
 *
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */

namespace Crawler;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class Parser
{
    protected static $instance;

    protected $client;

    protected function __construct()
    {
        $this->client = new Client();
        $guzzleClient = new GuzzleClient([
            'timeout' => 60,
        ]);
        $this->client->setClient($guzzleClient);
    }

    /**
     * @return static
     */
    public static function get()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function log($message)
    {
        echo 'PARSER: ' . $message . PHP_EOL;
    }
}