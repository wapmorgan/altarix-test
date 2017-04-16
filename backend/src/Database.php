<?php
namespace wapmorgan\altarix;

use PDO;

class Database extends PDO {
    const DEFAULT_CONFIG = __DIR__.'/../config/database.json';

    static public $checkResultsTable = 'check_results';

    static public function open($config = null) {
        if ($config === null || !file_exists($config))
            $config = self::DEFAULT_CONFIG;
        $config = json_decode(file_get_contents($config), true);

        $dsn = $config['driver'].':'
            .(isset($config['host']) ? 'host='.$config['host'].';' : null)
            .(isset($config['port']) ? 'port='.$config['port'].';' : null)
            .'dbname='.$config['database'].';';
        return new self($dsn, $config['username'], $config['password']);
    }

    public function insertCheckResult(Check $checkResult) {

    }
}
