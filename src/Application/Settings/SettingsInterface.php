<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Settings;

interface SettingsInterface
{
    /**
     * Get settings
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '');
}