<?php

namespace App\Tables;

use DateTime;
use Joseki\LeanMapper\BaseEntity;



/**
 * @property Uzivatel $zodpovednaOsoba m:hasOne(zodpovedna_osoba:Uzivatel)
 * @property TypZkousky $typZkousky m:hasOne
 * @property PrihlasenyTermin[] $prihlaseno m:hasMany(:prihlaseny_termin:termin:prihlaseny_termin)
 * @property string $cisloUctu
 * @property string|NULL $poznamka
 * @property int $kapacita
 * @property int $cena
 * @property DateTime $vychoziDatumSplatnosti
 * @property DateTime $zacatek
 */
class Termin extends BaseEntity
{

}
