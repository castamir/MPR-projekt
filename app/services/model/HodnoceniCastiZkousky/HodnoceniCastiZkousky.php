<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;



/**
 * @property PrihlasenyTermin $prihlasenyTermin m:hasOne
 * @property TypZkousky $typZkousky m:hasOne
 * @property CastZkousky $castZkousky m:hasOne
 * @property DateTime $hodnocenoDne
 * @property int|NULL $body
 */
class HodnoceniCastiZkousky extends BaseEntity
{
	const SUCCESS = 'Prospěl';

	const FAILED = 'Neprospěl';

	const PENDING = 'Nezadáno';



	protected function initDefaults()
	{
		$this->hodnocenoDne = new DateTime();
	}



	public function getVysledek()
	{
		if (is_null($this->body)) {
			return self::PENDING;
		}
		if ($this->body < $this->castZkousky->minBodu) {
			return self::FAILED;
		}
		return self::SUCCESS;
	}
}
