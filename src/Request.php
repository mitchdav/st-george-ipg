<?php

namespace StGeorgeIPG;

use Inacho\CreditCard;
use StGeorgeIPG\Exceptions\InvalidAttributeStatusException;
use StGeorgeIPG\Exceptions\InvalidAttributeValueException;
use StGeorgeIPG\Exceptions\InvalidCardDataException;

/**
 * Class Request
 *
 * This class holds the fields needed by the transaction request.
 *
 * @package StGeorgeIPG
 */
class Request
{
	/*
	 * The attributes available for Webpay requests.
	 */
	const ATTRIBUTE_INTERFACE                      = 'INTERFACE';
	const ATTRIBUTE_TRANSACTION_TYPE               = 'TRANSACTIONTYPE';
	const ATTRIBUTE_TOTAL_AMOUNT                   = 'TOTALAMOUNT';
	const ATTRIBUTE_TAX_AMOUNT                     = 'TAXAMOUNT';
	const ATTRIBUTE_CARD_DATA                      = 'CARDDATA';
	const ATTRIBUTE_CARD_EXPIRY_DATE               = 'CARDEXPIRYDATE';
	const ATTRIBUTE_TRANSACTION_REFERENCE          = 'TXNREFERENCE';
	const ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE = 'ORIGINALTXNREF';
	const ATTRIBUTE_PRE_AUTH_NUMBER                = 'PREAUTHNUMBER';
	const ATTRIBUTE_AUTH_NUMBER                    = 'AUTHNUMBER';
	const ATTRIBUTE_AUTHORISATION_NUMBER           = 'AUTHORISATIONNUMBER';
	const ATTRIBUTE_AUTH_CODE                      = 'AUTHCODE';
	const ATTRIBUTE_AUTHORISATION_CODE             = 'AUTHORISATIONCODE';
	const ATTRIBUTE_CLIENT_REFERENCE               = 'CLIENTREF';
	const ATTRIBUTE_COMMENT                        = 'COMMENT';
	const ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME      = 'MERCHANT_CARDHOLDERNAME';
	const ATTRIBUTE_MERCHANT_DESCRIPTION           = 'MERCHANT_DESCRIPTION';
	const ATTRIBUTE_TERMINAL_TYPE                  = 'TERMINALTYPE';
	const ATTRIBUTE_CVC2                           = 'CVC2';

	/*
	 * The interfaces available for Webpay requests.
	 */
	const INTERFACE_CREDIT_CARD = 'CREDITCARD';
	const INTERFACE_TEST        = 'TEST';

	/*
	 * The transaction types available for Webpay requests.
	 */
	const TRANSACTION_TYPE_PURCHASE   = 'PURCHASE';
	const TRANSACTION_TYPE_REFUND     = 'REFUND';
	const TRANSACTION_TYPE_PRE_AUTH   = 'PREAUTH';
	const TRANSACTION_TYPE_COMPLETION = 'COMPLETION';
	const TRANSACTION_TYPE_STATUS     = 'STATUS';

	/*
	 * The terminal types available for Webpay requests.
	 */
	const TERMINAL_TYPE_INTERNET          = 0;
	const TERMINAL_TYPE_TELEPHONE_ORDER   = 1;
	const TERMINAL_TYPE_MAIL_ORDER        = 2;
	const TERMINAL_TYPE_CUSTOMER_PRESENT  = 3;
	const TERMINAL_TYPE_RECURRING_PAYMENT = 4;
	const TERMINAL_TYPE_INSTALMENT        = 5;

	/** @var \StGeorgeIPG\Webpay $webpay */
	private $webpay;

	/**
	 * @var mixed $webpayReference
	 */
	private $webpayReference;

	/**
	 * @var string $interface
	 */
	private $interface;

	/**
	 * @var string $transactionType
	 */
	private $transactionType;

	/**
	 * @var double $totalAmount
	 */
	private $totalAmount;

	/**
	 * @var double $taxAmount
	 */
	private $taxAmount;

	/**
	 * @var string $cardData
	 */
	private $cardData;

	/**
	 * @var string $cardExpiryDate
	 */
	private $cardExpiryDate;

	/**
	 * @var string $transactionReference
	 */
	private $transactionReference;

	/**
	 * @var string $originalTransactionReference
	 */
	private $originalTransactionReference;

	/**
	 * @var string $preAuthNumber
	 */
	private $preAuthNumber;

