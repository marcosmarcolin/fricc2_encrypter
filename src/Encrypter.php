<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use Exception;

/**
 * @author Marcos Marcolin <marcolindev@gmail.com>
 */
final class Encrypter
{
    use Files, PlatformCheck;

    private const ENCODER_NAME = 'fricc2';
    private const EXTENSION_FILE_PHP = 'php';

    private string $dirFrom = '';
    private string $dirTo = '';
    private string $encoder;
    private array $faileds = [];
    private array $success = [];

    /**
     * @throws Exception
     */
    public function __construct(string $dirFrom, string $dirTo, string $encoder = '')
    {
        $this->dirFrom = $dirFrom;
        $this->dirTo = $dirTo;
        $this->encoder = $encoder !== '' ? $encoder : self::ENCODER_NAME;
        $this->performChecks();
    }

    /**
     * Returns an array of failed files
     *
     * @return array
     */
    public function getFaileds(): array
    {
        return $this->faileds;
    }

    /**
     * Returns an array of success files
     * @return array
     */
    public function getSuccess(): array
    {
        return $this->success;
    }

    /**
     * Encode php files recursively from one directory to another
     *
     * @throws Exception
     */
    public function recursiveEncrypt(): bool
    {
        try {
            $this->recursiveIterator();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return true;
    }
}