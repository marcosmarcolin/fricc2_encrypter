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
    private const EXTENSION_PHP = 'php';

    private string $dirFrom = '';
    private string $dirTo = '';
    private string $encoder;

    private array $faileds = [];

    /**
     * @throws Exception
     */
    public function __construct(string $dirFrom, string $dirTo, string $encoder = '')
    {
        $this->dirFrom = $dirFrom;
        $this->dirTo = $dirTo;
        $this->encoder = ($encoder !== '') ? $encoder : self::ENCODER_NAME;
        $this->check();
    }

    public function getFaileds(): array
    {
        return $this->faileds;
    }

    /**
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