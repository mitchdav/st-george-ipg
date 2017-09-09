<?php

namespace StGeorgeIPG;

class WebServiceUnitTest extends TestCase
{
	/**
	 * @covers \StGeorgeIPG\Providers\WebService::getLiveUrl
	 * @covers \StGeorgeIPG\Providers\WebService::setLiveUrl
	 */
	public function testGetSetLiveUrl_ValidInput_Equals()
	{
		$webService = $this->createWebService();

		$value = 'abc';

		$webService->setLiveUrl($value);

		$this->assertEquals($value, $webService->getLiveUrl());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\WebService::getTestUrl
	 * @covers \StGeorgeIPG\Providers\WebService::setTestUrl
	 */
	public function testGetSetTestUrl_ValidInput_Equals()
	{
		$webService = $this->createWebService();

		$value = 'abc';

		$webService->setTestUrl($value);

		$this->assertEquals($value, $webService->getTestUrl());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\WebService::getClientId
	 * @covers \StGeorgeIPG\Providers\WebService::setClientId
	 */
	public function testGetSetClientId_ValidInput_Equals()
	{
		$webService = $this->createWebService();

		$value = rand(1, 1000);

		$webService->setClientId($value);

		$this->assertEquals($value, $webService->getClientId());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\WebService::getAuthenticationToken
	 * @covers \StGeorgeIPG\Providers\WebService::setAuthenticationToken
	 */
	public function testGetSetAuthenticationToken_ValidInput_Equals()
	{
		$webService = $this->createWebService();

		$value = 'token';

		$webService->setAuthenticationToken($value);

		$this->assertEquals($value, $webService->getAuthenticationToken());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\WebService::isLive
	 * @covers \StGeorgeIPG\Providers\WebService::setLive
	 * @covers \StGeorgeIPG\Providers\WebService::isTest
	 * @covers \StGeorgeIPG\Providers\WebService::setTest
	 */
	public function testIsSetLive_ValidInput_Equals()
	{
		$webService = $this->createWebService();

		$webService->setLive();

		$this->assertTrue($webService->isLive());
		$this->assertFalse($webService->isTest());

		$webService->setLive(TRUE);

		$this->assertTrue($webService->isLive());
		$this->assertFalse($webService->isTest());

		$webService->setLive(FALSE);

		$this->assertFalse($webService->isLive());
		$this->assertTrue($webService->isTest());

		$webService->setTest();

		$this->assertFalse($webService->isLive());
		$this->assertTrue($webService->isTest());

		$webService->setTest(TRUE);

		$this->assertFalse($webService->isLive());
		$this->assertTrue($webService->isTest());

		$webService->setTest(FALSE);

		$this->assertTrue($webService->isLive());
		$this->assertFalse($webService->isTest());
	}
}