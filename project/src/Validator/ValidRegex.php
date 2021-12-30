<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute]
class ValidRegex extends Constraint
{
    public $message = 'The string "{{ string }}" is not valid PHP regex.';
    public $mode = 'strict';
}