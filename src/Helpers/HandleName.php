<?php

namespace Wagner\LaravelModuleCreate\Helpers;

/**
 * Class HandleName
 * @package Wagner\LaravelModuleCreate\Helpers
 */
class HandleName
{
    /**
     * @param string $name
     * @return string
     */
    public function handleName(string $name): string
    {
        $name = strtolower($name);
        $aux = str_replace(' ', '', $name);
        if ($name !== $aux) {
            $name = ucwords($name);
            return str_replace(' ', '', $name);
        }

        return ucfirst($name);
    }
}