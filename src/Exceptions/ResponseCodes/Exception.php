<?php

namespace StGeorgeIPG\Exceptions\ResponseCodes;

use StGeorgeIPG\Request;
use StGeorgeIPG\Response;

class Exception extends \Exception
{
	/**
	 * @var Response $response
	 */
	private $response;

	/**
	 * @var string $responseCode
	 */
	private $responseCode;

	/**
	 * @var string $responseText
	 */
	private $responseText;

	/**
	 * Exception constructor.
	 *
	 * @param Response $response
	 */
	public function __construct($response)
	{
		$this->response = $response;
		$this->responseCode = $response->getCode();
		$this->responseText = $response->getText();

		$message = 'Response was ' . $this->responseCode . ' - ' . $this->responseText . '.';

		return parent::__construct($message);
	}

	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return string
	 */
	public function getResponseCode()
	{
		return $this->responseCode;
	}

	/**
	 * @return string
	 */
	public function getResponseText()
	{
		return $this->responseText;
	}
}