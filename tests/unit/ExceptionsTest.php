<?php

use PHPUnit\Framework\TestCase;

use StGeorgeIPG\Request;
use StGeorgeIPG\Response;

class ExceptionsTest extends TestCase
{
	/**
	 * @covers \StGeorgeIPG\Exceptions\AttributeNotFoundException::__construct
	 */
	public function testAttributeNotFoundExceptionConstructor_ValidInput_Equals()
	{
		$attribute = 'attribute';

		$exception = new \StGeorgeIPG\Exceptions\AttributeNotFoundException($attribute);

		$this->assertEquals('No mappings found for attribute "' . $attribute . '".', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\InvalidAttributeStatusException::__construct
	 */
	public function testInvalidAttributeStatusExceptionConstructor_ValidInput_Equals()
	{
		$attribute = 'attribute';
		$status = 'status';

		$exception = new \StGeorgeIPG\Exceptions\InvalidAttributeStatusException($attribute, $status);

		$this->assertEquals('The attribute "' . $attribute . '" is ' . $status . '.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\InvalidAttributeValueException::__construct
	 */
	public function testInvalidAttributeValueExceptionConstructor_ValidInput_Equals()
	{
		$attribute = 'attribute';
		$value = 'value';

		$exception = new \StGeorgeIPG\Exceptions\InvalidAttributeValueException($attribute, $value);

		$this->assertEquals('The attribute "' . $attribute . '" value "' . $value . '" is invalid.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::__construct
	 */
	public function testTransactionFailedExceptionConstructor_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionFailedException($request, $response, $maxTries);

		$this->assertEquals('Transaction failed after ' . $maxTries . ' tries.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::getRequest
	 */
	public function testTransactionFailedExceptionGetRequest_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionFailedException($request, $response, $maxTries);

		$this->assertEquals($request, $exception->getRequest());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::getResponse
	 */
	public function testTransactionFailedExceptionGetResponse_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionFailedException($request, $response, $maxTries);

		$this->assertEquals($response, $exception->getResponse());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionFailedException::getMaxTries
	 */
	public function testTransactionFailedExceptionGetMaxTries_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionFailedException($request, $response, $maxTries);

		$this->assertEquals($maxTries, $exception->getMaxTries());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::__construct
	 */
	public function testTransactionInProgressExceptionConstructor_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionInProgressException($request, $response, $maxTries);

		$this->assertEquals('Transaction [' . $response->getTransactionReference() . '] was still in progress after ' . $maxTries . ' tries.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::getRequest
	 */
	public function testTransactionInProgressExceptionGetRequest_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionInProgressException($request, $response, $maxTries);

		$this->assertEquals($request, $exception->getRequest());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::getResponse
	 */
	public function testTransactionInProgressExceptionGetResponse_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionInProgressException($request, $response, $maxTries);

		$this->assertEquals($response, $exception->getResponse());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::__construct
	 * @covers \StGeorgeIPG\Exceptions\TransactionInProgressException::getMaxTries
	 */
	public function testTransactionInProgressExceptionGetMaxTries_ValidInput_Equals()
	{
		$request = new Request();
		$response = new Response();
		$maxTries = rand(1, 100);

		$exception = new \StGeorgeIPG\Exceptions\TransactionInProgressException($request, $response, $maxTries);

		$this->assertEquals($maxTries, $exception->getMaxTries());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\WebpayNotLoadedException::__construct
	 */
	public function testWebpayNotLoadedExceptionConstructor_ValidInput_Equals()
	{
		$exception = new \StGeorgeIPG\Exceptions\WebpayNotLoadedException();

		$this->assertEquals('The "webpay" extension must be loaded before the client is initialized.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\ResponseCodes\Exception::__construct
	 */
	public function testResponseCodesExceptionConstructor_ValidInput_Equals()
	{
		$code = rand(1, 50);
		$text = 'ERROR';

		$response = new Response();

		$response
			->setCode($code)
			->setText($text);

		$exception = new \StGeorgeIPG\Exceptions\ResponseCodes\Exception($response);

		$this->assertEquals('Response was ' . $code . ' - ' . $text . '.', $exception->getMessage());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\ResponseCodes\Exception::getResponse
	 */
	public function testResponseCodesExceptionGetResponse_ValidInput_Equals()
	{
		$code = rand(1, 50);
		$text = 'ERROR';

		$response = new Response();

		$response
			->setCode($code)
			->setText($text);

		$exception = new \StGeorgeIPG\Exceptions\ResponseCodes\Exception($response);

		$this->assertEquals($response, $exception->getResponse());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\ResponseCodes\Exception::getResponseCode
	 */
	public function testResponseCodesExceptionGetResponseCode_ValidInput_Equals()
	{
		$code = rand(1, 50);
		$text = 'ERROR';

		$response = new Response();

		$response
			->setCode($code)
			->setText($text);

		$exception = new \StGeorgeIPG\Exceptions\ResponseCodes\Exception($response);

		$this->assertEquals($code, $exception->getResponseCode());
	}

	/**
	 * @covers \StGeorgeIPG\Exceptions\ResponseCodes\Exception::getResponseText
	 */
	public function testResponseCodesExceptionGetResponseText_ValidInput_Equals()
	{
		$code = rand(1, 50);
		$text = 'ERROR';

		$response = new Response();

		$response
			->setCode($code)
			->setText($text);

		$exception = new \StGeorgeIPG\Exceptions\ResponseCodes\Exception($response);

		$this->assertEquals($text, $exception->getResponseText());
	}
}