<?php
namespace Nieuwenhuizen\WebTools\Controller;

use TYPO3\Flow\Annotations as Flow;
use \TYPO3\Flow\Mvc\Controller\ActionController;

class WebToolsController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

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

}