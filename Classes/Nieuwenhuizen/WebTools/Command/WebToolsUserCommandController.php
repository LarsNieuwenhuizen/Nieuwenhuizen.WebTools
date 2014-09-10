<?php
namespace Nieuwenhuizen\WebTools\Command;

use Nieuwenhuizen\WebTools\Domain\Model\WebToolsUser;
use Nieuwenhuizen\WebTools\Domain\Repository\WebToolsUserRepository;
use TYPO3\Flow\Cli\CommandController;
use TYPO3\Flow\Annotations as Flow;

class WebToolsUserCommandController extends CommandController {

	/**
	 * @var \TYPO3\Flow\Security\AccountFactory
	 * @Flow\Inject
	 */
	protected $accountFactory;

	/**
	 * @var \TYPO3\Flow\Security\AccountRepository
	 * @Flow\Inject
	 */
	protected $accountRepository;

	/**
	 * @var WebToolsUserRepository
	 * @Flow\Inject
	 */
	protected $webToolsUserRepository;

	/**
	 * Create a new WebTools user
	 *
	 * @param string $username
	 * @param string $password
	 * @return void
	 */
	public function createCommand($username, $password) {
		$account = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($username, 'DashboardInterfaceProvider');
		if ($account !== NULL) {
			$this->outputLine('Dashboard user %s already exists', array ($username));
			$this->quit();
		}

		$roles = array('Nieuwenhuizen.WebTools:WebToolsUser');
		$account = $this->accountFactory->createAccountWithPassword($username, $password, $roles, 'WebToolsInterfaceProvider');
		$this->accountRepository->add($account);

		$user = new WebToolsUser();
		$user->addAccount($account);
		$this->webToolsUserRepository->add($user);

		$this->outputLine('WebTools user %s created', array($username));
	}

}