<?php

namespace OddsScanner\PHP\Libraries;

use Exception;

class File
{
    /** 
     * @var string
     * */
    private string $filePath;

    /** 
     * @var string
     * */
    private string $fileName;

    /** 
     * @var string
     * */
    private string $fileContent;

    /** 
     * @var string
     * */
    private string $fileExtension;

    /**
     * Set file path
     *
     * @param string $filePath File path
     * 
     * @return void
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * Set file name
     *
     * @param string $fileName File name
     * 
     * @return void
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * Set file content
     *
     * @param string $fileContent File content
     * 
     * @return void
     */
    public function setContent(string $fileContent): void
    {
        $this->fileContent = $fileContent;
    }

    /**
     * Set file extension
     *
     * @param string $fileExtension File extension
     * 
     * @return void
     */
    public function setFileExtension(string $fileExtension): void
    {
        $this->fileExtension = $fileExtension;
    }

    /**
     * Save file
     * 
     * @return bool
     * 
     * @throws Exception
     */
    public function save(): bool
    {
        $filePath      = $this->filePath;
        $fileName      = $this->fileName;
        $fileContent   = $this->fileContent ?? '';
        $fileExtension = $this->fileExtension;

        if (!empty($fileExtension)) {
            $fileExtension = '.' . $fileExtension;
        }

        if (!file_exists($filePath)) {
            throw new Exception('File doesn\'t exists!');
        } else if (empty($filePath)) {
            throw new Exception('File path is empty!');
        }

        $fullPath = $filePath . $fileName . $fileExtension;

        $fileHandler = fopen($fullPath, 'w');

        if (!$fileHandler) {
            throw new Exception('Unable to create file!');
        }

        fwrite($fileHandler, $fileContent);

        return fclose($fileHandler);
    }
}

?>