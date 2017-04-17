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
        $q = $this->prepare('INSERT INTO '.self::$checkResultsTable.' (request_time, response_time, delay_time, status, response_raw, headers_raw) VALUES (:request_time, :response_time, :delay_time, :status, :response_raw, :headers_raw)');

        $q->bindValue(':request_time', date('c', $checkResult->request_time));
        $q->bindValue(':response_time', date('c', $checkResult->response_time));
        $q->bindParam(':delay_time', $checkResult->delay_time);
        $q->bindParam(':status', $checkResult->status == 'ok' ? true : false);
        $q->bindParam(':response_raw', $checkResult->response_raw);
        $q->bindParam(':headers_raw', $checkResult->headers_raw);

        return $q->execute();
    }

    public function getAllChecksInRange($startTimestamp, $endTimestamp) {
        $q = $this->prepare('SELECT `id`, `request_time`, `response_time`, `delay_time`, `status`, `response_raw`, `headers_raw` FROM '.self::$checkResultsTable.' WHERE `request_time` BETWEEN :startTimestamp and :endTimestamp');
        var_dump(date('c', $startTimestamp), date('c', $endTimestamp));
        $q->bindValue(':startTimestamp', date('c', $startTimestamp));
        $q->bindValue(':endTimestamp', date('c', $endTimestamp));
        $q->execute();
        var_dump($q->fetchAll());
        $checks = array();
        while (($data = $q->fetch(PDO::FETCH_ASSOC)) !== false) {
            $check = new Check();
            $check->id = $data['id'];
            $check->request_time = $data['request_time'];
            $check->response_time = $data['response_time'];
            $check->delay_time = $data['delay_time'];
            $check->status = $data['status'];
            $check->response_raw = $data['response_raw'];
            $check->headers_raw = $data['headers_raw'];
            $checks[] = $check;
        }
        $q->closeCursor();
        return $checks;
    }

    public function getCheck($id) {
        $q = $this->prepare('SELECT `id`, `request_time`, `response_time`, `delay_time`, `status`, `response_raw`, `headers_raw` FROM '.self::$checkResultsTable.' WHERE `id` = :id');
        $q->bindParam(':id', $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $check = new Check();
        $check->id = $data['id'];
        $check->request_time = $data['request_time'];
        $check->response_time = $data['response_time'];
        $check->delay_time = $data['delay_time'];
        $check->status = $data['status'];
        $check->response_raw = $data['response_raw'];
        $check->headers_raw = $data['headers_raw'];
        $q->closeCursor();
        return $check;
    }
}
