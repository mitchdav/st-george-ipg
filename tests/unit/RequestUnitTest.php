<?php

namespace StGeorgeIPG;

use Carbon\Carbon;
use StGeorgeIPG\Exceptions\InvalidAttributeStatusException;
use StGeorgeIPG\Exceptions\InvalidAttributeValueException;
use StGeorgeIPG\Exceptions\InvalidCardDataException;

class RequestUnitTest extends TestCase
{

	/**
	 * @covers \StGeorgeIPG\Request::getInterface
	 * @covers \StGeorgeIPG\Request::setInterface
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testGetSetInterface_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = Request::INTERFACE_CREDIT_CARD;

		$request->setInterface($value);

		$this->assertEquals($value, $request->getInterface());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setInterface
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testSetInterface_InvalidInput_ThrowException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$value = 'INVALIDINTERFACE';

		$request->setInterface($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::isInterfaceCreditCard
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsInterfaceCreditCard_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD);

		$this->assertTrue($request->isInterfaceCreditCard());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isInterfaceCreditCard
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsInterfaceCreditCard_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_TEST);

		$this->assertFalse($request->isInterfaceCreditCard());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isInterfaceTest
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsInterfaceTest_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_TEST);

		$this->assertTrue($request->isInterfaceTest());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isInterfaceTest
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsInterfaceTest_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD);

		$this->assertFalse($request->isInterfaceTest());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getTransactionType
	 * @covers \StGeorgeIPG\Request::setTransactionType
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testGetSetTransactionType_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = Request::TRANSACTION_TYPE_PURCHASE;

		$request->setTransactionType($value);

		$this->assertEquals($value, $request->getTransactionType());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setTransactionType
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testSetTransactionType_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$value = 'INVALIDTRANSACTIONTYPE';

		$request->setTransactionType($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypePurchase
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypePurchase_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE);

		$this->assertTrue($request->isTransactionTypePurchase());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypePurchase
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypePurchase_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_REFUND);

		$this->assertFalse($request->isTransactionTypePurchase());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeRefund
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeRefund_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_REFUND);

		$this->assertTrue($request->isTransactionTypeRefund());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeRefund
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeRefund_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH);

		$this->assertFalse($request->isTransactionTypeRefund());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypePreAuth
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypePreAuth_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH);

		$this->assertTrue($request->isTransactionTypePreAuth());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypePreAuth
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypePreAuth_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION);

		$this->assertFalse($request->isTransactionTypePreAuth());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeCompletion
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeCompletion_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION);

		$this->assertTrue($request->isTransactionTypeCompletion());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeCompletion
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeCompletion_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_STATUS);

		$this->assertFalse($request->isTransactionTypeCompletion());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeStatus
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeStatus_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_STATUS);

		$this->assertTrue($request->isTransactionTypeStatus());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTransactionTypeStatus
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTransactionTypeStatus_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE);

		$this->assertFalse($request->isTransactionTypeStatus());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getTotalAmount
	 * @covers \StGeorgeIPG\Request::setTotalAmount
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testGetSetTotalAmount_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 123.00;

		$request->setTotalAmount($value);

		$this->assertEquals($value, $request->getTotalAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setTotalAmount
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testSetTotalAmount_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$value = 'INVALIDTOTALAMOUNT';

		$request->setTotalAmount($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::getTaxAmount
	 * @covers \StGeorgeIPG\Request::setTaxAmount
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testGetSetTaxAmount_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 123.00;

		$request->setTaxAmount($value);

		$this->assertEquals($value, $request->getTaxAmount());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setTaxAmount
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testSetTaxAmount_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$value = 'INVALIDTAXAMOUNT';

		$request->setTaxAmount($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::getCardData
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testGetSetCardData_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($value, $request->getCardData());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getCardData
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testGetSetCardData_ValidInput_WithDashes_Equals()
	{
		$request = $this->createRequest();

		$value  = '4242-4242-4242-4242';
		$output = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($output, $request->getCardData());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getCardData
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testGetSetCardData_ValidInput_WithSpaces_Equals()
	{
		$request = $this->createRequest();

		$value  = '4242 4242 4242 4242';
		$output = '4242424242424242';

		$request->setCardData($value);

		$this->assertEquals($output, $request->getCardData());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testSetCardData_InvalidInput_NonNumeric_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = $this->createRequest();

		$value = 'INVALIDCARDNUMBER';

		$request->setCardData($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testSetCardData_InvalidInput_InvalidNumber_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = $this->createRequest();

		$value = '1234567891234567';

		$request->setCardData($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testSetCardData_InvalidInput_InvalidLength_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = $this->createRequest();

		$value = '424242424242424';

		$request->setCardData($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardData
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testSetCardData_InvalidInput_InvalidPrefix_ExpectException()
	{
		$this->expectException(InvalidCardDataException::class);

		$request = $this->createRequest();

		$value = '1111111111111111';

		$request->setCardData($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::getCardExpiryDate
	 * @covers \StGeorgeIPG\Request::setCardExpiryDate
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testGetSetCardExpiryDate_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$oneYearAhead = (new Carbon())->addYear();

		$month  = $oneYearAhead->month;
		$year   = $oneYearAhead->year;
		$output = $oneYearAhead->format('my');

		$request->setCardExpiryDate($month, $year);

		$this->assertEquals($output, $request->getCardExpiryDate());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardExpiryDate
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testSetCardExpiryDate_InvalidInput_WithText_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$month = 'December';
		$year  = 'Two Thousand';

		$request->setCardExpiryDate($month, $year);
	}

	/**
	 * @covers \StGeorgeIPG\Request::setCardExpiryDate
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testSetCardExpiryDate_InvalidInput_WithPastDate_ExpectException()
	{
		$this->expectException(\InvalidArgumentException::class);

		$request = $this->createRequest();

		$oneYearBehind = (new Carbon())->subYear();

		$month = $oneYearBehind->month;
		$year  = $oneYearBehind->year;

		$request->setCardExpiryDate($month, $year);
	}

	/**
	 * @covers \StGeorgeIPG\Request::getTransactionReference
	 * @covers \StGeorgeIPG\Request::setTransactionReference
	 */
	public function testGetSetTransactionReference_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDREFERENCE';

