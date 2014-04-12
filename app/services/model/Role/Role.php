<?php

namespace App\Tables;

use Joseki\LeanMapper\BaseEntity;



/**
 * @property-read string $id
 */
class Role extends BaseEntity
{
	const PROJECT_ADMIN = "Administrátor projektu";

	const USER = "Uživatel";

	const TEACHER = "Zkoušející";
}
