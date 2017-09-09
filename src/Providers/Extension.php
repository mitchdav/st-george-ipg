<?php

namespace StGeorgeIPG\Providers;

use StGeorgeIPG\Contracts\Provider;
use StGeorgeIPG\Request;
use StGeorgeIPG\Response;
use StGeorgeIPG\Wrappers\Bundle;

class Extension implements Provider
{
	/**
	 * The default server URL.
	 */
	const SERVER = 'www.gwipg.stgeorge.com.au';

	/**
	 * The port for live transactions.
	 */
	const PORT_LIVE = 3016;

	/**
	 * The port for test transactions.
	 */
	const PORT_TEST = 3017;

	/**
	 * @var integer $livePort
	 */
	private $livePort = Extension::PORT_LIVE;

	/**
	 * @var integer $testPort
	 */
	private $testPort = Extension::PORT_TEST;

	/**
	 * @var integer $clientId
	 */
	private $clientId;

	/**
	 * @var string $authenticationToken
	 */
	private $authenticationToken;

	/**
	 * @var string $certificatePath
	 */
	private $certificatePath = 'cert.cert';

	/**
	 * @var string $certificatePassword
	 */
	private $certificatePassword;

	/**
	 * @var boolean $debug
	 */
	private $debug = FALSE;

	/**
	 * @var string $logFile
	 */
	private $logFile;

	/**
	 * @var string[] $servers
	 */
	private $servers = [
		Extension::SERVER,
	];

	/**
	 * @var bool $live
	 */
	private $live = TRUE;

	/**
	 * @return integer
	 */
	public function getLivePort()
	{
		return $this->livePort;
	}

	/**
	 * @param integer $livePort
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setLivePort($livePort)
	{
		$this->livePort = $livePort;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getTestPort()
	{
		return $this->testPort;
	}

	/**
	 * @param integer $testPort
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setTestPort($testPort)
	{
		$this->testPort = $testPort;

		return $this;
	}

	/**
	 * @return integer
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param integer $clientId
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setClientId($clientId)
	{
		$this->clientId = $clientId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthenticationToken()
	{
		return $this->authenticationToken;
	}

	/**
	 * @param string $authenticationToken
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setAuthenticationToken($authenticationToken)
	{
		$this->authenticationToken = $authenticationToken;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCertificatePath()
	{
		return $this->certificatePath;
	}

	/**
	 * @param string $certificatePath
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setCertificatePath($certificatePath)
	{
		$this->certificatePath = $certificatePath;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCertificatePassword()
	{
		return $this->certificatePassword;
	}

	/**
	 * @param string $certificatePassword
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setCertificatePassword($certificatePassword)
	{
		$this->certificatePassword = $certificatePassword;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDebug()
	{
		return $this->debug;
	}

	/**
	 * @param boolean $debug
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogFile()
	{
		return $this->logFile;
	}

	/**
	 * @param string $logFile
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setLogFile($logFile)
	{
		$this->logFile = $logFile;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getServers()
	{
		return $this->servers;
	}

	/**
	 * @param string[] $servers
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setServers($servers)
	{
		$this->servers = $servers;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isLive()
	{
		return $this->live === TRUE;
	}

	/**
	 * @param boolean $live
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setLive($live = TRUE)
	{
		$this->live = $live;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isTest()
	{
		return !$this->isLive();
	}

	/**
	 * @param boolean $test
	 *
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	public function setTest($test = TRUE)
	{
		$this->setLive(!$test);

		return $this;
	}

	/**
	 * @param \StGeorgeIPG\Request $request
	 * @param boolean              &$canSafelyTryAgain
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function getResponse(Request $request, &$canSafelyTryAgain)
	{
		$requestArray = array_filter($request->toAttributeArray(), function ($item) {
			return $item !== NULL;
		});

		$bundle = new Bundle();

		if ($this->getLogFile()) {
			$directory = dirname($this->getLogFile());

			if (!file_exists($directory)) {
				mkdir($directory, 0640, TRUE);
			}

			$bundle->setAttribute('LOGFILE', $this->getLogFile());
		}

		$bundle->setAttribute('DEBUG', ($this->isDebug()) ? ('ON') : ('OFF'))
		       ->setClientId($this->getClientId())
		       ->setCertificatePath($this->getCertificatePath())
		       ->setCertificatePassword($this->getCertificatePassword())
		       ->setServers($this->getServers())
		       ->setPort(($this->isLive()) ? ($this->getLivePort()) : ($this->getTestPort()));

		if ($this->getAuthenticationToken()) {
			$bundle->setAttribute('AUTHENTICATIONTOKEN', $this->getAuthenticationToken());
		}

		foreach ($requestArray as $attribute => $value) {
			$bundle->setAttribute($attribute, $value);
		}

		$canSafelyTryAgain = !$bundle->executeTransaction();

		$responseArray = [];

		foreach (array_keys(Response::getAttributeMapping()) as $attribute) {
			$responseArray[$attribute] = $bundle->getAttribute($attribute);
		}

		$response = Response::createFromAttributeArray($responseArray);

		return $response;
	}
}