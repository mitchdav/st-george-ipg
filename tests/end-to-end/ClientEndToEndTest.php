<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\CardExpiredException;
use StGeorgeIPG\Exceptions\ResponseCodes\CardInvalidException;
use StGeorgeIPG\Exceptions\ResponseCodes\CustomerContactBankException;
use StGeorgeIPG\Exceptions\ResponseCodes\DeclinedSystemErrorException;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;
use StGeorgeIPG\Exceptions\ResponseCodes\InsufficientFundsException;
use StGeorgeIPG\Exceptions\ResponseCodes\LocalErrors\Exception as LocalErrorsException;

class ClientEndToEndTest extends TestCase
{
	/**
	 * @var array $approvedCodes
	 */
	private static $approvedCodes = [
		0,
		8,
		77,
	];

	/**
	 * @var array $specialCodes
	 */
	private static $specialCodes = [
		3  => DeclinedSystemErrorException::class,
		5  => CustomerContactBankException::class,
		31 => CardInvalidException::class,
		33 => CardExpiredException::class,
		51 => InsufficientFundsException::class,
		88 => Exception::class, // This should be an InProgressException but the test gateway returns 0A - IN PROGRESS (TEST TRANSACTION ONLY)
	];

	/**
	 * @return \StGeorgeIPG\Webpay
	 */
	private function createWebpay()
	{
		return new Webpay();
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	private function createClient()
	{
		$clientId            = getenv('IPGCLIENTID');
		$certificatePassword = getenv('IPGCERTIFICATEPASSWORD');

		$client = new Client($clientId, $certificatePassword, $this->createWebpay());

		$client
			->setDebug(TRUE)
			->setPort(Client::PORT_TEST);

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	private function createClientWithBadCredentials()
	{
		$clientId            = 1;
		$certificatePassword = strval(rand(1, 100));

		$client = new Client($clientId, $certificatePassword, $this->createWebpay());

		$client
			->setDebug(TRUE)
			->setPort(Client::PORT_TEST);

		return $client;
	}

	/**
	 * @param integer             $code
	 * @param \StGeorgeIPG\Client $client
	 *
	 * @return \StGeorgeIPG\Response
	 */
	private function createPurchaseWithCode($code, $client = NULL)
	{
		if ($client == NULL) {
			$client = $this->createClient();
		}

		$oneYearAhead = (new Carbon())->addYear();

		$amount          = 10.00 + ($code / 100);
		$cardNumber      = '4111111111111111';
		$month           = $oneYearAhead->month;
		$year            = $oneYearAhead->year;
		$cvc2            = NULL;
		$clientReference = NULL;
		$comment         = 'testPurchase_ValidInput_With' . sprintf('%02d', $code);

		$request = $client->purchase($amount, $cardNumber, $month, $year, $cvc2, $clientReference, $comment);

		return $client->execute($request);
	}

	/**
	 * @return array
	 */
	public static function approvedCodesProvider()
	{
		return array_map(
			function ($code) {
				return [$code];
			},
			ClientEndToEndTest::$approvedCodes
		);
	}

	/**
	 * @return array
	 */
	public static function failedCodesProvider()
	{
		$range = range(1, 99);

		return array_map(
			function ($code) {
				return [$code];
			},
			array_filter($range, function ($code) {
				return !in_array($code, ClientEndToEndTest::$approvedCodes) && !in_array($code, array_keys(ClientEndToEndTest::$specialCodes));
			})
		);
	}

	/**
	 * @return array
	 */
	public static function specialCodesProvider()
	{
		$codes = [];

		foreach (ClientEndToEndTest::$specialCodes as $code => $exception) {
			$codes[] = [$code, $exception];
		}

		return $codes;
	}

	/**
	 * @covers       \StGeorgeIPG\Client::purchase
	 * @covers       \StGeorgeIPG\Client::getResponse
	 * @covers       \StGeorgeIPG\Client::execute
	 * @covers       \StGeorgeIPG\Client::validateResponse
	 *
	 * @dataProvider approvedCodesProvider
	 *
	 * @param integer $code
	 */
	public function testPurchase_ValidInput_WithApproved_Equals($code)
	{
		$response = $this->createPurchaseWithCode($code);

		$this->assertTrue($response->isCodeApproved());
	}

	/**
	 * @covers       \StGeorgeIPG\Client::purchase
	 * @covers       \StGeorgeIPG\Client::getResponse
	 * @covers       \StGeorgeIPG\Client::execute
	 * @covers       \StGeorgeIPG\Client::validateResponse
	 *
	 * @dataProvider failedCodesProvider
	 *
	 * @param integer $code
	 */
	public function testPurchase_ValidInput_WithFailed_ThrowException($code)
	{
		$this->expectException(Exception::class);

		$this->createPurchaseWithCode($code);
	}

	/**
	 * @covers       \StGeorgeIPG\Client::purchase
	 * @covers       \StGeorgeIPG\Client::getResponse
	 * @covers       \StGeorgeIPG\Client::execute
	 * @covers       \StGeorgeIPG\Client::validateResponse
	 *
	 * @dataProvider specialCodesProvider
	 *
	 * @param integer $code
	 * @param string  $exception
	 */
	public function testPurchase_ValidInput_WithSpecial_Equals($code, $exception)
	{
		$this->expectException($exception);

		$this->createPurchaseWithCode($code);
	}

	/**
	 * @covers \StGeorgeIPG\Client::purchase
	 * @covers \StGeorgeIPG\Client::getResponse
	 * @covers \StGeorgeIPG\Client::execute
	 * @covers \StGeorgeIPG\Client::validateResponse
	 */
	public function testPurchase_ValidInput_WithBadCredentials_Equals()
	{
		$this->expectException(LocalErrorsException::class);

		$client = $this->createClientWithBadCredentials();

		$this->createPurchaseWithCode(0, $client);
	}

	/**
	 * @covers \StGeorgeIPG\Client::purchase
	 * @covers \StGeorgeIPG\Client::refund
	 * @covers \StGeorgeIPG\Client::getResponse
	 * @covers \StGeorgeIPG\Client::execute
	 * @covers \StGeorgeIPG\Client::validateResponse
	 */
	public function testPurchaseAndRefund_ValidInput_True()
	{
		$client = $this->createClient();

		$oneYearAhead = (new Carbon())->addYear();

		$amount     = 10.00;
		$cardNumber = '4111111111111111';
		$month      = $oneYearAhead->month;
		$year       = $oneYearAhead->year;

		$purchaseRequest = $client->purchase($amount, $cardNumber, $month, $year);

		$purchaseResponse = $client->execute($purchaseRequest);

		$this->assertTrue($purchaseResponse->isCodeApproved());

		$refundRequest = $client->refund(5.00, $purchaseResponse->getTransactionReference());

		$refundResponse = $client->execute($refundRequest);

		$this->assertTrue($refundResponse->isCodeApproved());
	}
}