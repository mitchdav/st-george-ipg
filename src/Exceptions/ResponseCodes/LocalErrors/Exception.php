<?php

namespace StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors;

use StGeorgeIPG\Response;

class Exception extends \StGeorgeIPG\Exceptions\ResponseCodes\Exception
{
	/**
	 * Exception constructor.
	 *
	 * @param Response $response
	 */
	public function __construct(Response $response)
	{
		parent::__construct($response);

		$this->responseCode = Response::CODE_LOCAL_ERROR;
		$this->responseText = $response->getError();

		$this->message = 'Response was ' . $this->responseCode . ' - ' . $this->responseText . '.';
	}
}