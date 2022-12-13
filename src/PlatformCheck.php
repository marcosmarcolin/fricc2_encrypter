<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use Exception;

trait PlatformCheck
{
    /**
     * @throws Exception
     */
    private function check()
    {
        $this->functions();
    }

    /**
     * @throws Exception
     */
    private function functions()
    {
        if (!function_exists('exec')) {
            throw new Exception('The exec() function needs to be enabled!');
        }
    }
}