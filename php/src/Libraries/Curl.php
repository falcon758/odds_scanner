<?php

namespace OddsScanner\PHP\Libraries;

use Exception;

class Curl
{
    /** 
     * @var string
     * */
    private string $url;

    /**
     * Set url
     *
     * @param string $url Url
     * 
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Retrieve content
     * 
     * @return string
     * 
     * @throws Exception
     */
    public function retrieve(): string
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        ); 
    
        $handler = curl_init($this->url);
        curl_setopt_array($handler, $options);
    
        $content = curl_exec($handler);

        curl_close($handler);
    
        return $content;
    }
}

?>