<?php
namespace wapmorgan\altarix;

class Crawler {
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

        return $check;
    }
}