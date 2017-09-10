<?php

namespace StGeorgeIPG;

class ClientUnitTest extends TestCase
{
	/**
	 * @covers \StGeorgeIPG\Client::__construct
	 */
	public function testConstructor_ValidInput_Equals()
	{
		$provider     = $this->createWebServiceMock();
		$terminalType = rand(0, 1000);
		$interface    = rand(0, 1000);

		$client = new Client($provider, $terminalType, $interface);

		$this->assertEquals($provider, $client->getProvider());
		$this->assertEquals($terminalType, $client->getTerminalType());
		$this->assertEquals($interface, $client->getInterface());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getTerminalType
	 * @covers \StGeorgeIPG\Client::setTerminalType
	 */
	public function testGetSetTerminalType_ValidInput_Equals()
	{
		$client = $this->createClientWithWebServiceMock();

		$value = rand(0, 1000);

		$client->setTerminalType($value);

		$this->assertEquals($value, $client->getTerminalType());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getProvider
	 * @covers \StGeorgeIPG\Client::setProvider
	 */
	public function testGetSetProvider_ValidInput_Equals()
	{
		$client = $this->createClientWithWebServiceMock();

		$value = $this->createWebServiceMock();

		$client->setProvider($value);

		$this->assertEquals($value, $client->getProvider());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getInterface
	 * @covers \StGeorgeIPG\Client::setInterface
	 */
	public function testGetSetInterface_ValidInput_Equals()
	{
		$client = $this->createClientWithWebServiceMock();

		$value = rand(0, 1000);

		$client->setInterface($value);

		$this->assertEquals($value, $client->getInterface());
	}

	/**
	 * @covers \StGeorgeIPG\Client::getResponse
	 */
	public function testGetResponse_ValidInput_Equals()
	{
		$client = $this->createClientWithWebServiceMock();

		$value = rand(0, 1000);

		$client->setInterface($value);

		$this->assertEquals($value, $client->getInterface());
	}
}