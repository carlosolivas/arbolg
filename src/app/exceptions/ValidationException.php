<?php namespace App\Exceptions;

class ValidationException extends \UnexpectedValueException 
{
    private $_validationErrors;

    public function __construct($message, $validationErrors, $code = 0, Exception $previous = null)
    {
        $this->_validationErrors = $validationErrors;
        parent::__construct($message, $code, $previous);
    }

    public function getValidationErrors ()
    {
        return $this->_validationErrors;
    }
}