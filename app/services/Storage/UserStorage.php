<?php


namespace Services\Storage;

use App\Tables\Uzivatel;
use App\Tables\UzivatelRepository;
use Nette\Http\Session;
use Nette;
use Nette\Http\UserStorage as NetteHttpUserStorage;
use Nette\Security\IIdentity;
use Services\Security\FakeIdentity;



class UserStorage extends NetteHttpUserStorage
{

	/** @var \App\Tables\UzivatelRepository */
	private $userRepository;



	public function  __construct(Session $sessionHandler, UzivatelRepository $userRepository)
	{
		parent::__construct($sessionHandler);
		$this->userRepository = $userRepository;
	}



	/**
	 * Sets the user identity.
	 * @param \Nette\Security\IIdentity $identity
	 * @return UserStorage Provides a fluent interface
	 */
	public function setIdentity(IIdentity $identity = NULL)
	{
		if ($identity !== NULL) {
			$identity = new FakeIdentity($identity->getId());
		}

		return parent::setIdentity($identity);
	}



	/**
	 * Returns current user identity, if any.
	 * @return IIdentity|NULL
	 */
	public function getIdentity()
	{
		$identity = parent::getIdentity();
		if ($identity instanceof FakeIdentity) {
			return $this->userRepository->get($identity->getId());
		}

		return $identity;
	}

}
