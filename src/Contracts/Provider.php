<?php

namespace StGeorgeIPG\Contracts;

use StGeorgeIPG\Request;

/**
 * Interface Provider
 * @package StGeorgeIPG\Contracts
 */
interface Provider
{
	/**
	 * @return boolean
	 */
	public function isLive();

	/**
	 * @param boolean $live
	 *
	 * @return \StGeorgeIPG\Contracts\Provider
	 */
	public function setLive($live = TRUE);

	/**
	 * @return boolean
	 */
	public function isTest();

	/**
	 * @param boolean $test
	 *
	 * @return \StGeorgeIPG\Contracts\Provider
	 */
	public function setTest($test = TRUE);

	/**
	 * @param \StGeorgeIPG\Request $request
	 * @param boolean              &$canSafelyTryAgain
	 *
	 * @return \StGeorgeIPG\Response
	 */
	public function getResponse(Request $request, &$canSafelyTryAgain);
}