<?php

namespace StGeorgeIPG\Exceptions;

use StGeorgeIPG\Request;
use StGeorgeIPG\Response;

class TransactionFailedException extends \Exception
{
	/**
	 * @var Request $request
	 */
	private $request;

	/**
	 * @var Response $response
	 */
	private $response;

	/**
	 * @var integer $maxTries
	 */
	private $maxTries;

	/**
	 * TransactionFailedException constructor.
	 *
	 * @param Request  $request
	 * @param Response $response
	 * @param integer  $maxTries
	 */
	public function __construct($request, $response, $maxTries)
	{
		$this->request = $request;
		$this->response = $response;
		$this->maxTries = $maxTries;

		return parent::__construct('Transaction failed after ' . $maxTries . ' tries.');
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return integer
	 */
	public function getMaxTries()
	{
		return $this->maxTries;
	}
}