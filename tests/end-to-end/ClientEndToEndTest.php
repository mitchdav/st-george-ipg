<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\CardExpiredException;
use StGeorgeIPG\Exceptions\ResponseCodes\CardInvalidException;
use StGeorgeIPG\Exceptions\ResponseCodes\CustomerContactBankException;
use StGeorgeIPG\Exceptions\ResponseCodes\DeclinedSystemErrorException;
use StGeorgeIPG\Exceptions\ResponseCodes\Exception;
use StGeorgeIPG\Exceptions\ResponseCodes\InsufficientFundsException;
use StGeorgeIPG\Exceptions\TransactionInProgressException;

abstract class ClientEndToEndTest extends TestCase
{
	/**
	 * @var array $approvedCodes
	 */
	protected static $approvedCodes = [
		0,
		8,
		77,
	];

	/**
	 * @var array $specialCodes
	 */
	protected static $specialCodes = [
		3  => DeclinedSystemErrorException::class,
		5  => CustomerContactBankException::class,
		31 => CardInvalidException::class,
		33 => CardExpiredException::class,
		51 => InsufficientFundsException::class,
		88 => TransactionInProgressException::class,
		// Here we are testing against the StGeorgeIPG\Exceptions\TransactionInProgressException instead of the StGeorgeIPG\Exceptions\ResponseCodes\InProgressException because the client continues to retry until it exhausts its maximum number of tries, and is a special case
	];

	/**
	 * @return array
	 */
	public static function approvedCodesProvider()
	{
		return array_map(function ($code) {
			return [$code];
		}, ClientEndToEndTest::$approvedCodes);
	}

	/**
	 * @return array
	 */
	public static function failedCodesProvider()
	{
		$range = range(1, 99);

		return array_map(function ($code) {
			return [$code];
		}, array_filter($range, function ($code) {
			return !in_array($code, ClientEndToEndTest::$approvedCodes) && !in_array($code, array_keys(ClientEndToEndTest::$specialCodes));
		}));
	}

	/**
	 * @return array
	 */
	public static function specialCodesProvider()
	{
		$codes = [];

		foreach (ClientEndToEndTest::$specialCodes as $code => $exception) {
			$codes[] = [
				$code,
				$exception,
			];
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

	/**
	 * @return \StGeorgeIPG\Client
	 */
	abstract function createClient();

	/**
	 * @return \StGeorgeIPG\Client
	 */
	abstract function createClientWithBadCredentials();

	/**
	 * @param integer             $code
	 * @param \StGeorgeIPG\Client $client
	 *
	 * @return \StGeorgeIPG\Response
	 */
	protected function createPurchaseWithCode($code, $client = NULL)
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
}