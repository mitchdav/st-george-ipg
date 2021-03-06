<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Exceptions\ResponseCodes\BankNotAvailableException;
use StGeorgeIPG\Exceptions\ResponseCodes\CardExpiredException;
use StGeorgeIPG\Exceptions\ResponseCodes\CardInvalidException;
use StGeorgeIPG\Exceptions\ResponseCodes\CustomerContactBankException;
use StGeorgeIPG\Exceptions\ResponseCodes\DeclinedSystemErrorException;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;
use StGeorgeIPG\Exceptions\ResponseCodes\InitializedException;
use StGeorgeIPG\Exceptions\ResponseCodes\InProgressException;
use StGeorgeIPG\Exceptions\ResponseCodes\InsufficientFundsException;
use StGeorgeIPG\Exceptions\ResponseCodes\InvalidClientIdException;
use StGeorgeIPG\Exceptions\ResponseCodes\InvalidDecimalPlacementException;
use StGeorgeIPG\Exceptions\ResponseCodes\InvalidRefundException;
use StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors\ConnectionException;
use StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors\InitializeSSLException;
use StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors\NegotiateSSLException;
use StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors\ProcessException;
use StGeorgeIPG\Exceptions\ResponseCodes\ServerBusyException;
use StGeorgeIPG\Exceptions\ResponseCodes\TimeoutException;
use StGeorgeIPG\Exceptions\ResponseCodes\UnableToProcessException;
use StGeorgeIPG\Exceptions\ResponseCodes\ValidationFailureException;

/**
 * Class Response
 *
 * This class holds the fields returned by the transaction response.
 *
 * @package StGeorgeIPG
 */
class Response
{
	/*
	 * The attributes available for Webpay responses.
	 */
	const ATTRIBUTE_RESPONSE_CODE         = 'RESPONSECODE';
	const ATTRIBUTE_RESPONSE_TEXT         = 'RESPONSETEXT';
	const ATTRIBUTE_ERROR                 = 'ERROR';
	const ATTRIBUTE_ERROR_DETAIL          = 'ERRORDETAIL';
	const ATTRIBUTE_TRANSACTION_REFERENCE = 'TXNREFERENCE';
	const ATTRIBUTE_AUTH_CODE             = 'AUTHCODE';
	const ATTRIBUTE_STAN                  = 'STAN';
	const ATTRIBUTE_SETTLEMENT_DATE       = 'SETTLEMENTDATE';

	/*
	 * Common response codes.
	 */
	const CODE_00          = '00';
	const CODE_03          = '03';
	const CODE_05          = '05';
	const CODE_08          = '08';
	const CODE_31          = '31';
	const CODE_33          = '33';
	const CODE_51          = '51';
	const CODE_77          = '77';
	const CODE_91          = '91';
	const CODE_0C          = '0C';
	const CODE_0M          = '0M';
	const CODE_A6          = 'A6';
	const CODE_A8          = 'A8';
	const CODE_AC          = 'AC';
	const CODE_AE          = 'AE';
	const CODE_IN          = 'IN';
	const CODE_IP          = 'IP';
	const CODE_VA          = 'VA';
	const CODE_Y3          = 'Y3';
	const CODE_LOCAL_ERROR = '-1';

	/**
	 * @var array $attributeMapping
	 */
	private static $attributeMapping = [
		Response::ATTRIBUTE_RESPONSE_CODE         => 'code',
		Response::ATTRIBUTE_RESPONSE_TEXT         => 'text',
		Response::ATTRIBUTE_ERROR                 => 'error',
		Response::ATTRIBUTE_ERROR_DETAIL          => 'errorDetail',
		Response::ATTRIBUTE_TRANSACTION_REFERENCE => 'transactionReference',
		Response::ATTRIBUTE_AUTH_CODE             => 'authCode',
		Response::ATTRIBUTE_STAN                  => 'stan',
		Response::ATTRIBUTE_SETTLEMENT_DATE       => 'settlementDate',
	];

	/**
	 * @var array $approvedCodes
	 */
	private static $approvedCodes = [
		Response::CODE_00,
		Response::CODE_08,
		Response::CODE_77,
	];

	/**
	 * @var string $code
	 */
	private $code;

	/**
	 * @var string $text
	 */
	private $text;

	/**
	 * @var string $error
	 */
	private $error;

	/**
	 * @var string $errorDetail
	 */
	private $errorDetail;

	/**
	 * @var string $transactionReference
	 */
	private $transactionReference;

	/**
	 * @var string $authCode
	 */
	private $authCode;

	/**
	 * @var string $stan
	 */
	private $stan;

	/**
	 * @var string $settlementDate
	 */
	private $settlementDate;

	/**
	 * @var boolean $live
	 */
	private $live;

