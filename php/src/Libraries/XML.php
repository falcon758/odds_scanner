<?php

namespace OddsScanner\PHP\Libraries;

use SimpleXMLElement;
use Exception;

class XML
{
    /** 
     * @var string
     * */
    private string $xml;

    /**
     * Set xml
     *
     * @param string $xml XML
     * 
     * @return void
     */
    public function setXML(string $xml): void
    {
        $this->xml = $xml;
    }

    /**
     * To object
     * 
     * @return SimpleXMLElement
     * 
     * @throws Exception
     */
    public function toObject(): SimpleXMLElement
    {
        $xml = $this->xml;

        $data = simplexml_load_string($xml);

        if (!$data) {
            throw new Exception('Unable to convert xml to object');
        }

        return $data;
    }
}

?>