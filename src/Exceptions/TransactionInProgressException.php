<?php

namespace StGeorgeIPG\Exceptions;

use StGeorgeIPG\Request;
use StGeorgeIPG\Response;

class TransactionInProgressException extends \Exception
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
	 * TransactionInProgressException constructor.
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

		$message = 'Transaction [' . $response->getTransactionReference() . '] was still in progress after ' . $maxTries . ' tries.';

		return parent::__construct($message);
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