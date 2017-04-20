<?php
namespace wapmorgan\altarix;

use SoapClient;

class Request {
    public $wsdl_url = 'http://speller.yandex.net/services/spellservice?WSDL';
    public $request_method = 'checkText';
    public $request_data = array('text' => 'На лисной опушки распускаюца колоколчики, незабутки, шыповник');

    protected $request_time;
    protected $response_time;
    protected $response_headers;
    protected $response_body;

    public function performRequest() {
        $soap = new SoapClient($this->wsdl_url, array('trace' => true));
        $this->request_time = microtime(true);
        $result = call_user_func(array($soap, $this->request_method), $this->request_data);
        $this->response_time = microtime(true);
        $this->response_body = $soap->__getLastResponse();
        $this->response_headers = $soap->__getLastResponseHeaders();
    }

    public function headersWriter($ch, $header) {
        if (trim($header) != '')
            $this->response_headers[] = trim($header);
        return strlen($header);
    }

    public function getRequestTime() {
        return $this->request_time;
    }

    public function getResponseTime() {
        return $this->response_time;
    }

    public function getResponseHeaders() {
        return $this->response_headers;
    }

    public function getResponseBody() {
        return $this->response_body;
    }
}
