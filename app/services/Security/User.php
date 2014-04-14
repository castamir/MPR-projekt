<?php


namespace Services\Security;


use Nette\Security\IAuthorizator;
use Nette\Security\User as Usr;



class User extends Usr
{

	/**
	 * Returns current user identity, if any.
	 * @return \App\Tables\Uzivatel|NULL
	 */
	public function getIdentity()
	{
		return parent::getIdentity();
	}



	/**
	 * Is a user in the specified effective role?
	 * @param  string
	 * @return bool
	 */
	public function isInRole($role)
	{
		return in_array($role, $this->getRoles(), TRUE);
	}



	/**
	 * Has a user effective access to the Resource?
	 * If $resource is NULL, then the query applies to all resources.
	 * @param null $resource
	 * @param null|string $privilege
	 * @return bool
	 */
	public function isAllowed($resource = IAuthorizator::ALL, $privilege = Authorizator::PRESENTER)
	{
		foreach ($this->getRoles() as $role) {
			if ($this->getAuthorizator()->isAllowed($role, $resource, $privilege)) {
				return TRUE;
			}
		}

		return FALSE;
	}
}
