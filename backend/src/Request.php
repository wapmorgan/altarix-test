<?php
namespace wapmorgan\altarix;

class Request {
    public $url = 'http://82.138.16.126:8888/TaxiPublic/Service.svc?wsdl';
    public $request_data = '<taxi:RegNum>ем33377</taxi:RegNum>';

    protected $request_time;
    protected $response_time;
    protected $response_headers;
    protected $response_body;

    public function performRequest() {
        $c = curl_init($this->url);
        curl_setopt($c, CURLOPT_HEADERFUNCTION, array($this, 'headersWriter'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $this->request_time = microtime(true);
        $this->response_body = curl_exec($c);
        $this->response_time = microtime(true);
        curl_close($c);
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
