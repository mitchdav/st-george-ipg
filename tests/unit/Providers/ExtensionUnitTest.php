<?php

namespace StGeorgeIPG;

class ExtensionUnitTest extends TestCase
{
	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getLivePort
	 * @covers \StGeorgeIPG\Providers\Extension::setLivePort
	 */
	public function testGetSetLivePort_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = rand(1, 1000);

		$extension->setLivePort($value);

		$this->assertEquals($value, $extension->getLivePort());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getTestPort
	 * @covers \StGeorgeIPG\Providers\Extension::setTestPort
	 */
	public function testGetSetTestUrl_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = rand(1, 1000);

		$extension->setTestPort($value);

		$this->assertEquals($value, $extension->getTestPort());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getClientId
	 * @covers \StGeorgeIPG\Providers\Extension::setClientId
	 */
	public function testGetSetClientId_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = rand(1, 1000);

		$extension->setClientId($value);

		$this->assertEquals($value, $extension->getClientId());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getAuthenticationToken
	 * @covers \StGeorgeIPG\Providers\Extension::setAuthenticationToken
	 */
	public function testGetSetAuthenticationToken_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = 'token';

		$extension->setAuthenticationToken($value);

		$this->assertEquals($value, $extension->getAuthenticationToken());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getCertificatePath
	 * @covers \StGeorgeIPG\Providers\Extension::setCertificatePath
	 */
	public function testGetSetCertificatePath_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = 'cert.cert';

		$extension->setCertificatePath($value);

		$this->assertEquals($value, $extension->getCertificatePath());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getCertificatePassword
	 * @covers \StGeorgeIPG\Providers\Extension::setCertificatePassword
	 */
	public function testGetSetCertificatePassword_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = 'password';

		$extension->setCertificatePassword($value);

		$this->assertEquals($value, $extension->getCertificatePassword());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::isDebug
	 * @covers \StGeorgeIPG\Providers\Extension::setDebug
	 */
	public function testIsSetDebug_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$extension->setDebug(TRUE);

		$this->assertTrue($extension->isDebug());

		$extension->setDebug(FALSE);

		$this->assertFalse($extension->isDebug());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getLogFile
	 * @covers \StGeorgeIPG\Providers\Extension::setLogFile
	 */
	public function testGetSetLogFile_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = 'webpay.log';

		$extension->setLogFile($value);

		$this->assertEquals($value, $extension->getLogFile());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::getServers
	 * @covers \StGeorgeIPG\Providers\Extension::setServers
	 */
	public function testGetSetServers_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$value = [
			'server1',
			'server2',
		];

		$extension->setServers($value);

		$this->assertEquals($value, $extension->getServers());
	}

	/**
	 * @covers \StGeorgeIPG\Providers\Extension::isLive
	 * @covers \StGeorgeIPG\Providers\Extension::setLive
	 * @covers \StGeorgeIPG\Providers\Extension::isTest
	 * @covers \StGeorgeIPG\Providers\Extension::setTest
	 */
	public function testIsSetLive_ValidInput_Equals()
	{
		$extension = $this->createExtension();

		$extension->setLive();

		$this->assertTrue($extension->isLive());
		$this->assertFalse($extension->isTest());

		$extension->setLive(TRUE);

		$this->assertTrue($extension->isLive());
		$this->assertFalse($extension->isTest());

		$extension->setLive(FALSE);

		$this->assertFalse($extension->isLive());
		$this->assertTrue($extension->isTest());

		$extension->setTest();

		$this->assertFalse($extension->isLive());
		$this->assertTrue($extension->isTest());

		$extension->setTest(TRUE);

		$this->assertFalse($extension->isLive());
		$this->assertTrue($extension->isTest());

		$extension->setTest(FALSE);

		$this->assertTrue($extension->isLive());
		$this->assertFalse($extension->isTest());
	}
}