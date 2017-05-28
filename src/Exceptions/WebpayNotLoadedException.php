<?php

namespace StGeorgeIPG\Exceptions;

class WebpayNotLoadedException extends \Exception
{
	public function __construct($message = 'The "webpay" extension must be loaded before the client is initialized.')
	{
		return parent::__construct($message);
	}
}