<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

trait Files
{
    private function recursiveIterator()
    {
        $this->checkDirs();

        $RecursiveIteratorIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->dirFrom));

        /** @var SplFileInfo $file */
        foreach ($RecursiveIteratorIterator as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($file->getExtension() === self::EXTENSION_PHP && $file->isReadable()) {
                $path = str_replace($this->dirFrom, '', $file->getPathname());
                $dirToRelative = $this->dirTo . $path;
                $output = $this->fricc2Encrypt($file->getPathname(), $dirToRelative);
                $this->analyseOutput($output, $file->getPathname());
            }
        }
    }

    private function checkDirs()
    {
        if (!is_dir($this->dirFrom)) {
            throw new InvalidArgumentException('Invalid source directory!');
        }

        if (!is_dir($this->dirTo)) {
            if (!mkdir($this->dirTo, 0755, true)) {
                throw new InvalidArgumentException('Invalid destination directory!');
            }
        }
    }

    /**
     * @return false|string
     */
    private function fricc2Encrypt(string $from, string $to)
    {
        $dirname = dirname($to);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        return exec(self::ENCODER_NAME . ' -o ' . $to . ' ' . $from);
    }

    private function analyseOutput($output, $filename)
    {
        if (stripos(strtolower($output), 'error') !== false) {
            $this->faileds[] = $filename;
        }
    }
}