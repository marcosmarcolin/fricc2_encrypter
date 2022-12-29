<?php

declare(strict_types=1);

namespace MarcosMarcolin\Fricc2Encrypter;

use Exception;

trait PlatformCheck
{
    /**
     * @throws Exception
     */
    protected function performChecks(): void
    {
        $this->functions();
        $this->encoder();
    }

    /**
     * @throws Exception
     */
    protected function functions(): void
    {
        if (! function_exists('exec')) {
            throw new Exception('The exec() function needs to be enabled!');
        }
    }

    /**
     * @throws Exception
     */
    protected function encoder(): void
    {
        exec('which ' . $this->encoder, $output);

        if (! is_array($output)) {
            throw new Exception('Unable to check Encoder!');
        }

        if (! isset($output[0]) || $output[0] !== '/usr/bin/' . $this->encoder) {
            throw new Exception('Encoder not detected in the System!');
        }
    }
}
