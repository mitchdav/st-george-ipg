<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\InvalidAttributeStatusException;
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

		$value = 123.00;

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

		$value = 123.00;

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

	/**
	 * @covers Request::getCardExpiryDate
	 * @covers Request::setCardExpiryDate
	 */
	public function testGetSetCardExpiryDate_ValidInput_Equals()
	{
		$request = new Request();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year = $oneYearAhead->year;
		$output = $oneYearAhead->format('my');

		$request->setCardExpiryDate($month, $year);

		$this->assertEquals($output, $request->getCardExpiryDate());
	}

	/**
	 * @covers Request::setCardExpiryDate
	 */
	public function testSetCardExpiryDate_InvalidInput_WithText_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$month = 'December';
		$year = 'Two Thousand';

		$request->setCardExpiryDate($month, $year);
	}

	/**
	 * @covers Request::setCardExpiryDate
	 */
	public function testSetCardExpiryDate_InvalidInput_WithPastDate_ExpectException()
	{
		$this->expectException(\InvalidArgumentException::class);

		$request = new Request();

		$oneYearBehind = (new Carbon())->subYear();

		$month = $oneYearBehind->month;
		$year = $oneYearBehind->year;
		$output = $oneYearBehind->format('my');

		$request->setCardExpiryDate($month, $year);
	}

	/**
	 * @covers Request::getTransactionReference
	 * @covers Request::setTransactionReference
	 */
	public function testGetSetTransactionReference_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDREFERENCE';

		$request->setTransactionReference($value);

		$this->assertEquals($value, $request->getTransactionReference());
	}

	/**
	 * @covers Request::getOriginalTransactionReference
	 * @covers Request::setOriginalTransactionReference
	 */
	public function testGetSetOriginalTransactionReference_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDREFERENCE';

		$request->setOriginalTransactionReference($value);

		$this->assertEquals($value, $request->getOriginalTransactionReference());
	}

	/**
	 * @covers Request::getPreAuthNumber
	 * @covers Request::setPreAuthNumber
	 */
	public function testGetSetPreAuthNumber_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDPREAUTHNUMBER';

		$request->setPreAuthNumber($value);

		$this->assertEquals($value, $request->getPreAuthNumber());
	}

	/**
	 * @covers Request::getAuthNumber
	 * @covers Request::setAuthNumber
	 */
	public function testGetSetAuthNumber_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDAUTHNUMBER';

		$request->setAuthNumber($value);

		$this->assertEquals($value, $request->getAuthNumber());
	}

	/**
	 * @covers Request::getAuthorisationNumber
	 * @covers Request::setAuthorisationNumber
	 */
	public function testGetSetAuthorisationNumber_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDAUTHORISATIONNUMBER';

		$request->setAuthorisationNumber($value);

		$this->assertEquals($value, $request->getAuthorisationNumber());
	}

	/**
	 * @covers Request::getAuthCode
	 * @covers Request::setAuthCode
	 */
	public function testGetSetAuthCode_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDAUTHCODE';

		$request->setAuthCode($value);

		$this->assertEquals($value, $request->getAuthCode());
	}

	/**
	 * @covers Request::getAuthorisationCode
	 * @covers Request::setAuthorisationCode
	 */
	public function testGetSetAuthorisationCode_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDAUTHORISATIONCODE';

		$request->setAuthorisationCode($value);

		$this->assertEquals($value, $request->getAuthorisationCode());
	}

	/**
	 * @covers Request::getClientReference
	 * @covers Request::setClientReference
	 */
	public function testGetSetClientReference_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDREFERENCE';

		$request->setClientReference($value);

		$this->assertEquals($value, $request->getClientReference());
	}

	/**
	 * @covers Request::getComment
	 * @covers Request::setComment
	 */
	public function testGetSetComment_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDCOMMENT';

		$request->setComment($value);

		$this->assertEquals($value, $request->getComment());
	}

	/**
	 * @covers Request::getMerchantCardHolderName
	 * @covers Request::setMerchantCardHolderName
	 */
	public function testGetSetMerchantCardHolderName_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDMERCHANTCARDHOLDERNAME';

		$request->setMerchantCardHolderName($value);

		$this->assertEquals($value, $request->getMerchantCardHolderName());
	}

	/**
	 * @covers Request::getMerchantDescription
	 * @covers Request::setMerchantDescription
	 */
	public function testGetSetMerchantDescription_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDMERCHANTDESCRIPTION';

		$request->setMerchantDescription($value);

		$this->assertEquals($value, $request->getMerchantDescription());
	}

	/**
	 * @covers Request::getTerminalType
	 * @covers Request::setTerminalType
	 */
	public function testGetSetTerminalType_ValidInput_Equals()
	{
		$request = new Request();

		$value = Request::TERMINAL_TYPE_INTERNET;

		$request->setTerminalType($value);

		$this->assertEquals($value, $request->getTerminalType());
	}

	/**
	 * @covers Request::setTerminalType
	 */
	public function testSetTerminalType_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = new Request();

		$value = 'INVALIDTERMINALTYPE';

		$request->setTerminalType($value);
	}

	/**
	 * @covers Request::isTerminalTypeInternet
	 */
	public function testIsTerminalTypeInternet_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_INTERNET);

		$this->assertTrue($request->isTerminalTypeInternet());
	}

	/**
	 * @covers Request::isTerminalTypeInternet
	 */
	public function testIsTerminalTypeInternet_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_TELEPHONE_ORDER);

		$this->assertFalse($request->isTerminalTypeInternet());
	}

	/**
	 * @covers Request::isTerminalTypeTelephoneOrder
	 */
	public function testIsTerminalTypeTelephoneOrder_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_TELEPHONE_ORDER);

		$this->assertTrue($request->isTerminalTypeTelephoneOrder());
	}

	/**
	 * @covers Request::isTerminalTypeTelephoneOrder
	 */
	public function testIsTerminalTypeTelephoneOrder_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_MAIL_ORDER);

		$this->assertFalse($request->isTerminalTypeTelephoneOrder());
	}

	/**
	 * @covers Request::isTerminalTypeMailOrder
	 */
	public function testIsTerminalTypeMailOrder_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_MAIL_ORDER);

		$this->assertTrue($request->isTerminalTypeMailOrder());
	}

	/**
	 * @covers Request::isTerminalTypeMailOrder
	 */
	public function testIsTerminalTypeMailOrder_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_CUSTOMER_PRESENT);

		$this->assertFalse($request->isTerminalTypeMailOrder());
	}

	/**
	 * @covers Request::isTerminalTypeCustomerPresent
	 */
	public function testIsTerminalTypeCustomerPresent_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_CUSTOMER_PRESENT);

		$this->assertTrue($request->isTerminalTypeCustomerPresent());
	}

	/**
	 * @covers Request::isTerminalTypeCustomerPresent
	 */
	public function testIsTerminalTypeCustomerPresent_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_RECURRING_PAYMENT);

		$this->assertFalse($request->isTerminalTypeCustomerPresent());
	}

	/**
	 * @covers Request::isTerminalTypeRecurringPayment
	 */
	public function testIsTerminalTypeRecurringPayment_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_RECURRING_PAYMENT);

		$this->assertTrue($request->isTerminalTypeRecurringPayment());
	}

	/**
	 * @covers Request::isTerminalTypeRecurringPayment
	 */
	public function testIsTerminalTypeRecurringPayment_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_INSTALMENT);

		$this->assertFalse($request->isTerminalTypeRecurringPayment());
	}

	/**
	 * @covers Request::isTerminalTypeInstalment
	 */
	public function testIsTerminalTypeInstalment_ValidInput_True()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_INSTALMENT);

		$this->assertTrue($request->isTerminalTypeInstalment());
	}

	/**
	 * @covers Request::isTerminalTypeInstalment
	 */
	public function testIsTerminalTypeInstalment_InvalidInput_False()
	{
		$request = new Request();

		$request->setTerminalType(Request::TERMINAL_TYPE_INTERNET);

		$this->assertFalse($request->isTerminalTypeInstalment());
	}

	/**
	 * @covers Request::getCVC2
	 * @covers Request::setCVC2
	 */
	public function testGetSetCVC2_ValidInput_Equals()
	{
		$request = new Request();

		$value = 'VALIDCVC2';

		$request->setCVC2($value);

		$this->assertEquals($value, $request->getCVC2());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_ValidInput_WithPurchase_True()
	{
		$request = new Request();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year = $oneYearAhead->year;

		$request
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
			->setTotalAmount(123.00)
			->setCardData('4242424242424242')
			->setCardExpiryDate($month, $year)
			->setCVC2('123')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_InvalidInput_WithPurchase_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = new Request();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year = $oneYearAhead->year;

		/*
		 * TransactionReference - Not permitted for purchases
		 * CardData - Required for purchases
		 */

		$request
			->setTransactionReference('123456789')
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
			->setTotalAmount(123.00)
			//->setCardData('4242424242424242')
			->setCardExpiryDate($month, $year)
			->setCVC2('123')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$request->validate();
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_ValidInput_WithRefund_True()
	{
		$request = new Request();

		$request
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_REFUND)
			->setTotalAmount(123.00)
			->setOriginalTransactionReference('123456789')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_InvalidInput_WithRefund_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = new Request();

		/*
		 * TransactionReference - Not permitted for purchases
		 * CardData - Not permitted for purchases
		 */

		$request
			->setTransactionReference('123456789')
			->setCardData('4242424242424242')
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_REFUND)
			->setTotalAmount(123.00)
			->setOriginalTransactionReference('123456789')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$request->validate();
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_ValidInput_WithPreAuth_True()
	{
		$request = new Request();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year = $oneYearAhead->year;

		$request
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH)
			->setTotalAmount(123.00)
			->setCardData('4242424242424242')
			->setCardExpiryDate($month, $year)
			->setCVC2('123')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_InvalidInput_WithPreAuth_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = new Request();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year = $oneYearAhead->year;

		/*
		 * TransactionReference - Not permitted for pre auths
		 * CardData - Required for pre auths
		 */

		$request
			->setTransactionReference('123456789')
			->setCardData('4242424242424242')
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH)
			->setTotalAmount(123.00)
			//->setCardData('4242424242424242')
			->setCardExpiryDate($month, $year)
			->setCVC2('123')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$request->validate();
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_ValidInput_WithCompletion_True()
	{
		$request = new Request();

		$request
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION)
			->setTotalAmount(123.00)
			->setOriginalTransactionReference('123456789')
			->setAuthCode('123456789')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_InvalidInput_WithCompletion_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = new Request();

		/*
		 * CardData - Not permitted for completions
		 * OriginalTransactionReference - Required for completions
		 */

		$request
			->setCardData('4242424242424242')
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION)
			->setTotalAmount(123.00)
			//->setOriginalTransactionReference('123456789')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$request->validate();
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_ValidInput_WithStatus_True()
	{
		$request = new Request();

		$request
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_STATUS)
			->setTransactionReference('123456789');

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers Request::validate
	 */
	public function testValidate_InvalidInput_WithStatus_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = new Request();

		/*
		 * TransactionReference - Required for statuses
		 * All fields - Not permitted for statuses
		 */

		$request
			->setCardData('4242424242424242')
			->setInterface(Request::INTERFACE_CREDIT_CARD)
			->setTransactionType(Request::TRANSACTION_TYPE_STATUS)
			->setTotalAmount(123.00)
			->setOriginalTransactionReference('123456789')
			->setClientReference('ABC')
			->setComment('Example Comment')
			->setMerchantDescription('St George IPG')
			->setMerchantCardHolderName('John Smith')
			->setTaxAmount(5.00);

		$request->validate();
	}
}