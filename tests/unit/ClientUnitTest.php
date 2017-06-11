<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\ResponseCodes\InsufficientFundsException;

class ClientUnitTest extends TestCase
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
		$client = new Client(10000000, 'password', $this->createWebpayMock());

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
	 * @covers \StGeorgeIPG\Client::__construct
	 */
	public function testConstructor_ValidInput_Equals()
	{
		$clientId            = 1000000000;
		$certificatePassword = 'password';
		$webpay              = $this->createWebpayMock();
		$certificatePath     = 'cert.cert';
		$debug               = TRUE;
		$logPath             = 'webpay.log';
		$port                = rand(0, 1000);
		$servers             = [
			'server',
		];
		$terminalType        = rand(0, 1000);
		$interface           = rand(0, 1000);

		$client = new Client($clientId, $certificatePassword, $webpay, $certificatePath, $debug, $logPath, $port, $servers, $terminalType, $interface);

		$this->assertEquals($clientId, $client->getClientId());
		$this->assertEquals($certificatePassword, $client->getCertificatePassword());
		$this->assertEquals($webpay, $client->getWebpay());
		$this->assertEquals($certificatePath, $client->getCertificatePath());
		$this->assertEquals($debug, $client->getDebug());
		$this->assertEquals($logPath, $client->getLogPath());
		$this->assertEquals($port, $client->getPort());
		$this->assertEquals($servers, $client->getServers());
		$this->assertEquals($terminalType, $client->getTerminalType());
		$this->assertEquals($interface, $client->getInterface());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getWebpay
	 * @covers \StGeorgeIPG\Client::setWebpay
	 */
	public function testGetSetWebpay_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = $this->createWebpayMock();

		$client->setWebpay($value);

		$this->assertEquals($value, $client->getWebpay());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getClientId
	 * @covers \StGeorgeIPG\Client::setClientId
	 */
	public function testGetSetClientId_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setClientId($value);

		$this->assertEquals($value, $client->getClientId());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getCertificatePath
	 * @covers \StGeorgeIPG\Client::setCertificatePath
	 */
	public function testGetSetCertificatePath_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setCertificatePath($value);

		$this->assertEquals($value, $client->getCertificatePath());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getCertificatePassword
	 * @covers \StGeorgeIPG\Client::setCertificatePassword
	 */
	public function testGetSetCertificatePassword_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setCertificatePassword($value);

		$this->assertEquals($value, $client->getCertificatePassword());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getDebug
	 * @covers \StGeorgeIPG\Client::setDebug
	 */
	public function testGetSetDebug_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setDebug($value);

		$this->assertEquals($value, $client->getDebug());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getLogPath
	 * @covers \StGeorgeIPG\Client::setLogPath
	 */
	public function testGetSetLogPath_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setLogPath($value);

		$this->assertEquals($value, $client->getLogPath());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getServers
	 * @covers \StGeorgeIPG\Client::setServers
	 */
	public function testGetSetServers_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = 'server';

		$client->setServers($value);

		$this->assertEquals([
			$value,
		], $client->getServers());

		$value = [
			'server',
		];

		$client->setServers($value);

		$this->assertEquals($value, $client->getServers());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getPort
	 * @covers \StGeorgeIPG\Client::setPort
	 */
	public function testGetSetPort_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setPort($value);

		$this->assertEquals($value, $client->getPort());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getTerminalType
	 * @covers \StGeorgeIPG\Client::setTerminalType
	 */
	public function testGetSetTerminalType_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setTerminalType($value);

		$this->assertEquals($value, $client->getTerminalType());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getInterface
	 * @covers \StGeorgeIPG\Client::setInterface
	 */
	public function testGetSetInterface_ValidInput_Equals()
	{
		$client = $this->createClientWithWebpayMock();

		$value = rand(0, 1000);

		$client->setInterface($value);

		$this->assertEquals($value, $client->getInterface());
	}
}