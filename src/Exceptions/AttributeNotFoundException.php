<?php

namespace StGeorgeIPG\Exceptions;

class AttributeNotFoundException extends \InvalidArgumentException
{
	public function __construct($attribute)
	{
		return parent::__construct('No mappings found for attribute "' . $attribute . '".');
	}
}