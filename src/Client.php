<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Exceptions\TransactionFailedException;
use StGeorgeIPG\Exceptions\TransactionInProgressException;

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
	 * The default server URL.
	 */
	const SERVER = 'www.gwipg.stgeorge.com.au';

	/**
	 * The port for live transactions.
	 */
	const PORT_LIVE = 3016;

	/**
	 * The port for test transactions.
	 */
	const PORT_TEST = 3017;

	/**
	 * @var Webpay $webpay
	 */
	private $webpay;

	/**
	 * @var integer $clientId
	 */
	private $clientId;

	/**
	 * @var string $certificatePath
	 */
	private $certificatePath;

	/**
	 * @var string $certificatePassword
	 */
	private $certificatePassword;

	/**
	 * @var boolean $debug
	 */
	private $debug;

	/**
	 * @var string $logPath
	 */
	private $logPath;

	/**
	 * @var string[] $servers
	 */
	private $servers;

	/**
	 * @var integer $port
	 */
	private $port;

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
	 * @param integer  $clientId
	 * @param string   $certificatePassword
	 * @param Webpay   $webpay
	 * @param string   $certificatePath
	 * @param string   $logPath
	 * @param boolean  $debug
	 * @param integer  $port
	 * @param string[] $servers
	 * @param integer  $terminalType
	 * @param string   $interface
	 */
	public function __construct($clientId, $certificatePassword, Webpay $webpay, $certificatePath = 'cert.cert', $debug = FALSE, $logPath = 'webpay.log', $port = Client::PORT_LIVE, array $servers = [
		Client::SERVER,
	], $terminalType = Request::TERMINAL_TYPE_INTERNET, $interface = Request::INTERFACE_CREDIT_CARD)
	{
		$this
			->setClientId($clientId)
			->setCertificatePath($certificatePath)
			->setCertificatePassword($certificatePassword)
			->setLogPath($logPath)
			->setDebug($debug)
			->setWebpay($webpay)
			->setPort($port)
			->setServers($servers)
			->setTerminalType($terminalType)
			->setInterface($interface);
	}

	/**
	 * @return Webpay
	 */
	public function getWebpay()
	{
		return $this->webpay;
	}

	/**
	 * @param Webpay $webpay
	 *
	 * @return Client
	 */
	public function setWebpay($webpay)
	{
		$this->webpay = $webpay;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param integer $clientId
	 *
	 * @return Client
	 */
	public function setClientId($clientId)
	{
		$this->clientId = $clientId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCertificatePath()
	{
		return $this->certificatePath;
	}

	/**
	 * @param string $certificatePath
	 *
	 * @return Client
	 */
	public function setCertificatePath($certificatePath)
	{
		$this->certificatePath = $certificatePath;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCertificatePassword()
	{
		return $this->certificatePassword;
	}

	/**
	 * @param string $certificatePassword
	 *
	 * @return Client
	 */
	public function setCertificatePassword($certificatePassword)
	{
		$this->certificatePassword = $certificatePassword;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getDebug()
	{
		return $this->debug;
	}

	/**
	 * @param boolean $debug
	 *
	 * @return Client
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogPath()
	{
		return $this->logPath;
	}

	/**
	 * @param string $logPath
	 *
	 * @return Client
	 */
	public function setLogPath($logPath)
	{
		$this->logPath = $logPath;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getServers()
	{
		return $this->servers;
	}

	/**
	 * @param string[] $servers
	 *
	 * @return Client
	 */
	public function setServers($servers)
	{
		if (!is_array($servers)) {
			$servers = [$servers];
		}

		$this->servers = $servers;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * @param integer $port
	 *
	 * @return Client
	 */
	public function setPort($port)
	{
		$this->port = $port;

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
	 * @return Client
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
	 * @return Client
	 */
	public function setInterface($interface)
	{
		$this->interface = $interface;

		return $this;
	}

	/**
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

		$request
			->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
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

		$request
			->setTransactionType(Request::TRANSACTION_TYPE_REFUND)
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

		$request
			->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH)
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

		$request
			->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION)
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
	 * @param $transactionReference
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function status($transactionReference)
	{
		$request = Request::createFromClient($this);

		$request
			->setTransactionType(Request::TRANSACTION_TYPE_STATUS)
			->setTransactionReference($transactionReference);

		return $request;
	}

	/**
	 * Get a response for the given request, following the flow diagram provided by St.George.
	 *
	 * @param \StGeorgeIPG\Request $request
	 * @param int                  $maxTries
	 *
	 * @return \StGeorgeIPG\Response
	 * @throws \StGeorgeIPG\Exceptions\TransactionFailedException
	 * @throws \StGeorgeIPG\Exceptions\TransactionInProgressException
	 */
	public function getResponse(Request $request, $maxTries = 3)
	{
		$request->validate();

		$result = $this->getWebpay()->executeTransaction($request->getWebpayReference());

		$response = Response::createFromWebpayReference($this->getWebpay(), $request->getWebpayReference());

		if ($result) {
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
		} else {
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
		}

		return $response;
	}

	/**
	 * Get the response, and then map the response code for any errors to appropriate exceptions.
	 *
	 * @param \StGeorgeIPG\Request $request
	 * @param int                  $maxTries
	 *
	 * @return \StGeorgeIPG\Response
	 * @throws \StGeorgeIPG\Exceptions\ResponseCodes\Exception
	 * @throws \StGeorgeIPG\Exceptions\TransactionFailedException
	 * @throws \StGeorgeIPG\Exceptions\TransactionInProgressException
	 */
	public function execute(Request $request, $maxTries = 3)
	{
		$response = $this->getResponse($request, $maxTries);

		return $this->validateResponse($response);
	}

	/**
	 * Get the response, and then map the response code for any errors to appropriate exceptions.
	 *
	 * @param \StGeorgeIPG\Response $response
	 *
	 * @return \StGeorgeIPG\Response
	 * @throws \StGeorgeIPG\Exceptions\ResponseCodes\Exception
	 * @throws \StGeorgeIPG\Exceptions\TransactionFailedException
	 * @throws \StGeorgeIPG\Exceptions\TransactionInProgressException
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