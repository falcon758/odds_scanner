<?php

namespace OddsScanner\PHP\Libraries;

use Exception;

class CSV
{
    /** 
     * @var array
     * */
    private array $headers;

    /** 
     * @var array
     * */
    private array $rows;

    /**
     * Set headers
     *
     * @param array $headers Headers
     * 
     * @return void
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Set rows
     *
     * @param array $rows Rows
     * 
     * @return void
     */
    public function setRows(array $rows): void
    {
        $this->rows = $rows;
    }

    /**
     * Set row
     *
     * @param array $row Row
     * 
     * @return void
     */
    public function setRow(array $row): void
    {
        $this->rows[] = $row;
    }

    /**
     * Export CSV
     * 
     * @return string
     * 
     * @throws Exception
     */
    public function export(): string
    {
        $headers = $this->headers;
        $rows    = $this->rows;

        if (count($headers) === 0 || count($rows) === 0) {
            throw new Exception('Nothing to export!');
        }

        $export = implode(',', $headers) . "\n";

        foreach ($rows as $row) {
            $export .= implode(',', $row) . "\n";
        }

        return $export;
    }
}

?>