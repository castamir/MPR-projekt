<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;



/**
 * @property Uzivatel $uzivatel m:hasOne
 * @property Termin $termin m:hasOne
 * @property int $zaplaceno
 * @property DateTime $datumSplatnosti
 */
class PrihlasenyTermin extends BaseEntity
{

}
