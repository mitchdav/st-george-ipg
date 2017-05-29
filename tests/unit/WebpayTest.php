<?php

use PHPUnit\Framework\TestCase;
use StGeorgeIPG\Webpay;

class WebpayTest extends TestCase
{
	/**
	 * @covers \StGeorgeIPG\Webpay::executeTransaction
	 */
	public function testCreateBundle()
	{
		$this->assertNotNull(Webpay::createBundle(), 'This can often mean that your Webpay library was not installed properly.');
	}

	/**
	 * @covers \StGeorgeIPG\Webpay::executeTransaction
	 */
	public function testExecuteTransaction()
	{
		$this->assertFalse(Webpay::executeTransaction(NULL, FALSE));
		$this->assertTrue(Webpay::executeTransaction(NULL, TRUE));
	}
}