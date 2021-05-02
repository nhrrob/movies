<?php

namespace Nhrrob\Movies\Traits;

/**
 * Error handler trait
 */
trait Form_Error
{
    /**
     * Holds the erros
     *
     * @var array
     */
    public $errors = [];

    /**
     * Check if the form has error
     *
     * @param string $key
     * @return boolean
     */
    public function has_error($key)
    {
        return isset($this->errors[$key]) ? true : false;
    }

    /**
     * Get the error by key
     *
     * @param key $key
     * @return string|false
     */
    public function get_error($key)
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : false;
    }
}
