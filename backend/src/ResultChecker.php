<?php
namespace wapmorgan\altarix;

use Exception;
use SimpleXMLElement;

class ResultChecker {
    static public $ethalonStructure = array('Body' => array(
        'GetTaxiInfosResponse' => array(
            'GetTaxiInfosResult' => array(
                'TaxiInfo' => array(
                    'LicenseNum' => '02651',
                    'LicenseDate' => '08.08.2011 0:00:00',
                    'Name' => 'ООО "НЖТ-ВОСТОК"',
                    'OgrnNum' => '1107746402246',
                    'OgrnDate' => '17.05.2010 0:00:00',
                    'Brand' => 'FORD',
                    'Model' => 'FOCUS',
                    'RegNum' => 'ЕМ33377',
                    'Year' => '2011',
                    'BlankNum' => '002695',
                ),
            ),
        ),
    ));
    protected $result;

    public function __construct($result) {
        $this->result = $result;
    }

    public function checkResult() {
        try {
            $this->checkStructure(simplexml_load_string($this->result), self::$ethalonStructure);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function checkStructure(SimpleXMLElement $xml, array $structure) {
        foreach ($structure as $element => $content) {
            if (is_array($content)) {
                // check for inner element
                if (!isset($xml[$element]))
                    throw new Exception('XML does not have inner element "'.$element.'"');
                $this->checkStructure($xml[$element], $content);
            }
            // check for element value
            else {
                if (!isset($xml[$element]))
                    throw new Exception('XML does not have inner element "'.$element.'"');
                if ((string)$xml[$element] != $content)
                    throw new Exception('XML element "'.$element."' value ('.(string)$xml[$element].') mismatch with ethalon ('.$content.')');
            }
        }
    }
}
