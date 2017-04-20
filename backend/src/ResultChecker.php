<?php
namespace wapmorgan\altarix;

use Exception;
use SimpleXMLElement;

class ResultChecker {
    static public $ethalonReplacements = array(
        'лисной' => 'лесной',
        'распускаюца' => 'распускаются',
        'колоколчики' => 'колокольчики',
        'незабутки' => 'незабудки',
        'шыповник' => 'шиповник',
    );
    protected $result;

    public function __construct($result) {
        $this->result = $result;
    }

    public function checkResult() {
        try {
            $ethalon = self::$ethalonReplacements;
            $xml = new SimpleXMLElement($this->result, null, false, 'soap');
            $xml->registerXPathNamespace('s', 'http://schemas.xmlsoap.org/soap/envelope/');
            $body = $xml->xpath('//s:Envelope/s:Body');
            foreach ($body[0]->CheckTextResponse->SpellResult->error as $error) {
                if ($error['code'] != 1)
                    throw new Exception('Error code is not 1');
                if (!isset($error->word) || !isset($error->s))
                    throw new Exception('Unexisting "s" or "word"');
                $word = (string)$error->word;
                if (!isset($ethalon[$word]))
                    throw new Exception('Unknown word "'.$word.'"');
                $s = (string)$error->s;
                if ($ethalon[$word] != $s)
                    throw new Exception('Unknown replacement "'.$s.'"');
                unset($ethalon[$word]);
            }
            if (!empty($ethalon))
                throw new Exception('Results contains too few replacements, '.count($ethalon).' left');
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }

    protected function xml2array($xmlObject, $out = array()) {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node) || is_array($node)) ? xml2array ($node) : $node;
        return $out;
    }
}
