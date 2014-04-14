<?php


namespace Services\Security;


use App\Tables\Role;
use Nette\Object;
use Nette\Security\IAuthorizator;



class Authorizator extends Object implements IAuthorizator
{
	const PRESENTER = "presenter";



	/**
	 * @param string $role
	 * @param string $resource full presenter name
	 * @param string $resourceType
	 * @return bool
	 */
	public function isAllowed($role, $resource, $resourceType = self::PRESENTER)
	{

		if ($resourceType === self::PRESENTER) {
			switch ($resource) {
				case ":Admin:Exams:detail":
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
					case ":Admin:Applicant:":
					case ":Admin:Applicant:myExams":
					case ":Admin:Applicant:newExams":
					case ":Admin:Applicant:signIn":
					case ":Admin:Applicant:signOut":
						return TRUE;
				}
			}
		}

		return FALSE;
	}
}
