<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

trait Files
{
    protected function recursiveIterator()
    {
        $this->checkDirs();

        $RecursiveIteratorIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->from));

        /** @var SplFileInfo $file */
        foreach ($RecursiveIteratorIterator as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($file->getExtension() === self::EXTENSION_FILE_PHP && $file->isReadable()) {
                $path = str_replace($this->from, '', $file->getPathname());
                $dirToRelative = $this->to . $path;
                $output = $this->fricc2Encrypt($file->getPathname(), $dirToRelative);
                $this->analyseOutput($output, $file->getPathname());
            }
        }
    }

    /**
     * Perform some validations for the tool to work
     *
     * @return void
     */
    protected function checkDirs()
    {
        if (!is_dir($this->from)) {
            throw new InvalidArgumentException('Invalid source directory!');
        }

        if (!is_dir($this->to)) {
            if (!mkdir($this->to, 0755, true)) {
                throw new InvalidArgumentException('Invalid destination directory!');
            }
        }
    }

    /**
     * Encode the file from one directory to another
     *
     * @return false|string
     */
    protected function fricc2Encrypt(string $from, string $to)
    {
        $dirname = dirname($to);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        return exec(self::ENCODER_NAME . ' -o ' . $to . ' ' . $from);
    }

    /**
     * If it fails, save to array
     *
     * @param string $output
     * @param $filename
     * @return void
     */
    protected function analyseOutput(string $output, $filename): void
    {
        if (!$this->getStatusEncrypt($output)) {
            $this->success[] = $filename;
        } else {
            $this->faileds[] = $filename;
        }
    }

    protected function getStatusEncrypt($output): bool
    {
        return stripos(strtolower($output), 'error');
    }
}