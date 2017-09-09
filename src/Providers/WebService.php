<?php

namespace StGeorgeIPG\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Sabre\Xml\Service;
use StGeorgeIPG\Contracts\Provider;
use StGeorgeIPG\Request;
use StGeorgeIPG\Response;

/**
 * Class WebService
 * @package StGeorgeIPG\Providers
 */
class WebService implements Provider
{
	/**
	 * The URL for live transactions.
	 */
	const URL_LIVE = 'https://www.ipg.stgeorge.com.au/WebServiceAPI/service/transaction';

	/**
	 * The URL for test transactions.
	 */
	const URL_TEST = 'https://www.ipg.stgeorge.com.au/WebServiceAPI/service/testtransaction';

	/**
	 * @var string $liveUrl
	 */
	private $liveUrl = WebService::URL_LIVE;

	/**
	 * @var string $testUrl
	 */
	private $testUrl = WebService::URL_TEST;

	/**
	 * @var integer $clientId
	 */
	private $clientId;

	/**
	 * @var string $authenticationToken
	 */
	private $authenticationToken;

	/**
	 * @var bool $live
	 */
	private $live = TRUE;

	/**
	 * @return string
	 */
	public function getLiveUrl()
	{
		return $this->liveUrl;
	}

	/**
	 * @param string $liveUrl
	 *
	 * @return \StGeorgeIPG\Providers\WebService
	 */
	public function setLiveUrl($liveUrl)
	{
		$this->liveUrl = $liveUrl;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTestUrl()
	{
		return $this->testUrl;
	}

	/**
	 * @param string $testUrl
	 *
	 * @return \StGeorgeIPG\Providers\WebService
	 */
	public function setTestUrl($testUrl)
	{
		$this->testUrl = $testUrl;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param int $clientId
	 *
	 * @return \StGeorgeIPG\Providers\WebService
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
	 * @return \StGeorgeIPG\Providers\WebService
	 */
	public function setAuthenticationToken($authenticationToken)
	{
		$this->authenticationToken = $authenticationToken;

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
	 * @return \StGeorgeIPG\Providers\WebService
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
	 * @return \StGeorgeIPG\Providers\WebService
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
		$url = ($this->isLive()) ? ($this->getLiveUrl()) : ($this->getTestUrl());

		$client = new Client([
			'base_uri' => $url,
		]);

		try {
			$requestArray = array_change_key_case(array_filter($request->toAttributeArray(), function ($item) {
				return $item !== NULL;
			}), CASE_LOWER);

			$requestArray['clientid']            = $this->getClientId();
			$requestArray['authenticationtoken'] = $this->getAuthenticationToken();

			$ns = '{}';

			$xmlService = new Service();

			$xmlService->elementMap = [
				$ns . 'transaction' => function (\Sabre\Xml\Reader $reader) {
					return \Sabre\Xml\Deserializer\keyValue($reader);
				},
			];

			$xml = $xmlService->write('transaction', $requestArray);

			$httpResponse = $client->post('', [
				'version' => CURL_HTTP_VERSION_2_0,
				'headers' => [
					'Content-Type' => 'application/xml',
					'Accept'       => 'application/xml',
				],
				'body'    => $xml,
			]);

			$contents = $httpResponse->getBody()
			                         ->getContents();

			$responseArray = [];

			foreach ($xmlService->parse($contents) as $key => $value) {
				if (strpos($key, $ns) === 0) {
					$key = substr($key, 2);
				}

				$responseArray[$key] = $value;
			}

			$response = Response::createFromAttributeArray($responseArray);
		} catch (ClientException $exception) {
			$response = new Response();

			$response->setCode(Response::CODE_LOCAL_ERROR)
			         ->setError('There was an error while connecting to the Web Service.')
			         ->setErrorDetail($exception->getMessage());
		}

		$canSafelyTryAgain = (intval($response->getCode()) < 0);

		return $response;
	}
}