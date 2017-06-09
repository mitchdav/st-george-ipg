<?php

namespace StGeorgeIPG\Exceptions;

class InvalidAttributeValueException extends \InvalidArgumentException
{
	public function __construct($attribute, $value)
	{
		return parent::__construct('The attribute "' . $attribute . '" value "' . $value . '" is invalid.');
	}
}