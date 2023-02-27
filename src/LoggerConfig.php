<?php

namespace Mehmetnky\Logger;

class LoggerConfig
{
    protected $filePath;

    /**
     * @param string $filePath Log file path
     */
    public function __construct(string $filePath = 'app.log') {
        $this->filePath = $filePath;
    }
}