<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;
use Nette\Security\IIdentity;



/**
 * @property string $email
 * @property string $jmeno
 * @property string $prijmeni
 * @property string $heslo
 * @property Role[] $roles m:hasMany
 * @property string|NULL $aktivni
 * @property string|NULL $titul
 * @property DateTime $datumNarozeni
 * @property string|NULL $mistoNarozeni
 * @property string|NULL $telefon
 * @property string|NULL $vzdelani
 * @property string|NULL $adresaTp
 * @property string|NULL $adresaKorespondencni
 */
class Uzivatel extends BaseEntity implements IIdentity
{
	/**
	 * Returns the ID of user.
	 * @return mixed
	 */
	function getId()
	{
		$data = $this->row->getData();
		return $data['id'];
	}



	/**
	 * Returns a list of roles that the user is a member of.
	 * @return array
	 */
	function getRoles()
	{
		$data = $this->row->getData();
		return $data['roles'];
	}
}
