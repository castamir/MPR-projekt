<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;
use LeanMapper\Entity;
use Nette\Security\IIdentity;



/**
 * @property string $email
 * @property string $jmeno
 * @property string $prijmeni
 * @property string $heslo
 * @property Role[] $role m:hasMany
 * @property-read array $roles
 * @property int $aktivni = 0
 * @property string|NULL $titul
 * @property DateTime $datumNarozeni
 * @property string|NULL $mistoNarozeni
 * @property string|NULL $telefon
 * @property string|NULL $vzdelani
 * @property string|NULL $adresaTp
 * @property string|NULL $adresaKorespondencni
 * @property PrihlasenyTermin[] $zkousky m:hasMany
 */
class Uzivatel extends BaseEntity implements IIdentity
{
	/**
	 * Returns the ID of user.
	 * @return mixed
	 */
	public function getId()
	{
		$data = $this->row->getData();
		return $data['id'];
	}



	/**
	 * Returns a list of roles that the user is a member of.
	 * @return array
	 */
	public function getRoles()
	{
		$roles = array();

		/** @var $role Role */
		foreach ($this->role as $role) {
			$roles[] = $role->id;
		}
		return $roles;
	}
}
