<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use Exception;

/**
 * @author Marcos Marcolin <marcolindev@gmail.com>
 */
final class Encrypter
{
    use Files;
    use PlatformCheck;

    private const ENCODER_NAME = 'fricc2';
    private const EXTENSION_FILE_PHP = 'php';

    private string $from = '';
    private string $to = '';
    private string $encoder;
    private array $faileds = [];
    private array $success = [];

    /**
     * @throws Exception
     */
    public function __construct(string $from, string $to, string $encoder = '')
    {
        $this->from = $from;
        $this->to = $to;
        $this->encoder = $encoder !== '' ? $encoder : self::ENCODER_NAME;
        $this->performChecks();
    }

    /**
     * Returns an array of failed files
     */
    public function getFaileds(): array
    {
        return $this->faileds;
    }

    /**
     * Returns an array of success files
     *
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

    /**
     * Encodes only one file
     *
     * @throws Exception
     */
    public function simpleEncrypt(): bool
    {
        try {
            $this->fricc2Encrypt($this->from, $this->to);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return true;
    }
}
