<?php

/**
 * Get the class name from the full class path.
 *
 * @param  string $name
 * @return string
 */
function getClassName($name)
{
    return str_replace('_', ' ', \Str::snake(class_basename($name)));
}
