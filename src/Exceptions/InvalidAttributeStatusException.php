<?php

namespace StGeorgeIPG\Exceptions;

class InvalidAttributeStatusException extends \InvalidArgumentException
{
	public function __construct($attribute, $status)
	{
		return parent::__construct('The attribute "' . $attribute . '" is ' . $status . '.');
	}
}