	/**
	 * @var string $authNumber
	 */
	private $authNumber;

	/**
	 * @var string $authorisationNumber
	 */
	private $authorisationNumber;

	/**
	 * @var string $authCode
	 */
	private $authCode;

	/**
	 * @var string $authorisationCode
	 */
	private $authorisationCode;

	/**
	 * @var string $clientReference
	 */
	private $clientReference;

	/**
	 * @var string $comment
	 */
	private $comment;

	/**
	 * @var string $merchantCardHolderName
	 */
	private $merchantCardHolderName;

	/**
	 * @var string $merchantDescription
	 */
	private $merchantDescription;

	/**
	 * @var integer $terminalType
	 */
	private $terminalType;

	/**
	 * @var string $cvc2
	 */
	private $cvc2;

	/**
	 * @var array $attributeMapping
	 */
	private static $attributeMapping = [
		Request::ATTRIBUTE_INTERFACE                      => 'interface',
		Request::ATTRIBUTE_TRANSACTION_TYPE               => 'transactionType',
		Request::ATTRIBUTE_TOTAL_AMOUNT                   => 'totalAmount',
		Request::ATTRIBUTE_TAX_AMOUNT                     => 'taxAmount',
		Request::ATTRIBUTE_CARD_DATA                      => 'cardData',
		Request::ATTRIBUTE_CARD_EXPIRY_DATE               => 'cardExpiryDate',
		Request::ATTRIBUTE_TRANSACTION_REFERENCE          => 'transactionReference',
		Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE => 'originalTransactionReference',
		Request::ATTRIBUTE_PRE_AUTH_NUMBER                => 'preAuthNumber',
		Request::ATTRIBUTE_AUTH_NUMBER                    => 'authNumber',
		Request::ATTRIBUTE_AUTHORISATION_NUMBER           => 'authorisationNumber',
		Request::ATTRIBUTE_AUTH_CODE                      => 'authCode',
		Request::ATTRIBUTE_AUTHORISATION_CODE             => 'authorisationCode',
		Request::ATTRIBUTE_CLIENT_REFERENCE               => 'clientReference',
		Request::ATTRIBUTE_COMMENT                        => 'comment',
		Request::ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME      => 'merchantCardHolderName',
		Request::ATTRIBUTE_MERCHANT_DESCRIPTION           => 'merchantDescription',
		Request::ATTRIBUTE_TERMINAL_TYPE                  => 'terminalType',
		Request::ATTRIBUTE_CVC2                           => 'cvc2',
	];

	/**
	 * @return \StGeorgeIPG\Webpay
	 */
	public function getWebpay()
	{
		return $this->webpay;
	}

	/**
	 * @param \StGeorgeIPG\Webpay $webpay
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setWebpay(Webpay $webpay)
	{
		$this->webpay = $webpay;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWebpayReference()
	{
		return $this->webpayReference;
	}

	/**
	 * @param mixed $webpayReference
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setWebpayReference($webpayReference)
	{
		$this->webpayReference = $webpayReference;

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
	 * @return bool
	 */
	public function isInterfaceCreditCard()
	{
		return $this->getInterface() == Request::INTERFACE_CREDIT_CARD;
	}

	/**
	 * @return bool
	 */
	public function isInterfaceTest()
	{
		return $this->getInterface() == Request::INTERFACE_TEST;
	}

	/**
	 * @param string $interface
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setInterface($interface)
	{
		$validValues = [
			Request::INTERFACE_CREDIT_CARD,
			Request::INTERFACE_TEST,
		];

		$this->validateInput(Request::ATTRIBUTE_INTERFACE, $interface, $validValues);

		$this->interface = $interface;

		$this->setAttribute(Request::ATTRIBUTE_INTERFACE, $interface);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTransactionType()
	{
		return $this->transactionType;
	}

	/**
	 * @return bool
	 */
	public function isTransactionTypePurchase()
	{
		return $this->getTransactionType() == Request::TRANSACTION_TYPE_PURCHASE;
	}

	/**
	 * @return bool
	 */
	public function isTransactionTypeRefund()
	{
		return $this->getTransactionType() == Request::TRANSACTION_TYPE_REFUND;
	}

	/**
	 * @return bool
	 */
	public function isTransactionTypePreAuth()
	{
		return $this->getTransactionType() == Request::TRANSACTION_TYPE_PRE_AUTH;
	}

