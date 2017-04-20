<?php
namespace wapmorgan\altarix;

class Crawler {
    static public $bodyMaxSize = 15360;
    static public $headersMaxSize = 3072;

    static public function performCheck() {
        $request = new Request();
        $request->performRequest();
        $result_checker = new ResultChecker($request->getResponseBody());

        $check = new Check();
        $check->request_time = $request->getRequestTime();
        $check->response_time = $request->getResponseTime();
        $check->delay_time = $request->getResponseTime() - $request->getRequestTime();
        $check->response_raw = $request->getResponseBody();
        $check->headers_raw = $request->getResponseHeaders();
        $check->status = $result_checker->checkResult() ? 'ok' : 'error';

        if (strlen($check->response_raw) > self::$bodyMaxSize)
            $check->response_raw = substr($check->response_raw, 0, self::$bodyMaxSize);
        if (strlen($check->headers_raw) > self::$headersMaxSize)
            $check->headers_raw = substr($check->headers_raw, 0, self::$headersMaxSize);

        return $check;
    }
}