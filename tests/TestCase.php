<?php

namespace StGeorgeIPG;

use StGeorgeIPG\Providers\Extension;
use StGeorgeIPG\Providers\WebService;

class TestCase extends \PHPUnit\Framework\TestCase
{
	/**
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	protected function createExtensionMock()
	{
		$builder = $this->getMockBuilder(Extension::class);

		/** @var Extension $extension */
		$extension = $builder->disableOriginalConstructor()
		                     ->getMock();

		return $extension;
	}

	/**
	 * @return \StGeorgeIPG\Providers\WebService
	 */
	protected function createWebServiceMock()
	{
		$builder = $this->getMockBuilder(WebService::class);

		/** @var WebService $webService */
		$webService = $builder->getMock();

		return $webService;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	protected function createClientWithExtensionMock()
	{
		$client = new Client($this->createExtensionMock());

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Client
	 */
	protected function createClientWithWebServiceMock()
	{
		$client = new Client($this->createWebServiceMock());

		return $client;
	}

	/**
	 * @return \StGeorgeIPG\Request
	 */
	protected function createRequest()
	{
		$request = new Request();

		return $request;
	}

	/**
	 * @return \StGeorgeIPG\Response
	 */
	protected function createResponse()
	{
		$response = new Response();

		return $response;
	}

	/**
	 * @return \StGeorgeIPG\Providers\WebService
	 */
	protected function createWebService()
	{
		$webService = new WebService();

		$webService->setTest();

		return $webService;
	}

	/**
	 * @return \StGeorgeIPG\Providers\Extension
	 */
	protected function createExtension()
	{
		$extension = new Extension();

		$extension->setTest();

		return $extension;
	}
}