	/**
	 * @return bool
	 */
	public function isTransactionTypeCompletion()
	{
		return $this->getTransactionType() == Request::TRANSACTION_TYPE_COMPLETION;
	}

	/**
	 * @return bool
	 */
	public function isTransactionTypeStatus()
	{
		return $this->getTransactionType() == Request::TRANSACTION_TYPE_STATUS;
	}

	/**
	 * @param string $transactionType
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setTransactionType($transactionType)
	{
		$validValues = [
			Request::TRANSACTION_TYPE_PURCHASE,
			Request::TRANSACTION_TYPE_REFUND,
			Request::TRANSACTION_TYPE_PRE_AUTH,
			Request::TRANSACTION_TYPE_COMPLETION,
			Request::TRANSACTION_TYPE_STATUS,
		];

		$this->validateInput(Request::ATTRIBUTE_TRANSACTION_TYPE, $transactionType, $validValues);

		$this->transactionType = $transactionType;

		$this->setAttribute(Request::ATTRIBUTE_TRANSACTION_TYPE, $transactionType);

		return $this;
	}

	/**
	 * @return double
	 */
	public function getTotalAmount()
	{
		return $this->totalAmount;
	}

	/**
	 * @param double $totalAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setTotalAmount($totalAmount)
	{
		$this->validateInputIsDouble(Request::ATTRIBUTE_TOTAL_AMOUNT, $totalAmount);

		$this->totalAmount = $totalAmount;

		$this->setAttribute(Request::ATTRIBUTE_TOTAL_AMOUNT, Request::formatCurrency($totalAmount));

		return $this;
	}

	/**
	 * @return double
	 */
	public function getTaxAmount()
	{
		return $this->taxAmount;
	}

	/**
	 * @param double $taxAmount
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setTaxAmount($taxAmount)
	{
		$this->validateInputIsDouble(Request::ATTRIBUTE_TAX_AMOUNT, $taxAmount);

		$this->taxAmount = $taxAmount;

		$this->setAttribute(Request::ATTRIBUTE_TAX_AMOUNT, Request::formatCurrency($taxAmount));

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCardData()
	{
		return $this->cardData;
	}

	/**
	 * @param string $cardData
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setCardData($cardData)
	{
		$this->validateInputIsCardNumber($cardData);

		$cardData = Request::formatCardNumber($cardData);

		$this->cardData = $cardData;

		$this->setAttribute(Request::ATTRIBUTE_CARD_DATA, $cardData);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCardExpiryDate()
	{
		return $this->cardExpiryDate;
	}

	/**
	 * @param integer $month
	 * @param integer $year
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setCardExpiryDate($month, $year)
	{
		$this->validateInputIsInteger(Request::ATTRIBUTE_CARD_EXPIRY_DATE, $month);
		$this->validateInputIsInteger(Request::ATTRIBUTE_CARD_EXPIRY_DATE, $year);
		$this->validateInputIsCardExpiryDate($month, $year);

		$cardExpiryDate = Request::formatDate($month, $year);

		$this->cardExpiryDate = $cardExpiryDate;

		$this->setAttribute(Request::ATTRIBUTE_CARD_EXPIRY_DATE, $cardExpiryDate);

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
	 * @return \StGeorgeIPG\Request
	 */
	public function setTransactionReference($transactionReference)
	{
		$this->transactionReference = $transactionReference;

		$this->setAttribute(Request::ATTRIBUTE_TRANSACTION_REFERENCE, $transactionReference);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOriginalTransactionReference()
	{
		return $this->originalTransactionReference;
	}

	/**
	 * @param string $originalTransactionReference
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setOriginalTransactionReference($originalTransactionReference)
	{
		$this->originalTransactionReference = $originalTransactionReference;

		$this->setAttribute(Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE, $originalTransactionReference);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPreAuthNumber()
	{
		return $this->preAuthNumber;
	}

	/**
	 * @param string $preAuthNumber
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setPreAuthNumber($preAuthNumber)
	{
		$this->preAuthNumber = $preAuthNumber;

		$this->setAttribute(Request::ATTRIBUTE_PRE_AUTH_NUMBER, $preAuthNumber);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthNumber()
	{
		return $this->authNumber;
	}

	/**
	 * @param string $authNumber
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setAuthNumber($authNumber)
	{
		$this->authNumber = $authNumber;

		$this->setAttribute(Request::ATTRIBUTE_AUTH_NUMBER, $authNumber);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthorisationNumber()
	{
		return $this->authorisationNumber;
	}

	/**
	 * @param string $authorisationNumber
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setAuthorisationNumber($authorisationNumber)
	{
		$this->authorisationNumber = $authorisationNumber;

		$this->setAttribute(Request::ATTRIBUTE_AUTHORISATION_NUMBER, $authorisationNumber);

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
	 * @return \StGeorgeIPG\Request
	 */
	public function setAuthCode($authCode)
	{
		$this->authCode = $authCode;

		$this->setAttribute(Request::ATTRIBUTE_AUTH_CODE, $authCode);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthorisationCode()
	{
		return $this->authorisationCode;
	}

	/**
	 * @param string $authorisationCode
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setAuthorisationCode($authorisationCode)
	{
		$this->authorisationCode = $authorisationCode;

		$this->setAttribute(Request::ATTRIBUTE_AUTHORISATION_CODE, $authorisationCode);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClientReference()
	{
		return $this->clientReference;
	}

	/**
	 * @param string $clientReference
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setClientReference($clientReference)
	{
		$this->clientReference = $clientReference;

		$this->setAttribute(Request::ATTRIBUTE_CLIENT_REFERENCE, $clientReference);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;

		$this->setAttribute(Request::ATTRIBUTE_COMMENT, $comment);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMerchantCardHolderName()
	{
		return $this->merchantCardHolderName;
	}

	/**
	 * @param string $merchantCardHolderName
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setMerchantCardHolderName($merchantCardHolderName)
	{
		$this->merchantCardHolderName = $merchantCardHolderName;

		$this->setAttribute(Request::ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME, $merchantCardHolderName);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMerchantDescription()
	{
		return $this->merchantDescription;
	}

	/**
	 * @param string $merchantDescription
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setMerchantDescription($merchantDescription)
	{
		$this->merchantDescription = $merchantDescription;

		$this->setAttribute(Request::ATTRIBUTE_MERCHANT_DESCRIPTION, $merchantDescription);

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
	 * @return bool
	 */
	public function isTerminalTypeInternet()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_INTERNET;
	}

	/**
	 * @return bool
	 */
	public function isTerminalTypeTelephoneOrder()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_TELEPHONE_ORDER;
	}

