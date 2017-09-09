<?php

namespace StGeorgeIPG;

class WebServiceEndToEndTest extends ClientEndToEndTest
{
	/**
	 * @return \StGeorgeIPG\Client
	 */
	public function createClient()
	{
		$clientId            = getenv('IPG_CLIENT_ID');
		$authenticationToken = getenv('IPG_AUTHENTICATION_TOKEN');

		$provider = $this->createWebService();

		$provider->setClientId($clientId)
		         ->setAuthenticationToken($authenticationToken);

		$client = new Client($provider);

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	public function createClientWithBadCredentials()
	{
		$clientId            = 1;
		$authenticationToken = 'password';

		$provider = $this->createWebService();

		$provider->setClientId($clientId)
		         ->setAuthenticationToken($authenticationToken);

		$client = new Client($provider);

		return $client;
	}
}