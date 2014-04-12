<?php

namespace Services\Security;

use App\Tables\Uzivatel;
use App\Tables\UzivatelRepository;
use Joseki\LeanMapper\NotFoundException;
use Nette;
use Nette\Utils\Strings;



class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{
	/** @var UzivatelRepository */
	private $userRepository;



	function __construct(UzivatelRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}



	/**
	 * @param array $credentials
	 * @return Uzivatel|Nette\Security\IIdentity
	 * @throws \Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		try {
			$user = $this->userRepository->findOneBy(array("email" => $username, "aktivni" => 1));
		} catch (NotFoundException $e) {
			throw new Nette\Security\AuthenticationException('Neplatné uživatelské jméno nebo heslo.', self::IDENTITY_NOT_FOUND);
		}

		if (!$this->isPasswordValid($password, $user->heslo)) {
			throw new Nette\Security\AuthenticationException('Neplatné uživatelské jméno nebo heslo..', self::INVALID_CREDENTIAL);
		}

		return $user;
	}



	/**
	 * Computes salted password hash.
	 * @param string $password
	 * @param  string $salt To generate a new salted password hash, let $salt = NULL
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		return crypt($password, $salt ? : '$2a$07$' . Strings::random(22));
	}



	/**
	 * @param $password
	 * @param $hash
	 * @return bool
	 */
	private function isPasswordValid($password, $hash)
	{
		return $hash === $this->calculateHash($password, $hash);
	}

}










