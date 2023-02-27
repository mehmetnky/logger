<?php
/**
 * Custom Logger
 *
 * @author          Mehmet Can Nokay <mehmetnky@gmail.com>
 * @copyright       Mehmet Can Nokay
 */
namespace Mehmetnky\Logger;

use Psr\Log\LoggerInterface;

class Logger extends LoggerConfig implements LoggerInterface
{
    // Line to write to file
    private $line;
    private LoggerLevel $level;

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::EMERGENCY();
        $this->log($this->level, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::ALERT();
        $this->log($this->level, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::CRITICAL();
        $this->log($this->level, $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::ERROR();
        $this->log($this->level, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::WARNING();
        $this->log($this->level, $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::NOTICE();
        $this->log($this->level, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::INFO();
        $this->log($this->level, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->level = LoggerLevel::DEBUG();
        $this->log($this->level, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (empty($this->level) || !empty($level)) {
            try {
                $level = LoggerLevel::from($level);
            } catch (\Exception $ex) {
                $level = LoggerLevel::ERROR();
                $message = $ex->getMessage();
            }
        } else {
            $level = $this->level;
        }

        $this->prepareLog($level, $message, $context);
        $this->writeToFile();
    }

    private function prepareLog(LoggerLevel $level, $message, $context = []): void
    {
        $this->addDate($level);
        $this->addMessage($message);
        $this->addContext($context);
    }

    private function addDate(LoggerLevel $level): void
    {
        date_default_timezone_set('UTC');

        $this->line = "\n[".date('Y-m-d h:i:s').'] '.$level.': ';
    }

    private function addMessage($message): void
    {
        $this->line .= $message;
    }

    private function addContext($context): void
    {
        if (!empty($context)) {
            $this->line .= "\nMoreInfo:";

            foreach ($context as $key => $value) {
                $this->line .= "\n$key: $value";
            }
        }
    }

    private function writeToFile(): void
    {
        $this->createFileIfNotExists($this->filePath);

        $myfile = fopen($this->filePath, "a") or die("Unable to open file!");
        fwrite($myfile, $this->line);
        fclose($myfile);
    }

    private function createFileIfNotExists(string $filePath): void
    {
        if (!file_exists($filePath)) {
            $filePathSegments = explode('/', $filePath);

            if (count($filePathSegments) > 1) {
                $fileName = array_pop($filePathSegments);
                $filePath = implode('/',$filePathSegments);

                mkdir($filePath, 0664, true);
            }

            touch($filePath);
        }
    }
}