<?php

namespace OddsScanner\PHP;

use OddsScanner\PHP\Libraries\Curl AS Caller;
use OddsScanner\PHP\Libraries\XML AS XMLParser;
use OddsScanner\PHP\Libraries\CSV AS CreateCSV;
use OddsScanner\PHP\Libraries\File AS FileHandler;
use SimpleXMLElement;
use Exception;

class Wrapper
{
    /**
     * Call url
     * 
     * @return string
     * 
     * @throws Exception
     */
    private function callUrl(): string
    {
        $curl = new Caller();

        $curl->setUrl('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml?5105e8233f9433cf70ac379d6ccc5775');

        return $curl->retrieve();
    }

    /**
     * Parse XML
     * 
     * @param string Content to parse
     * 
     * @return SimpleXMLElement
     * 
     * @throws Exception
     */
    private function parseXML(string $content): SimpleXMLElement
    {
        $xml = new XMLParser();

        $xml->setXML($content);

        return $xml->toObject();
    }

    /**
     * To CSV
     * 
     * @param SimpleXMLElement Parsed XML
     * 
     * @return string
     * 
     * @throws Exception
     */
    private function toCSV(SimpleXMLElement $parsedXML): string
    {
        $csv = new CreateCSV();

        $csv->setHeaders(
            [
                'Currency Code',
                'Rate'
            ]
        );

        if (!isset($parsedXML->{'Cube'}->{'Cube'}->{'Cube'})) {
            throw new Exception('XML is not valid!');
        }

        $allData = $parsedXML->{'Cube'}->{'Cube'}->{'Cube'};

        foreach ($allData as $data) {
            $csv->setRow([
                $data['currency'] ?? '',
                $data['rate'] ?? '',
            ]);
        }

        return $csv->export();
    }

    /**
     * To CSV
     * 
     * @param string Content to save
     * 
     * @return bool
     * 
     * @throws Exception
     */
    private function saveFile(string $export): bool
    {
        $file = new FileHandler();

        $file->setFilePath('./');
        $file->setFileName('usd_currency_rates_' . date('Y_m_d'));
        $file->setContent($export);
        $file->setFileExtension('csv');

        return $file->save();
    }

    /**
     * Start processes
     * 
     * @param string Content to save
     * 
     * @return bool
     * 
     * @throws Exception
     */
    public function start(): bool
    {
        $content = $this->callUrl();
        $xml     = $this->parseXML($content);
        $csv     = $this->toCSV($xml);

        return $this->saveFile($csv);
    }
}

?>