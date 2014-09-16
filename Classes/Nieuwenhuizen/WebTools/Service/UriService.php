<?php
namespace Nieuwenhuizen\WebTools\Service;

use TYPO3\Flow\Annotations as Flow;

/**
 * Class UriService
 *
 * @package Nieuwenhuizen\WebTools\Service
 * @Flow\Scope("singleton")
 */
class UriService {

	/**
	 * @param $uri
	 * @return mixed
	 */
	public function returnUriResponse($uri) {
		$ch = curl_init($uri);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
		curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return json_encode($info);
	}

}