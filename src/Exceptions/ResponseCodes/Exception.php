<?php

namespace StGeorgeIPG\Exceptions\ResponseCodes;

use StGeorgeIPG\Response;

class Exception extends \Exception
{
	/**
	 * @var Response $response
	 */
	protected $response;

	/**
	 * @var string $responseCode
	 */
	protected $responseCode;

	/**
	 * @var string $responseText
	 */
	protected $responseText;

	/**
	 * Exception constructor.
	 *
	 * @param Response $response
	 */
	public function __construct(Response $response)
	{
		parent::__construct();

		$this->response     = $response;
		$this->responseCode = $response->getCode();
		$this->responseText = $response->getText();

		$this->message = 'Response was ' . $this->responseCode . ' - ' . $this->responseText . '.';
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