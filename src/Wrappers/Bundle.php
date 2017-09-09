<?php

namespace StGeorgeIPG\Wrappers;

use StGeorgeIPG\Exceptions\WebpayNotLoadedException;

/**
 * Class Bundle
 *
 * This class serves as a wrapper for the Webpay library, which helps
 * keep all of the non-IDE-findable functions in a single file.
 *
 * As it just serves as a wrapper, this file is ignored from coverage reporting.
 *
 * @package StGeorgeIPG\Wrappers
 * @codeCoverageIgnore
 */
class Bundle
{
	/**
	 * @var resource $reference
	 */
	private $reference;

	/**
	 * Bundle constructor.
	 *
	 * Checks if the Webpay extension is loaded.
	 *
	 * @throws \StGeorgeIPG\Exceptions\WebpayNotLoadedException
	 */
	public function __construct()
	{
		if (!extension_loaded('webpay')) {
			throw new WebpayNotLoadedException();
		}

		$this->reference = \newBundle();
	}

	/**
	 * @param mixed $reference
	 *
	 * @return boolean
	 */
	public function executeTransaction()
	{
		return \executeTransaction($this->getReference());
	}

	/**
	 * @param integer $clientId
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setClientId($clientId)
	{
		\put_ClientID($this->getReference(), strval($clientId));

		return $this;
	}

	/**
	 * @param string $certificatePath
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setCertificatePath($certificatePath)
	{
		\put_CertificatePath($this->getReference(), realpath($certificatePath));

		return $this;
	}

	/**
	 * @param string $certificatePassword
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setCertificatePassword($certificatePassword)
	{
		\put_CertificatePassword($this->getReference(), $certificatePassword);

		return $this;
	}

	/**
	 * @param string[] $servers
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setServers($servers)
	{
		\setServers($this->getReference(), join(',', $servers));

		return $this;
	}

	/**
	 * @param integer $port
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setPort($port)
	{
		\setPort($this->getReference(), strval($port));

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function getAttribute($name)
	{
		return \get($this->getReference(), $name);
	}

	/**
	 * @param string $name
	 * @param string $value
	 *
	 * @return \StGeorgeIPG\Wrappers\Bundle
	 */
	public function setAttribute($name, $value)
	{
		\put($this->getReference(), $name, $value);

		return $this;
	}

	/**
	 * @return resource
	 */
	private function getReference()
	{
		return $this->reference;
	}
}