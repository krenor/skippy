<?php

namespace Skippy\Exceptions;

use Exception;

class MissingConfigurationException extends Exception
{
    /**
     * MissingConfigurationException constructor.
     */
    public function __construct()
    {
        parent::__construct('Please ensure that a skippy.php file is present in the config directory. 
            Try re-publishing using `php artisan vendor:publish --provider="Skippy\Providers\SkippyServiceProvider"`.');
    }
}
