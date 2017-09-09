<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Contracts\Provider;
use StGeorgeIPG\Exceptions\TransactionFailedException;
use StGeorgeIPG\Exceptions\TransactionInProgressException;
use StGeorgeIPG\Providers\Extension;
use StGeorgeIPG\Providers\WebService;

/**
 * Class Client
 *
 * This class acts as a manager for the lower-level requests and responses.
 *
 * @package StGeorgeIPG
 */
class Client
{
	/**
	 * @var \StGeorgeIPG\Contracts\Provider
	 */
	private $provider;

	/**
	 * @var integer $terminalType
	 */
	private $terminalType;

	/**
	 * @var string $interface
	 */
	private $interface;

	/**
	 * Client constructor.
	 *
	 * Initialises the client, using some sensible defaults.
	 *
	 * @param \StGeorgeIPG\Contracts\Provider $provider
	 * @param integer                         $terminalType
	 * @param string                          $interface
	 */
	public function __construct(Provider $provider, $terminalType = Request::TERMINAL_TYPE_INTERNET, $interface = Request::INTERFACE_CREDIT_CARD)
	{
		$this->setProvider($provider)
		     ->setTerminalType($terminalType)
		     ->setInterface($interface);
	}

	/**
	 * @param int    $terminalType
	 * @param string $interface
	 *
	 * @return \StGeorgeIPG\Client
	 */
	public static function createWithExtension($terminalType = Request::TERMINAL_TYPE_INTERNET, $interface = Request::INTERFACE_CREDIT_CARD)
	{
		$provider = new Extension();

		$client = new Client($provider, $terminalType, $interface);

		return $client;
	}

