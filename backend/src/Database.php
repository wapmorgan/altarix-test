<?php
namespace wapmorgan\altarix;

use Exception;
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
        $q = $this->prepare('INSERT INTO '.self::$checkResultsTable.' (request_time, response_time, delay_time, status, response_raw, headers_raw) VALUES (:request_time, :response_time, :delay_time, :status, :response_raw, :headers_raw)');

        $q->bindValue(':request_time', date('c', $checkResult->request_time));
        $q->bindValue(':response_time', date('c', $checkResult->response_time));
        $q->bindParam(':delay_time', $checkResult->delay_time);
        $q->bindValue(':status', $checkResult->status == 'ok' ? '1' : '0');
        $q->bindParam(':response_raw', $checkResult->response_raw);
        $q->bindParam(':headers_raw', $checkResult->headers_raw);


        if (!$q->execute()) {
            throw new Exception(implode(', ', $q->errorInfo()), $q->errorCode());
        }
        return true;
    }

    public function getAllChecksInRange($startTimestamp, $endTimestamp) {
        $q = $this->prepare('SELECT id, request_time, response_time, delay_time, status, response_raw, headers_raw FROM '.self::$checkResultsTable.' WHERE request_time BETWEEN :startTimestamp AND :endTimestamp');
        $q->bindValue(':startTimestamp', date('c', $startTimestamp));
        $q->bindValue(':endTimestamp', date('c', $endTimestamp));
        $q->execute();
        $checks = array();
        while (($data = $q->fetch(PDO::FETCH_ASSOC)) !== false) {
            $checks[] = $this->createCheckObject($data);
        }
        $q->closeCursor();
        return $checks;
    }

    public function getCheck($id) {
        $q = $this->prepare('SELECT id, request_time, response_time, delay_time, status, response_raw, headers_raw FROM '.self::$checkResultsTable.' WHERE id = :id');
        $q->bindParam(':id', $id);
        $q->execute();
        $check = $this->createCheckObject($q->fetch(PDO::FETCH_ASSOC));
        $q->closeCursor();
        return $check;
    }

    public function getLastCheck() {
        $q = $this->query('SELECT id, request_time, response_time, delay_time, status, response_raw, headers_raw FROM '.self::$checkResultsTable.' ORDER BY request_time DESC LIMIT 1');
        return $this->createCheckObject($q->fetch(PDO::FETCH_ASSOC));
    }

    protected function createCheckObject(array $data) {
        $check = new Check();
        $check->id = $data['id'];
        $check->request_time = strtotime($data['request_time']);
        $check->response_time = strtotime($data['response_time']);
        $check->delay_time = $data['delay_time'];
        $check->status = $data['status'] ? 'ok' : 'error';
        $check->response_raw = $data['response_raw'];
        $check->headers_raw = $data['headers_raw'];
        return $check;
    }
}
