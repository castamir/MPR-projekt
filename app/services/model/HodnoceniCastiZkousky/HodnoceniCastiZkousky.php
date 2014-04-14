<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;



/**
 * @property PrihlasenyTermin $prihlasenyTermin m:hasOne
 * @property TypZkousky $typZkousky m:hasOne
 * @property CastZkousky $castZkousky m:hasOne
 * @property DateTime $hodnocenoDne
 * @property int $body
 */
class HodnoceniCastiZkousky extends BaseEntity
{
	protected function initDefaults()
	{
		$this->hodnocenoDne = new DateTime();
		$this->body = 0;
	}
}
