<?php

namespace StGeorgeIPG;

class ExtensionEndToEndTest extends ClientEndToEndTest
{
	private function checkIfExtensionIsAvailable()
	{
		if (!extension_loaded('webpay')) {
			$this->markTestSkipped('The Webpay extension is not available.');
		}
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	public function createClient()
	{
		$this->checkIfExtensionIsAvailable();

		$clientId            = getenv('IPG_CLIENT_ID');
		$authenticationToken = getenv('IPG_AUTHENTICATION_TOKEN');
		$certificatePassword = getenv('IPG_CERTIFICATE_PASSWORD');
		$certificatePath     = getenv('IPG_CERTIFICATE_PATH');

		if (!$certificatePath) {
			$certificatePath = 'cert.cert';
		}

		$provider = $this->createExtension();

		$provider->setClientId($clientId)
		         ->setAuthenticationToken($authenticationToken)
		         ->setCertificatePassword($certificatePassword)
		         ->setCertificatePath($certificatePath);

		$client = new Client($provider);

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	public function createClientWithBadCredentials()
	{
		$this->checkIfExtensionIsAvailable();

		$clientId            = 1;
		$certificatePassword = 'password';
		$certificatePath     = getenv('IPG_CERTIFICATE_PATH');

		if (!$certificatePath) {
			$certificatePath = 'cert.cert';
		}

		$provider = $this->createExtension();

		$provider->setClientId($clientId)
		         ->setCertificatePassword($certificatePassword)
		         ->setCertificatePath($certificatePath);

		$client = new Client($provider);

		return $client;
	}
}