	/**
	 * @param \StGeorgeIPG\Response $response
	 *
	 * @return \StGeorgeIPG\Exceptions\ResponseCodes\Exception
	 */
	public static function mapResponseCodeToException(Response $response)
	{
		switch ($response->getCode()) {
			case Response::CODE_03: {
				return new DeclinedSystemErrorException($response);
			}

			case Response::CODE_05: {
				return new CustomerContactBankException($response);
			}

			case Response::CODE_31: {
				return new CardInvalidException($response);
			}

			case Response::CODE_33:
			case Response::CODE_AC: {
				return new CardExpiredException($response);
			}

			case Response::CODE_51: {
				return new InsufficientFundsException($response);
			}

			case Response::CODE_91: {
				return new BankNotAvailableException($response);
			}

			case Response::CODE_0C: {
				return new InvalidDecimalPlacementException($response);
			}

			case Response::CODE_0M: {
				return new InvalidClientIdException($response);
			}

			case Response::CODE_A6: {
				return new ServerBusyException($response);
			}

			case Response::CODE_A8: {
				return new InvalidRefundException($response);
			}

			case Response::CODE_AE: {
				return new TimeoutException($response);
			}

			case Response::CODE_IN: {
				return new InitializedException($response);
			}

			case Response::CODE_IP: {
				return new InProgressException($response);
			}

			case Response::CODE_VA: {
				return new ValidationFailureException($response);
			}

			case Response::CODE_Y3: {
				return new UnableToProcessException($response);
			}

			/**
			 * A blank string is included here as the Webpay library doesn't seem to return the -1 code
			 * to this library, regardless of what is output in the log file.
			 */
			case '':
			case Response::CODE_LOCAL_ERROR: {
				switch ($response->getError()) {
					case 'Unable to initialise SSL': {
						return new InitializeSSLException($response);
					}

					case 'Unable to negotiate SSL': {
						return new NegotiateSSLException($response);
					}

					case 'Unable to connect to server': {
						return new ConnectionException($response);
					}

					case 'Unable to process': {
						return new ProcessException($response);
					}

					default: {
						return new Exceptions\ResponseCodes\LocalErrors\Exception($response);
					}
				}
			}

			default: {
				return new Exception($response);
			}
		}
	}

	/**
	 * @param array $array
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public static function createFromAttributeArray(array $array)
	{
		$input = array_change_key_case($array, CASE_LOWER);

		$response = new Response();

		foreach (Response::$attributeMapping as $attribute => $localVariable) {
			$loweredAttribute = strtolower($attribute);

			if (array_key_exists($loweredAttribute, $input)) {
				$response->{$localVariable} = $input[$loweredAttribute];
			}
		}

		return $response;
	}

	/**
	 * @return array
	 */
	public static function getAttributeMapping()
	{
		return self::$attributeMapping;
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setCode($code)
	{
		$this->code = $code;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isCodeApproved()
	{
		return in_array($this->getCode(), Response::$approvedCodes);
	}

	/**
	 * @return boolean
	 */
	public function isCodeInProgress()
	{
		return $this->getCode() == Response::CODE_IP;
	}

	/**
	 * @return boolean
	 */
	public function isCodeLocalError()
	{
		return $this->getCode() == Response::CODE_LOCAL_ERROR;
	}

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * @param string $error
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setError($error)
	{
		$this->error = $error;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getErrorDetail()
	{
		return $this->errorDetail;
	}

	/**
	 * @param string $errorDetail
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setErrorDetail($errorDetail)
	{
		$this->errorDetail = $errorDetail;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTransactionReference()
	{
		return $this->transactionReference;
	}

	/**
	 * @param string $transactionReference
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setTransactionReference($transactionReference)
	{
		$this->transactionReference = $transactionReference;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthCode()
	{
		return $this->authCode;
	}

	/**
	 * @param string $authCode
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setAuthCode($authCode)
	{
		$this->authCode = $authCode;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStan()
	{
		return $this->stan;
	}

	/**
	 * @param string $stan
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setStan($stan)
	{
		$this->stan = $stan;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSettlementDate()
	{
		return $this->settlementDate;
	}

	/**
	 * @param string $settlementDate
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setSettlementDate($settlementDate)
	{
		$this->settlementDate = $settlementDate;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isLive()
	{
		return $this->live === TRUE;
	}

	/**
	 * @param boolean $live
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setLive($live = TRUE)
	{
		$this->live = $live;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isTest()
	{
		return !$this->isLive();
	}

	/**
	 * @param boolean $test
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function setTest($test = TRUE)
	{
		$this->setLive(!$test);

		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			Response::$attributeMapping[Response::ATTRIBUTE_RESPONSE_CODE]         => $this->getCode(),
			Response::$attributeMapping[Response::ATTRIBUTE_RESPONSE_TEXT]         => $this->getText(),
			Response::$attributeMapping[Response::ATTRIBUTE_ERROR]                 => $this->getError(),
			Response::$attributeMapping[Response::ATTRIBUTE_ERROR_DETAIL]          => $this->getErrorDetail(),
			Response::$attributeMapping[Response::ATTRIBUTE_TRANSACTION_REFERENCE] => $this->getTransactionReference(),
			Response::$attributeMapping[Response::ATTRIBUTE_AUTH_CODE]             => $this->getAuthCode(),
			Response::$attributeMapping[Response::ATTRIBUTE_STAN]                  => $this->getStan(),
			Response::$attributeMapping[Response::ATTRIBUTE_SETTLEMENT_DATE]       => $this->getSettlementDate(),
			'live'                                                                 => $this->isLive(),
			'test'                                                                 => $this->isTest(),
		];
	}

	/**
	 * @return array
	 */
	public function toAttributeArray()
	{
		return [
			Response::ATTRIBUTE_RESPONSE_CODE         => $this->getCode(),
			Response::ATTRIBUTE_RESPONSE_TEXT         => $this->getText(),
			Response::ATTRIBUTE_ERROR                 => $this->getError(),
			Response::ATTRIBUTE_ERROR_DETAIL          => $this->getErrorDetail(),
			Response::ATTRIBUTE_TRANSACTION_REFERENCE => $this->getTransactionReference(),
			Response::ATTRIBUTE_AUTH_CODE             => $this->getAuthCode(),
			Response::ATTRIBUTE_STAN                  => $this->getStan(),
			Response::ATTRIBUTE_SETTLEMENT_DATE       => $this->getSettlementDate(),
		];
	}
}