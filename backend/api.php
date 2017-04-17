<?php
require __DIR__.'/../vendor/autoload.php';
use wapmorgan\altarix\Database;
use wapmorgan\altarix\HttpOutput;

$http = new HttpOutput();

if (!isset($_GET['mode']))
    $http->error(400, 'No mode argument');

function dateStringToTimestamp($date) {
    if (!preg_match('~^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$~', $date, $match))
        return false;
    return mktime(0, 0, 0, (int)$match[2], (int)$match[3], (int)$match[1]);
}

switch ($_GET['mode']) {
    case 'list':
        if (!isset($_GET['start_date']) || !isset($_GET['end_date']))
            $http->error(400, 'No start_date or end_date arguments');

        $start_date = dateStringToTimestamp($_GET['start_date']);
        $end_date = dateStringToTimestamp($_GET['end_date']);
        if (!$start_date || !$end_date || ($start_date > $end_date))
            $http->error(400, 'Invalid start_date or end_date');
        // add almost 1 day
        $end_date += 86399;

        $database = Database::open();
        $checks = $database->getAllChecksInRange($start_date, $end_date);

        $http->outputJson($checks);
        break;

    case 'result':
        if (!isset($_GET['id']) || ($id = intval($_GET['id'])) == 0)
            $http->error(400, 'Not present or invalid id argument');

        $database = Database::open();
        $result = $database->getCheck($id);
        if ($result === false)
            $http->error(404, 'Checks does not exist');
        else
            $http->outputJson($result);
        break;

    case 'last_result':
        $database = Database::open();
        $result = $database->getLastCheck();
        if ($result === false)
            $http->error(404, 'Checks does not exist');
        else
            $http->outputJson($result);
        break;
}
