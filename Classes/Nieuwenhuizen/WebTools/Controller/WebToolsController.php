<?php
namespace Nieuwenhuizen\WebTools\Controller;

use Nieuwenhuizen\WebTools\Service\UriService;
use TYPO3\Flow\Annotations as Flow;
use \TYPO3\Flow\Mvc\Controller\ActionController;

class WebToolsController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * @Flow\Inject
	 * @var UriService
	 */
	protected $uriService;

	/**
	 * @return void
	 */
	public function indexAction() {
		if ($this->authenticationManager->isAuthenticated()) {
			$this->redirect('list');
		}
	}

	/**
	 * @return void
	 */
	public function logoutAction() {
		$this->authenticationManager->logout();
		$this->redirect('index');
	}

	/**
	 * @return void
	 */
	public function listAction() {
	}

	/**
	 * @return void
	 */
	public function loginAction() {
		try {
			$this->authenticationManager->authenticate();
		} catch (\TYPO3\Flow\Security\Exception\AuthenticationRequiredException $exception) {
			$this->addFlashMessage('Error while attempting to login. Please check your username and password');
		}
		$this->redirect('index');
	}

	/**
	 * @param string $singleUri
	 * @return void
	 */
	public function linkCheckerAction($singleUri = '') {
		if ($singleUri !== '') {
			$uriResponse = $this->uriService->returnUriResponse($singleUri);
			$this->view->assign('uriResponse', json_decode($uriResponse, true));
		}
	}

}