	/**
	 * @return bool
	 */
	public function isTerminalTypeMailOrder()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_MAIL_ORDER;
	}

	/**
	 * @return bool
	 */
	public function isTerminalTypeCustomerPresent()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_CUSTOMER_PRESENT;
	}

	/**
	 * @return bool
	 */
	public function isTerminalTypeRecurringPayment()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_RECURRING_PAYMENT;
	}

	/**
	 * @return bool
	 */
	public function isTerminalTypeInstalment()
	{
		return $this->getTerminalType() == Request::TERMINAL_TYPE_INSTALMENT;
	}

	/**
	 * @param integer $terminalType
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setTerminalType($terminalType)
	{
		$validValues = [
			Request::TERMINAL_TYPE_INTERNET,
			Request::TERMINAL_TYPE_TELEPHONE_ORDER,
			Request::TERMINAL_TYPE_MAIL_ORDER,
			Request::TERMINAL_TYPE_CUSTOMER_PRESENT,
			Request::TERMINAL_TYPE_RECURRING_PAYMENT,
			Request::TERMINAL_TYPE_INSTALMENT,
		];

		$this->validateInput(Request::ATTRIBUTE_TERMINAL_TYPE, $terminalType, $validValues);

		$this->terminalType = $terminalType;

		$this->setAttribute(Request::ATTRIBUTE_TERMINAL_TYPE, $terminalType);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCVC2()
	{
		return $this->cvc2;
	}

	/**
	 * @param string $cvc2
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public function setCVC2($cvc2)
	{
		$this->cvc2 = $cvc2;

		$this->setAttribute(Request::ATTRIBUTE_CVC2, $cvc2);

		return $this;
	}

	/**
	 * @return boolean
	 *
	 * @throws \StGeorgeIPG\Exceptions\InvalidAttributeValueException
	 */
	public function validate()
	{
		$this->validateAttributes([
			Request::ATTRIBUTE_INTERFACE,
			Request::ATTRIBUTE_TRANSACTION_TYPE,
		]);

		$transactionType = $this->getTransactionType();

		switch ($transactionType) {
			case Request::TRANSACTION_TYPE_PURCHASE:
			case Request::TRANSACTION_TYPE_PRE_AUTH: {
				$this->validateAttributes([
					Request::ATTRIBUTE_TOTAL_AMOUNT,
					Request::ATTRIBUTE_CARD_DATA,
					Request::ATTRIBUTE_CARD_EXPIRY_DATE,
				], [
					Request::ATTRIBUTE_TRANSACTION_REFERENCE,
					Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE,
					Request::ATTRIBUTE_PRE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTHORISATION_CODE,
					Request::ATTRIBUTE_AUTHORISATION_NUMBER,
				]);

				break;
			}

			case Request::TRANSACTION_TYPE_REFUND: {
				$this->validateAttributes([
					Request::ATTRIBUTE_TOTAL_AMOUNT,
					Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE,
				], [
					Request::ATTRIBUTE_CARD_DATA,
					Request::ATTRIBUTE_CARD_EXPIRY_DATE,
					Request::ATTRIBUTE_TRANSACTION_REFERENCE,
					Request::ATTRIBUTE_PRE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTHORISATION_CODE,
					Request::ATTRIBUTE_AUTHORISATION_NUMBER,
				]);

				break;
			}

			case Request::TRANSACTION_TYPE_COMPLETION: {
				$this->validateAttributes([
					Request::ATTRIBUTE_TOTAL_AMOUNT, [
						Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE,
						Request::ATTRIBUTE_PRE_AUTH_NUMBER,
					], [
						Request::ATTRIBUTE_AUTH_CODE,
						Request::ATTRIBUTE_AUTH_NUMBER,
						Request::ATTRIBUTE_AUTHORISATION_CODE,
						Request::ATTRIBUTE_AUTHORISATION_NUMBER,
					],
				], [
					Request::ATTRIBUTE_CARD_DATA,
					Request::ATTRIBUTE_CARD_EXPIRY_DATE,
					Request::ATTRIBUTE_TRANSACTION_REFERENCE,
				]);

				break;
			}

			case Request::TRANSACTION_TYPE_STATUS: {
				$this->validateAttributes([
					Request::ATTRIBUTE_TRANSACTION_REFERENCE,
				], [
					Request::ATTRIBUTE_TOTAL_AMOUNT,
					Request::ATTRIBUTE_TAX_AMOUNT,
					Request::ATTRIBUTE_CARD_DATA,
					Request::ATTRIBUTE_CARD_EXPIRY_DATE,
					Request::ATTRIBUTE_ORIGINAL_TRANSACTION_REFERENCE,
					Request::ATTRIBUTE_PRE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTH_CODE,
					Request::ATTRIBUTE_AUTH_NUMBER,
					Request::ATTRIBUTE_AUTHORISATION_CODE,
					Request::ATTRIBUTE_AUTHORISATION_NUMBER,
					Request::ATTRIBUTE_CLIENT_REFERENCE,
					Request::ATTRIBUTE_COMMENT,
					Request::ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME,
					Request::ATTRIBUTE_MERCHANT_DESCRIPTION,
					Request::ATTRIBUTE_TERMINAL_TYPE,
					Request::ATTRIBUTE_CVC2,
				]);

				break;
			}
		}

		return TRUE;
	}

	/**
	 * @return mixed
	 */
	private function createWebpayReference()
	{
		return $this->getWebpay()->createBundle();
	}

	/**
	 * @param array $mandatory
	 * @param array $notAvailable
	 *
	 * @throws \StGeorgeIPG\Exceptions\InvalidAttributeStatusException
	 */
	private function validateAttributes($mandatory = [], $notAvailable = [])
	{
		foreach ($mandatory as $item) {
			if (is_array($item)) {
				$count = 0;

				foreach ($item as $subItem) {
					$resolvedAttribute = $this->resolveAttributeFromMapping($subItem);

					if ($resolvedAttribute !== NULL) {
						$count++;
					}
				}

				if ($count != 1) {
					throw new InvalidAttributeStatusException(join('" or "', $item), 'mandatory');
				}
			} else {
				$resolvedAttribute = $this->resolveAttributeFromMapping($item);

				if ($resolvedAttribute === NULL) {
					throw new InvalidAttributeStatusException($item, 'mandatory');
				}
			}
		}

		foreach ($notAvailable as $item) {
			$resolvedAttribute = $this->resolveAttributeFromMapping($item);

			if ($resolvedAttribute !== NULL) {
				throw new InvalidAttributeStatusException($item, 'not available');
			}
		}
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	private function resolveAttributeFromMapping($name)
	{
		return $this->{Request::$attributeMapping[$name]};
	}

	/**
	 * @param integer $clientId
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setClientId($clientId)
	{
		$this->getWebpay()->setClientId($this->getWebpayReference(), $clientId);

		return $this;
	}

	/**
	 * @param string $certificatePath
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setCertificatePath($certificatePath)
	{
		$this->getWebpay()->setCertificatePath($this->getWebpayReference(), $certificatePath);

		return $this;
	}

	/**
	 * @param string $certificatePassword
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setCertificatePassword($certificatePassword)
	{
		$this->getWebpay()->setCertificatePassword($this->getWebpayReference(), $certificatePassword);

		return $this;
	}

	/**
	 * @param string[] $servers
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setServers($servers)
	{
		$this->getWebpay()->setServers($this->getWebpayReference(), $servers);

		return $this;
	}

	/**
	 * @param integer $port
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setPort($port)
	{
		$this->getWebpay()->setPort($this->getWebpayReference(), $port);

		return $this;
	}

	/**
	 * @param boolean $debug
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setDebug($debug)
	{
		$this->getWebpay()->setAttribute($this->getWebpayReference(), 'DEBUG', ($debug) ? ('ON') : ('OFF'));

		return $this;
	}

	/**
	 * @param string $logFilePath
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setLogPath($logFilePath)
	{
		$this->getWebpay()->setAttribute($this->getWebpayReference(), 'LOGFILE', $logFilePath);

		return $this;
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return \StGeorgeIPG\Client
	 */
	private function setAttribute($name, $value)
	{
		if ($value !== NULL) {
			$this->getWebpay()->setAttribute($this->getWebpayReference(), $name, $value);
		}

		return $this;
	}

	/**
	 * @param \StGeorgeIPG\Client $client
	 * @param boolean             $includeTerminalType
	 *
	 * @return \StGeorgeIPG\Request
	 */
	public static function createFromClient(Client $client, $includeTerminalType = TRUE)
	{
		$request = new Request();

		$request
			->setWebpay($client->getWebpay())
			->setWebpayReference($request->createWebpayReference())
			->setDebug($client->getDebug());

		$logPath = $client->getLogPath();

		if ($logPath) {
			$request
				->setLogPath($logPath);
		}

		$request
			->setClientId($client->getClientId())
			->setCertificatePath($client->getCertificatePath())
			->setCertificatePassword($client->getCertificatePassword())
			->setServers($client->getServers())
			->setPort($client->getPort())
			->setInterface($client->getInterface());

		if($includeTerminalType)
		{
			$request
				->setTerminalType($client->getTerminalType());
		}

		return $request;
	}

	/**
	 * @param double $amount
	 *
	 * @return string
	 */
	private static function formatCurrency($amount)
	{
		return number_format($amount, 2, '.', '');
	}

	/**
	 * @param string $number
	 *
	 * @return string
	 */
	private static function formatCardNumber($number)
	{
		return preg_replace('~\D~', '', $number);
	}

	/**
	 * @param integer $month
	 * @param integer $year
	 *
	 * @return string
	 */
	private static function formatDate($month, $year)
	{
		return sprintf('%02d', strval($month)) . substr(strval($year), 2);
	}

	private static function validateInput($attribute, $input, $validValues)
	{
		if (!is_null($input) && !in_array($input, $validValues, TRUE)) {
			throw new InvalidAttributeValueException($attribute, $input);
		}
	}

	private static function validateInputIsInteger($attribute, $input)
	{
		if (!is_null($input) && !is_int($input)) {
			throw new InvalidAttributeValueException($attribute, $input);
		}
	}

	private static function validateInputIsDouble($attribute, $input)
	{
		if (!is_null($input) && !is_double($input)) {
			throw new InvalidAttributeValueException($attribute, $input);
		}
	}

	private static function validateInputIsCardNumber($input)
	{
		if (!CreditCard::validCreditCard($input)['valid']) {
			throw new InvalidCardDataException('The card data is invalid.');
		}
	}

	private static function validateInputIsCardExpiryDate($month, $year)
	{
		if (!CreditCard::validDate($year, $month)) {
			throw new \InvalidArgumentException('The card expiry date is invalid.');
		}
	}
}