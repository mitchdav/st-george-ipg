<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Exceptions\InvalidAttributeValueException;
use StGeorgeIPG\Exceptions\InvalidCardDataException;

class RequestTest extends TestCase
{
	/**
	 * @covers Request::getWebpayReference
	 * @covers Request::setWebpayReference
	 */
	public function testGetSetWebpayReference_ValidInput_Equals()
	{
		$request = new Request();

		$value = rand(0, 1000);

		$request->setWebpayReference($value);

		$this->assertEquals($value, $request->getWebpayReference());
	}

	/**
	 * @covers Request::getInterface
	 * @covers Request::setInterface
	 */
	public function testGetSetInterface_ValidInput_Equals()
	{
		$request = new Request();

		$value = Request::INTERFACE_CREDIT_CARD;

		$request->setInterface($value);

		$this->assertEquals($value, $request->getInterface());
	}

	/**
	 * @covers Request::setInterface
	 */
	public function testSetInterface_InvalidInput_ThrowException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$value = 'INVALIDINTERFACE';

		$request->setInterface($value);
	}

	/**
	 * @covers Request::isInterfaceCreditCard
	 */
	public function testIsInterfaceCreditCard_ValidInput_True()
	{
		$request = new Request();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD);

		$this->assertTrue($request->isInterfaceCreditCard());
	}

	/**
	 * @covers Request::isInterfaceCreditCard
	 */
	public function testIsInterfaceCreditCard_InvalidInput_False()
	{
		$request = new Request();

		$request->setInterface(Request::INTERFACE_TEST);

		$this->assertFalse($request->isInterfaceCreditCard());
	}

	/**
	 * @covers Request::isInterfaceTest
	 */
	public function testIsInterfaceTest_ValidInput_True()
	{
		$request = new Request();

		$request->setInterface(Request::INTERFACE_TEST);

		$this->assertTrue($request->isInterfaceTest());
	}

	/**
	 * @covers Request::isInterfaceTest
	 */
	public function testIsInterfaceTest_InvalidInput_False()
	{
		$request = new Request();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD);

		$this->assertFalse($request->isInterfaceTest());
	}

	/**
	 * @covers Request::getTransactionType
	 * @covers Request::setTransactionType
	 */
	public function testGetSetTransactionType_ValidInput_Equals()
	{
		$request = new Request();

		$value = Request::TRANSACTION_TYPE_PURCHASE;

		$request->setTransactionType($value);

		$this->assertEquals($value, $request->getTransactionType());
	}

	/**
	 * @covers Request::setTransactionType
	 */
	public function testSetTransactionType_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$value = 'INVALIDTRANSACTIONTYPE';

		$request->setTransactionType($value);
	}

	/**
	 * @covers Request::isTransactionTypePurchase
	 */
	public function testIsTransactionTypePurchase_ValidInput_True()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE);

		$this->assertTrue($request->isTransactionTypePurchase());
	}

	/**
	 * @covers Request::isTransactionTypePurchase
	 */
	public function testIsTransactionTypePurchase_InvalidInput_False()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_REFUND);

		$this->assertFalse($request->isTransactionTypePurchase());
	}

	/**
	 * @covers Request::isTransactionTypeRefund
	 */
	public function testIsTransactionTypeRefund_ValidInput_True()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_REFUND);

		$this->assertTrue($request->isTransactionTypeRefund());
	}

	/**
	 * @covers Request::isTransactionTypeRefund
	 */
	public function testIsTransactionTypeRefund_InvalidInput_False()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH);

		$this->assertFalse($request->isTransactionTypeRefund());
	}

	/**
	 * @covers Request::isTransactionTypePreAuth
	 */
	public function testIsTransactionTypePreAuth_ValidInput_True()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH);

		$this->assertTrue($request->isTransactionTypePreAuth());
	}

	/**
	 * @covers Request::isTransactionTypePreAuth
	 */
	public function testIsTransactionTypePreAuth_InvalidInput_False()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION);

		$this->assertFalse($request->isTransactionTypePreAuth());
	}

	/**
	 * @covers Request::isTransactionTypeCompletion
	 */
	public function testIsTransactionTypeCompletion_ValidInput_True()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION);

		$this->assertTrue($request->isTransactionTypeCompletion());
	}

	/**
	 * @covers Request::isTransactionTypeCompletion
	 */
	public function testIsTransactionTypeCompletion_InvalidInput_False()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_STATUS);

		$this->assertFalse($request->isTransactionTypeCompletion());
	}

	/**
	 * @covers Request::isTransactionTypeStatus
	 */
	public function testIsTransactionTypeStatus_ValidInput_True()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_STATUS);

		$this->assertTrue($request->isTransactionTypeStatus());
	}

	/**
	 * @covers Request::isTransactionTypeStatus
	 */
	public function testIsTransactionTypeStatus_InvalidInput_False()
	{
		$request = new Request();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE);

		$this->assertFalse($request->isTransactionTypeStatus());
	}

	/**
	 * @covers Request::getTotalAmount
	 * @covers Request::setTotalAmount
	 */
	public function testGetSetTotalAmount_ValidInput_Equals()
	{
		$request = new Request();

		$value = rand(0, 1000);

		$request->setTotalAmount($value);

		$this->assertEquals($value, $request->getTotalAmount());
	}

	/**
	 * @covers Request::setTotalAmount
	 */
	public function testSetTotalAmount_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$value = 'INVALIDTOTALAMOUNT';

		$request->setTotalAmount($value);
	}

	/**
	 * @covers Request::getTaxAmount
	 * @covers Request::setTaxAmount
	 */
	public function testGetSetTaxAmount_ValidInput_Equals()
	{
		$request = new Request();

		$value = rand(0, 1000);

		$request->setTaxAmount($value);

		$this->assertEquals($value, $request->getTaxAmount());
	}

	/**
	 * @covers Request::setTaxAmount
	 */
	public function testSetTaxAmount_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$value = 'INVALIDTAXAMOUNT';

		$request->setTaxAmount($value);
	}

	/**
	 * @covers Request::getCardData
	 * @covers Request::setCardData
	 */
	public function testGetSetCardData_ValidInput_Equals()
	{
		$request = new Request();

		$value = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($value, $request->getCardData());
	}

	/**
	 * @covers Request::getCardData
	 * @covers Request::setCardData
	 */
	public function testGetSetCardData_ValidInput_WithDashes_Equals()
	{
		$request = new Request();

		$value = '4242-4242-4242-4242';
		$output = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($output, $request->getCardData());
	}

	/**
	 * @covers Request::getCardData
	 * @covers Request::setCardData
	 */
	public function testGetSetCardData_ValidInput_WithSpaces_Equals()
	{
		$request = new Request();

		$value = '4242 4242 4242 4242';
		$output = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($output, $request->getCardData());
	}

	/**
	 * @covers Request::setCardData
	 */
	public function testSetCardData_InvalidInput_NonNumeric_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = new Request();

		$value = 'INVALIDCARDNUMBER';

		$request->setCardData($value);
	}

	/**
	 * @covers Request::setCardData
	 */
	public function testSetCardData_InvalidInput_InvalidNumber_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = new Request();

		$value = '1234567891234567';

		$request->setCardData($value);
	}

	/**
	 * @covers Request::setCardData
	 */
	public function testSetCardData_InvalidInput_InvalidLength_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = new Request();

		$value = '424242424242424';

		$request->setCardData($value);
	}

	/**
	 * @covers Request::setCardData
	 */
	public function testSetCardData_InvalidInput_InvalidPrefix_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = new Request();

		$value = '1111111111111111';

		$request->setCardData($value);
	}
}