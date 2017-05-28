<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Exceptions\WebpayNotLoadedException;

/**
 * Class Webpay
 *
 * This class serves as a wrapper for the Webpay library, which helps
 * keep all of the non-IDE-findable functions in a single file.
 *
 * TODO: Split up the mocking into its own class.
 *
 * @package StGeorgeIPG
 */
class Webpay
{
	private static $checked = FALSE;

	private static function checkWebpay()
	{
		if (!Webpay::$checked && !extension_loaded('webpay') && getenv('WEBPAY_MOCKED') != TRUE) {
			throw new WebpayNotLoadedException();
		}

		Webpay::$checked = TRUE;
	}

	/**
	 * @return mixed
	 */
	public static function createBundle()
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			return \newBundle();
		} else {
			return rand(0, 10000000);
		}
	}

	/**
	 * @param mixed   $reference
	 * @param boolean $mockedOutput
	 *
	 * @return boolean
	 */
	public static function executeTransaction($reference, $mockedOutput = TRUE)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			return \executeTransaction($reference);
		} else {
			return $mockedOutput;
		}
	}

	/**
	 * @param mixed $reference
	 * @param int   $clientId
	 *
	 * @return void
	 */
	public static function setClientId($reference, $clientId)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\put_ClientID($reference, strval($clientId));
		}
	}

	/**
	 * @param mixed  $reference
	 * @param string $certificatePath
	 *
	 * @return void
	 */
	public static function setCertificatePath($reference, $certificatePath)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\put_CertificatePath($reference, realpath($certificatePath));
		}
	}

	/**
	 * @param mixed  $reference
	 * @param string $certificatePassword
	 *
	 * @return void
	 */
	public static function setCertificatePassword($reference, $certificatePassword)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\put_CertificatePassword($reference, $certificatePassword);
		}
	}

	/**
	 * @param mixed    $reference
	 * @param string[] $servers
	 *
	 * @return void
	 */
	public static function setServers($reference, $servers)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\setServers($reference, join(',', $servers));
		}
	}

	/**
	 * @param mixed   $reference
	 * @param integer $port
	 *
	 * @return void
	 */
	public static function setPort($reference, $port)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\setPort($reference, strval($port));
		}
	}

	/**
	 * @param mixed  $reference
	 * @param string $name
	 * @param string $value
	 *
	 * @return void
	 */
	public static function setAttribute($reference, $name, $value)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\put($reference, $name, $value);
		}
	}

	/**
	 * @param mixed  $reference
	 * @param string $name
	 *
	 * @return string
	 */
	public static function getAttribute($reference, $name)
	{
		Webpay::checkWebpay();

		if (getenv('WEBPAY_MOCKED') != TRUE) {
			\get($reference, $name);
		} else {
			return NULL;
		}
	}
}