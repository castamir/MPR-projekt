<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;



/**
 * @property Uzivatel $uzivatel m:hasOne
 * @property Termin $termin m:hasOne
 * @property HodnoceniCastiZkousky[] $hodnoceni m:hasMany(:hodnoceni_casti_zkousky::)
 * @property int $zaplaceno
 * @property DateTime $datumSplatnosti
 */
class PrihlasenyTermin extends BaseEntity
{

	public function getCelkoveHodnoceni()
	{
		if (count($this->hodnoceni) === 0) {
			return HodnoceniCastiZkousky::PENDING;
		}

		foreach ($this->hodnoceni as $dilciVysledek) {
			if ($dilciVysledek === HodnoceniCastiZkousky::PENDING) {
				return HodnoceniCastiZkousky::PENDING;
			}
			if ($dilciVysledek === HodnoceniCastiZkousky::FAILED) {
				return HodnoceniCastiZkousky::FAILED;
			}
		}
		return HodnoceniCastiZkousky::SUCCESS;
	}
}
