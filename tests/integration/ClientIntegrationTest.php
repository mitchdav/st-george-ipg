<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\InsufficientFundsException;

class ClientIntegrationTest extends TestCase
{
	/**
	 * @return \StGeorgeIPG\Webpay
	 */
	private function createWebpayMock()
	{
		$builder = $this->getMockBuilder(Webpay::class);

		/** @var Webpay $webpay */
		$webpay = $builder
			->disableOriginalConstructor()
			->getMock();

		return $webpay;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	private function createClientWithWebpayMock()
	{
		$client = new Client(1000000000, 'password', $this->createWebpayMock());

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Response
	 */
	private function createResponseWithWebpayMock()
	{
		$response = new Response();

		$response->setWebpay($this->createWebpayMock());

		return $response;
	}

	/**
	 * @covers \StGeorgeIPG\Client::purchase
	 */
	public function testPurchase_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$oneYearAhead = (new Carbon())->addYear();
		$output       = $oneYearAhead->format('my');

		$amount          = 123.45;
		$cardNumber      = '4242424242424242';
		$month           = $oneYearAhead->month;
		$year            = $oneYearAhead->year;
		$cvc2            = rand(100, 999);
		$clientReference = rand(0, 1000);
		$comment         = rand(0, 1000);
		$description     = rand(0, 1000);
		$cardHolderName  = rand(0, 1000);
		$taxAmount       = 67.89;

		$request = $client->purchase($amount, $cardNumber, $month, $year, $cvc2, $clientReference, $comment, $description, $cardHolderName, $taxAmount);

		$this->assertEquals(Request::TRANSACTION_TYPE_PURCHASE, $request->getTransactionType());
		$this->assertEquals($amount, $request->getTotalAmount());
		$this->assertEquals($cardNumber, $request->getCardData());
		$this->assertEquals($output, $request->getCardExpiryDate());
		$this->assertEquals($cvc2, $request->getCVC2());
		$this->assertEquals($clientReference, $request->getClientReference());
		$this->assertEquals($comment, $request->getComment());
		$this->assertEquals($description, $request->getMerchantDescription());
		$this->assertEquals($cardHolderName, $request->getMerchantCardHolderName());
		$this->assertEquals($taxAmount, $request->getTaxAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Client::refund
	 */
	public function testRefund_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$amount                       = 123.45;
		$originalTransactionReference = '123456789';
		$clientReference              = rand(0, 1000);
		$comment                      = rand(0, 1000);
		$description                  = rand(0, 1000);
		$cardHolderName               = rand(0, 1000);
		$taxAmount                    = 67.89;

		$request = $client->refund($amount, $originalTransactionReference, $clientReference, $comment, $description, $cardHolderName, $taxAmount);

		$this->assertEquals(Request::TRANSACTION_TYPE_REFUND, $request->getTransactionType());
		$this->assertEquals($amount, $request->getTotalAmount());
		$this->assertEquals($originalTransactionReference, $request->getOriginalTransactionReference());
		$this->assertEquals($clientReference, $request->getClientReference());
		$this->assertEquals($comment, $request->getComment());
		$this->assertEquals($description, $request->getMerchantDescription());
		$this->assertEquals($cardHolderName, $request->getMerchantCardHolderName());
		$this->assertEquals($taxAmount, $request->getTaxAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Client::preAuth
	 */
	public function testPreAuth_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$oneYearAhead = (new Carbon())->addYear();
		$output       = $oneYearAhead->format('my');

		$amount          = 123.45;
		$cardNumber      = '4242424242424242';
		$month           = $oneYearAhead->month;
		$year            = $oneYearAhead->year;
		$cvc2            = rand(100, 999);
		$clientReference = rand(0, 1000);
		$comment         = rand(0, 1000);
		$description     = rand(0, 1000);
		$cardHolderName  = rand(0, 1000);
		$taxAmount       = 67.89;

		$request = $client->preAuth($amount, $cardNumber, $month, $year, $cvc2, $clientReference, $comment, $description, $cardHolderName, $taxAmount);

		$this->assertEquals(Request::TRANSACTION_TYPE_PRE_AUTH, $request->getTransactionType());
		$this->assertEquals($amount, $request->getTotalAmount());
		$this->assertEquals($cardNumber, $request->getCardData());
		$this->assertEquals($output, $request->getCardExpiryDate());
		$this->assertEquals($cvc2, $request->getCVC2());
		$this->assertEquals($clientReference, $request->getClientReference());
		$this->assertEquals($comment, $request->getComment());
		$this->assertEquals($description, $request->getMerchantDescription());
		$this->assertEquals($cardHolderName, $request->getMerchantCardHolderName());
		$this->assertEquals($taxAmount, $request->getTaxAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Client::completion
	 */
	public function testCompletion_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$amount                       = 123.45;
		$originalTransactionReference = '123456789';
		$authorisationNumber          = rand(0, 1000);
		$clientReference              = rand(0, 1000);
		$comment                      = rand(0, 1000);
		$description                  = rand(0, 1000);
		$cardHolderName               = rand(0, 1000);
		$taxAmount                    = 67.89;

		$request = $client->completion($amount, $originalTransactionReference, $authorisationNumber, $clientReference, $comment, $description, $cardHolderName, $taxAmount);

		$this->assertEquals(Request::TRANSACTION_TYPE_COMPLETION, $request->getTransactionType());
		$this->assertEquals($amount, $request->getTotalAmount());
		$this->assertEquals($originalTransactionReference, $request->getOriginalTransactionReference());
		$this->assertEquals($authorisationNumber, $request->getAuthorisationNumber());
		$this->assertEquals($clientReference, $request->getClientReference());
		$this->assertEquals($comment, $request->getComment());
		$this->assertEquals($description, $request->getMerchantDescription());
		$this->assertEquals($cardHolderName, $request->getMerchantCardHolderName());
		$this->assertEquals($taxAmount, $request->getTaxAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Client::status
	 */
	public function testStatus_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$transactionReference = '123456789';

		$request = $client->status($transactionReference);

		$this->assertEquals(Request::TRANSACTION_TYPE_STATUS, $request->getTransactionType());
		$this->assertEquals($transactionReference, $request->getTransactionReference());
	}

	/**
	 * @covers \StGeorgeIPG\Client::validateResponse
	 */
	public function testValidateResponse_ValidInput_WithApproved_Equals()
	{
		$client   = $this->createClientWithWebpayMock();
		$response = $this->createResponseWithWebpayMock();

		$response->setCode(Response::CODE_00);

		$this->assertEquals($response, $client->validateResponse($response));
	}

	/**
	 * @covers \StGeorgeIPG\Client::validateResponse
	 */
	public function testValidateResponse_ValidInput_WithInsufficientFunds_ThrowException()
	{
		$this->expectException(InsufficientFundsException::class);

		$client   = $this->createClientWithWebpayMock();
		$response = $this->createResponseWithWebpayMock();

		$response->setCode(Response::CODE_51);

		$client->validateResponse($response);
	}
}