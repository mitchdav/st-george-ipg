<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Exceptions\WebpayNotLoadedException;

/**
 * Class Webpay
 *
 * This class serves as a wrapper for the Webpay library, which helps
 * keep all of the non-IDE-findable functions in a single file.
 *
 * @package StGeorgeIPG
 */
class Webpay
{
	/**
	 * Webpay constructor.
	 *
	 * Checks if the Webpay extension is loaded.
	 *
	 * @throws WebpayNotLoadedException
	 */
	public function __construct()
	{
		if (!extension_loaded('webpay')) {
			throw new WebpayNotLoadedException();
		}
	}

	/**
	 * @return mixed
	 */
	public function createBundle()
	{
		return \newBundle();
	}

	/**
	 * @param mixed   $reference
	 *
	 * @return boolean
	 */
	public function executeTransaction($reference)
	{
		return \executeTransaction($reference);
	}

	/**
	 * @param mixed $reference
	 * @param int   $clientId
	 *
	 * @return $this
	 */
	public function setClientId($reference, $clientId)
	{
		\put_ClientID($reference, strval($clientId));

		return $this;
	}

	/**
	 * @param mixed  $reference
	 * @param string $certificatePath
	 *
	 * @return $this
	 */
	public function setCertificatePath($reference, $certificatePath)
	{
		\put_CertificatePath($reference, realpath($certificatePath));

		return $this;
	}

	/**
	 * @param mixed  $reference
	 * @param string $certificatePassword
	 *
	 * @return $this
	 */
	public function setCertificatePassword($reference, $certificatePassword)
	{
		\put_CertificatePassword($reference, $certificatePassword);

		return $this;
	}

	/**
	 * @param mixed    $reference
	 * @param string[] $servers
	 *
	 * @return $this
	 */
	public function setServers($reference, $servers)
	{
		\setServers($reference, join(',', $servers));

		return $this;
	}

	/**
	 * @param mixed   $reference
	 * @param integer $port
	 *
	 * @return $this
	 */
	public function setPort($reference, $port)
	{
		\setPort($reference, strval($port));

		return $this;
	}

	/**
	 * @param mixed  $reference
	 * @param string $name
	 * @param string $value
	 *
	 * @return $this
	 */
	public function setAttribute($reference, $name, $value)
	{
		\put($reference, $name, $value);

		return $this;
	}

	/**
	 * @param mixed  $reference
	 * @param string $name
	 *
	 * @return string
	 */
	public function getAttribute($reference, $name)
	{
		\get($reference, $name);
	}
}