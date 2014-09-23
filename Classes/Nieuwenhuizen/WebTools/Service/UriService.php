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
		unset($ch,$uri);
		return json_encode($info);
	}

	/**
	 * @param string $uri
	 * @return integer
	 */
	public function getHttpResponse($uri) {
		$urlParts = parse_url($uri);

		$client = new \TYPO3\Flow\Http\Client\CurlEngine();
		$request = new \TYPO3\Flow\Http\Request(array(), array(), array(), array(
			'HTTPS' => isset($urlParts['scheme']) && $urlParts['scheme'] === 'https' ? 'on' : NULL,
			'HTTP_HOST' => $urlParts['host'],
			'REQUEST_URI' => isset($urlParts['query']) ? '?' . $urlParts['query'] : NULL
		));

		return $client->sendRequest($request)->getStatusCode();
	}

}