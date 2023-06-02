<?php
declare(strict_types = 1);
/**
 * Settings.php
 */
namespace Rcsvpg\Murls\Application\Settings;

class Settings implements SettingsInterface
{
    /**
     * @var array
     */
    private $settings;

    /**
     * Constructor
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * Get settings, if $key is empty, return all settings
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}