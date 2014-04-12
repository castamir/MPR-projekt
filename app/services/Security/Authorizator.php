<?php


namespace Services\Security;


use App\Tables\Role;
use Nette\Object;
use Nette\Security\IAuthorizator;



class Authorizator extends Object implements IAuthorizator
{

	/**
	 * @param string $role
	 * @param string $resource full presenter name
	 * @param string $privilege
	 * @return bool
	 */
	public function isAllowed($role, $resource, $privilege)
	{

		switch ($resource) {
			case ":Admin:Homepage:default":
			case ":Admin:Settings:default":
			case ":Admin:Sign:in":
			case ":Admin:Sign:out":
			case ":Admin:Sign:passwordRecovery":
				return TRUE;
		}

		if ($role === Role::PROJECT_ADMIN) {
			switch ($resource) {
				case ":Admin:Exams:default":
				case ":Admin:Payments:default":
				case ":Admin:Terms:default":
				case ":Admin:Users:default":
					return TRUE;
			}
		}
		if ($role === Role::TEACHER) {
			switch ($resource) {
				case ":Admin:Examiner:default":
				case ":Admin:Terms:default":
				case ":Admin:Homepage:default":
					return TRUE;
			}
		}
		if ($role === Role::USER) {
			switch ($resource) {
				case ":Admin:Applicant:default":
					return TRUE;
			}
		}

		return FALSE;
	}
}