		$request->setTransactionReference($value);

		$this->assertEquals($value, $request->getTransactionReference());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getOriginalTransactionReference
	 * @covers \StGeorgeIPG\Request::setOriginalTransactionReference
	 */
	public function testGetSetOriginalTransactionReference_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDREFERENCE';

		$request->setOriginalTransactionReference($value);

		$this->assertEquals($value, $request->getOriginalTransactionReference());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getPreAuthNumber
	 * @covers \StGeorgeIPG\Request::setPreAuthNumber
	 */
	public function testGetSetPreAuthNumber_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDPREAUTHNUMBER';

		$request->setPreAuthNumber($value);

		$this->assertEquals($value, $request->getPreAuthNumber());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getAuthNumber
	 * @covers \StGeorgeIPG\Request::setAuthNumber
	 */
	public function testGetSetAuthNumber_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDAUTHNUMBER';

		$request->setAuthNumber($value);

		$this->assertEquals($value, $request->getAuthNumber());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getAuthorisationNumber
	 * @covers \StGeorgeIPG\Request::setAuthorisationNumber
	 */
	public function testGetSetAuthorisationNumber_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDAUTHORISATIONNUMBER';

		$request->setAuthorisationNumber($value);

		$this->assertEquals($value, $request->getAuthorisationNumber());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getAuthCode
	 * @covers \StGeorgeIPG\Request::setAuthCode
	 */
	public function testGetSetAuthCode_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDAUTHCODE';

		$request->setAuthCode($value);

		$this->assertEquals($value, $request->getAuthCode());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getAuthorisationCode
	 * @covers \StGeorgeIPG\Request::setAuthorisationCode
	 */
	public function testGetSetAuthorisationCode_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDAUTHORISATIONCODE';

		$request->setAuthorisationCode($value);

		$this->assertEquals($value, $request->getAuthorisationCode());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getClientReference
	 * @covers \StGeorgeIPG\Request::setClientReference
	 */
	public function testGetSetClientReference_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDREFERENCE';

		$request->setClientReference($value);

		$this->assertEquals($value, $request->getClientReference());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getComment
	 * @covers \StGeorgeIPG\Request::setComment
	 */
	public function testGetSetComment_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDCOMMENT';

		$request->setComment($value);

		$this->assertEquals($value, $request->getComment());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getMerchantCardHolderName
	 * @covers \StGeorgeIPG\Request::setMerchantCardHolderName
	 */
	public function testGetSetMerchantCardHolderName_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDMERCHANTCARDHOLDERNAME';

		$request->setMerchantCardHolderName($value);

		$this->assertEquals($value, $request->getMerchantCardHolderName());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getMerchantDescription
	 * @covers \StGeorgeIPG\Request::setMerchantDescription
	 */
	public function testGetSetMerchantDescription_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDMERCHANTDESCRIPTION';

		$request->setMerchantDescription($value);

		$this->assertEquals($value, $request->getMerchantDescription());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getTerminalType
	 * @covers \StGeorgeIPG\Request::setTerminalType
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testGetSetTerminalType_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = Request::TERMINAL_TYPE_INTERNET;

		$request->setTerminalType($value);