	/**
	 * @param int    $terminalType
	 * @param string $interface
	 *
	 * @return \StGeorgeIPG\Client
	 */
	public static function createWithWebService($terminalType = Request::TERMINAL_TYPE_INTERNET, $interface = Request::INTERFACE_CREDIT_CARD)
	{
		$provider = new WebService();

		$client = new Client($provider, $terminalType, $interface);

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Contracts\Provider
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * @param \StGeorgeIPG\Contracts\Provider $provider
	 *
	 * @return Client
	 */
	public function setProvider($provider)
	{
		$this->provider = $provider;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getTerminalType()
	{
		return $this->terminalType;
	}

	/**
	 * @param integer $terminalType
	 *
	 * @return \StGeorgeIPG\Client
	 */
	public function setTerminalType($terminalType)
	{
		$this->terminalType = $terminalType;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getInterface()
	{
		return $this->interface;
	}

	/**
	 * @param string $interface
	 *
	 * @return \StGeorgeIPG\Client
	 */
	public function setInterface($interface)
	{
		$this->interface = $interface;

		return $this;
	}

	/**
	 * Create a purchase request.
	 *
	 * @param      $amount
	 * @param      $cardNumber
	 * @param      $month
	 * @param      $year
	 * @param null $cvc
	 * @param null $clientReference
	 * @param null $comment
	 * @param null $description
	 * @param null $cardHolderName
	 * @param null $taxAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function purchase($amount, $cardNumber, $month, $year, $cvc = NULL, $clientReference = NULL, $comment = NULL, $description = NULL, $cardHolderName = NULL, $taxAmount = NULL)
	{
		$request = Request::createFromClient($this);

		$request->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
		        ->setTotalAmount($amount)
		        ->setCardData($cardNumber)
		        ->setCardExpiryDate($month, $year)
		        ->setCVC2($cvc)
		        ->setClientReference($clientReference)
		        ->setComment($comment)
		        ->setMerchantDescription($description)
		        ->setMerchantCardHolderName($cardHolderName)
		        ->setTaxAmount($taxAmount);

		return $request;
	}

	/**
	 * Create a refund request.
	 *
	 * @param      $amount
	 * @param      $originalTransactionReference
	 * @param null $clientReference
	 * @param null $comment
	 * @param null $description
	 * @param null $cardHolderName
	 * @param null $taxAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function refund($amount, $originalTransactionReference, $clientReference = NULL, $comment = NULL, $description = NULL, $cardHolderName = NULL, $taxAmount = NULL)
	{
		$request = Request::createFromClient($this);

		$request->setTransactionType(Request::TRANSACTION_TYPE_REFUND)
		        ->setTotalAmount($amount)
		        ->setOriginalTransactionReference($originalTransactionReference)
		        ->setClientReference($clientReference)
		        ->setComment($comment)
		        ->setMerchantDescription($description)
		        ->setMerchantCardHolderName($cardHolderName)
		        ->setTaxAmount($taxAmount);

		return $request;
	}

	/**
	 * Create a pre auth request.
	 *
	 * @param      $amount
	 * @param      $cardNumber
	 * @param      $month
	 * @param      $year
	 * @param null $cvc
	 * @param null $clientReference
	 * @param null $comment
	 * @param null $description
	 * @param null $cardHolderName
	 * @param null $taxAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function preAuth($amount, $cardNumber, $month, $year, $cvc = NULL, $clientReference = NULL, $comment = NULL, $description = NULL, $cardHolderName = NULL, $taxAmount = NULL)
	{
		$request = Request::createFromClient($this);

		$request->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH)
		        ->setTotalAmount($amount)
		        ->setCardData($cardNumber)
		        ->setCardExpiryDate($month, $year)
		        ->setCVC2($cvc)
		        ->setClientReference($clientReference)
		        ->setComment($comment)
		        ->setMerchantDescription($description)
		        ->setMerchantCardHolderName($cardHolderName)
		        ->setTaxAmount($taxAmount);

		return $request;
	}

	/**
	 * Create a completion request.
	 *
	 * @param      $amount
	 * @param      $originalTransactionReference
	 * @param      $authorisationNumber
	 * @param null $clientReference
	 * @param null $comment
	 * @param null $description
	 * @param null $cardHolderName
	 * @param null $taxAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function completion($amount, $originalTransactionReference, $authorisationNumber, $clientReference = NULL, $comment = NULL, $description = NULL, $cardHolderName = NULL, $taxAmount = NULL)
	{
		$request = Request::createFromClient($this);

		$request->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION)
		        ->setTotalAmount($amount)
		        ->setOriginalTransactionReference($originalTransactionReference)
		        ->setAuthorisationNumber($authorisationNumber)
		        ->setClientReference($clientReference)
		        ->setComment($comment)
		        ->setMerchantDescription($description)
		        ->setMerchantCardHolderName($cardHolderName)
		        ->setTaxAmount($taxAmount);

		return $request;
	}

	/**
	 * Create a status request.
	 *
	 * @param $transactionReference
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function status($transactionReference)
	{
		$request = Request::createFromClient($this, FALSE);

		$request->setTransactionType(Request::TRANSACTION_TYPE_STATUS)
		        ->setTransactionReference($transactionReference);

		return $request;
	}

	/**
	 * Get a response for the given request, following the flow diagram provided by St.George.
	 *
	 * @param \StGeorgeIPG\Request $request
	 * @param integer              $maxTries
	 *
	 * @return \StGeorgeIPG\Response
	 * @throws \StGeorgeIPG\Exceptions\TransactionFailedException
	 * @throws \StGeorgeIPG\Exceptions\TransactionInProgressException
	 */
	public function getResponse(Request $request, $maxTries = 3)
	{
		$request->validate();

		$response = $this->getProvider()
		                 ->getResponse($request, $canSafelyTryAgain);

		if ($canSafelyTryAgain) {
			if ($response->getTransactionReference() !== NULL) {
				if ($maxTries > 0) {
					$response = $this->getResponse($this->status($response->getTransactionReference()), $maxTries - 1);
				} else {
					throw new TransactionFailedException($request, $response, $maxTries);
				}
			} else {
				if ($maxTries > 0) {
					return $this->getResponse($request, $maxTries - 1);
				} else {
					throw new TransactionFailedException($request, $response, $maxTries);
				}
			}
		} else {
			if ($response->isCodeInProgress()) {
				if ($maxTries > 0) {
					if ($request->isTransactionTypeStatus()) {
						$response = $this->getResponse($request, $maxTries - 1);
					} else {
						$response = $this->getResponse($this->status($response->getTransactionReference()), $maxTries - 1);
					}
				} else {
					throw new TransactionInProgressException($request, $response, $maxTries);
				}
			}
		}

		return $response;
	}

	/**
	 * Get the response, and then pass it to the validator.
	 *
	 * @param \StGeorgeIPG\Request $request
	 * @param integer              $maxTries
	 *
	 * @return \StGeorgeIPG\Response
	 *
	 * @throws \StGeorgeIPG\Exceptions\TransactionInProgressException
	 */
	public function execute(Request $request, $maxTries = 3)
	{
		try {
			$response = $this->getResponse($request, $maxTries);

			return $this->validateResponse($response);
		} catch (TransactionInProgressException $ex) {
			throw new TransactionInProgressException($ex->getRequest(), $ex->getResponse(), $maxTries); // Throw a new exception with the correct maximum tries.
		}
	}

	/**
	 * Map the response code for any errors to appropriate exceptions.
	 *
	 * @param \StGeorgeIPG\Response $response
	 *
	 * @return \StGeorgeIPG\Response
	 * @throws \StGeorgeIPG\Exceptions\ResponseCodes\Exception
	 */
	public function validateResponse(Response $response)
	{
		if ($response->isCodeApproved()) {
			return $response;
		} else {
			throw Response::mapResponseCodeToException($response);
		}
	}
}