		$this->assertEquals($value, $request->getTerminalType());
	}

	/**
	 * @covers \StGeorgeIPG\Request::setTerminalType
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testSetTerminalType_InvalidInput_ExpectException()
	{
		$this->expectException(InvalidAttributeValueException::class);

		$request = $this->createRequest();

		$value = 'INVALIDTERMINALTYPE';

		$request->setTerminalType($value);
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeInternet
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeInternet_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_INTERNET);

		$this->assertTrue($request->isTerminalTypeInternet());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeInternet
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeInternet_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_TELEPHONE_ORDER);

		$this->assertFalse($request->isTerminalTypeInternet());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeTelephoneOrder
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeTelephoneOrder_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_TELEPHONE_ORDER);

		$this->assertTrue($request->isTerminalTypeTelephoneOrder());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeTelephoneOrder
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeTelephoneOrder_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_MAIL_ORDER);

		$this->assertFalse($request->isTerminalTypeTelephoneOrder());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeMailOrder
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeMailOrder_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_MAIL_ORDER);

		$this->assertTrue($request->isTerminalTypeMailOrder());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeMailOrder
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeMailOrder_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_CUSTOMER_PRESENT);

		$this->assertFalse($request->isTerminalTypeMailOrder());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeCustomerPresent
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeCustomerPresent_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_CUSTOMER_PRESENT);

		$this->assertTrue($request->isTerminalTypeCustomerPresent());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeCustomerPresent
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeCustomerPresent_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_RECURRING_PAYMENT);

		$this->assertFalse($request->isTerminalTypeCustomerPresent());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeRecurringPayment
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeRecurringPayment_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_RECURRING_PAYMENT);

		$this->assertTrue($request->isTerminalTypeRecurringPayment());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeRecurringPayment
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeRecurringPayment_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_INSTALMENT);

		$this->assertFalse($request->isTerminalTypeRecurringPayment());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeInstalment
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeInstalment_ValidInput_True()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_INSTALMENT);

		$this->assertTrue($request->isTerminalTypeInstalment());
	}

	/**
	 * @covers \StGeorgeIPG\Request::isTerminalTypeInstalment
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testIsTerminalTypeInstalment_InvalidInput_False()
	{
		$request = $this->createRequest();

		$request->setTerminalType(Request::TERMINAL_TYPE_INTERNET);

		$this->assertFalse($request->isTerminalTypeInstalment());
	}

	/**
	 * @covers \StGeorgeIPG\Request::getCVC2
	 * @covers \StGeorgeIPG\Request::setCVC2
	 */
	public function testGetSetCVC2_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$value = 'VALIDCVC2';

		$request->setCVC2($value);

		$this->assertEquals($value, $request->getCVC2());
	}

	/**
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testValidate_ValidInput_WithPurchase_True()
	{
		$request = $this->createRequest();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year  = $oneYearAhead->year;

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testValidate_InvalidInput_WithPurchase_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = $this->createRequest();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year  = $oneYearAhead->year;

		/*
		 * TransactionReference - Not permitted for purchases
		 * CardData - Required for purchases
		 */

		$request->setTransactionReference('123456789')
		        ->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
		        ->setTotalAmount(123.00)//->setCardData('4242424242424242')
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testValidate_ValidInput_WithRefund_True()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testValidate_InvalidInput_WithRefund_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = $this->createRequest();

		/*
		 * TransactionReference - Not permitted for purchases
		 * CardData - Not permitted for purchases
		 */

		$request->setTransactionReference('123456789')
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testValidate_ValidInput_WithPreAuth_True()
	{
		$request = $this->createRequest();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year  = $oneYearAhead->year;

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::formatDate
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsInteger
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 * @covers \StGeorgeIPG\Request::validateInputIsCardExpiryDate
	 */
	public function testValidate_InvalidInput_WithPreAuth_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = $this->createRequest();

		$oneYearAhead = (new Carbon())->addYear();

		$month = $oneYearAhead->month;
		$year  = $oneYearAhead->year;

		/*
		 * TransactionReference - Not permitted for pre auths
		 * CardData - Required for pre auths
		 */

		$request->setTransactionReference('123456789')
		        ->setCardData('4242424242424242')
		        ->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_PRE_AUTH)
		        ->setTotalAmount(123.00)//->setCardData('4242424242424242')
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 */
	public function testValidate_ValidInput_WithCompletion_True()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
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
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testValidate_InvalidInput_WithCompletion_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = $this->createRequest();

		/*
		 * CardData - Not permitted for completions
		 * OriginalTransactionReference - Required for completions
		 */

		$request->setCardData('4242424242424242')
		        ->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_COMPLETION)
		        ->setTotalAmount(123.00)//->setOriginalTransactionReference('123456789')
		        ->setClientReference('ABC')
		        ->setComment('Example Comment')
		        ->setMerchantDescription('St George IPG')
		        ->setMerchantCardHolderName('John Smith')
		        ->setTaxAmount(5.00);

		$request->validate();
	}

	/**
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::validateInput
	 */
	public function testValidate_ValidInput_WithStatus_True()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_STATUS)
		        ->setTransactionReference('123456789');

		$this->assertTrue($request->validate());
	}

	/**
	 * @covers \StGeorgeIPG\Request::validate
	 * @covers \StGeorgeIPG\Request::validateAttributes
	 * @covers \StGeorgeIPG\Request::resolveAttributeFromMapping
	 * @covers \StGeorgeIPG\Request::formatCurrency
	 * @covers \StGeorgeIPG\Request::formatCardNumber
	 * @covers \StGeorgeIPG\Request::validateInput
	 * @covers \StGeorgeIPG\Request::validateInputIsDouble
	 * @covers \StGeorgeIPG\Request::validateInputIsCardNumber
	 */
	public function testValidate_InvalidInput_WithStatus_ExpectException()
	{
		$this->expectException(InvalidAttributeStatusException::class);

		$request = $this->createRequest();

		/*
		 * TransactionReference - Required for statuses
		 * All fields - Not permitted for statuses
		 */

		$request->setCardData('4242424242424242')
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

	/**
	 * @covers \StGeorgeIPG\Request::createFromClient
	 */
	public function testCreateFromClient_ValidInput_InstanceOf()
	{
		$client = $this->createClientWithWebServiceMock();

		$request = Request::createFromClient($client);

		$this->assertInstanceOf(Request::class, $request);
	}

	/**
	 * @covers \StGeorgeIPG\Request::toArray
	 * @covers \StGeorgeIPG\Request::getAttributeMapping
	 */
	public function testToArray_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
		        ->setCardData('4242424242424242')
		        ->setCVC2('123')
		        ->setClientReference('ABC')
		        ->setComment('Example Comment')
		        ->setMerchantDescription('St George IPG')
		        ->setMerchantCardHolderName('John Smith')
		        ->setTaxAmount(5.00);

		$attributeMapping = Request::getAttributeMapping();

		$this->assertArraySubset([
			$attributeMapping[Request::ATTRIBUTE_INTERFACE]                 => $request->getInterface(),
			$attributeMapping[Request::ATTRIBUTE_TRANSACTION_TYPE]          => $request->getTransactionType(),
			$attributeMapping[Request::ATTRIBUTE_CARD_DATA]                 => $request->getCardData(),
			$attributeMapping[Request::ATTRIBUTE_CVC2]                      => $request->getCVC2(),
			$attributeMapping[Request::ATTRIBUTE_CLIENT_REFERENCE]          => $request->getClientReference(),
			$attributeMapping[Request::ATTRIBUTE_COMMENT]                   => $request->getComment(),
			$attributeMapping[Request::ATTRIBUTE_MERCHANT_DESCRIPTION]      => $request->getMerchantDescription(),
			$attributeMapping[Request::ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME] => $request->getMerchantCardHolderName(),
		], $request->toArray());
	}

	/**
	 * @covers \StGeorgeIPG\Request::toAttributeArray
	 */
	public function testToAttributeArray_ValidInput_Equals()
	{
		$request = $this->createRequest();

		$request->setInterface(Request::INTERFACE_CREDIT_CARD)
		        ->setTransactionType(Request::TRANSACTION_TYPE_PURCHASE)
		        ->setCardData('4242424242424242')
		        ->setCVC2('123')
		        ->setClientReference('ABC')
		        ->setComment('Example Comment')
		        ->setMerchantDescription('St George IPG')
		        ->setMerchantCardHolderName('John Smith')
		        ->setTaxAmount(5.00);

		$this->assertArraySubset([
			Request::ATTRIBUTE_INTERFACE                 => $request->getInterface(),
			Request::ATTRIBUTE_TRANSACTION_TYPE          => $request->getTransactionType(),
			Request::ATTRIBUTE_CARD_DATA                 => $request->getCardData(),
			Request::ATTRIBUTE_CVC2                      => $request->getCVC2(),
			Request::ATTRIBUTE_CLIENT_REFERENCE          => $request->getClientReference(),
			Request::ATTRIBUTE_COMMENT                   => $request->getComment(),
			Request::ATTRIBUTE_MERCHANT_DESCRIPTION      => $request->getMerchantDescription(),
			Request::ATTRIBUTE_MERCHANT_CARD_HOLDER_NAME => $request->getMerchantCardHolderName(),
		], $request->toAttributeArray());
	}
}