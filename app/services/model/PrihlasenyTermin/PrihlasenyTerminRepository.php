<?php

namespace App\Tables;

use Joseki\LeanMapper\Query;
use Joseki\LeanMapper\Repository;
use DateTime;



/**
 * @method \App\Tables\PrihlasenyTermin   get($id)
 * @method \App\Tables\PrihlasenyTermin   findOneBy($condition)
 * @method \App\Tables\PrihlasenyTermin[] findAll($limit = NULL, $offset = NULL)
 * @method \App\Tables\PrihlasenyTermin[] findBy($condition)
 */
class PrihlasenyTerminRepository extends Repository
{
	/**
	 * @param array $filters
	 * @param array $order
	 * @return Query
	 */
	public function getMyExams($filters = array(), $order = array())
	{
		$query = $this->createQueryObject()
			->removeClause('select')->select($this->getTable() . '.*')
			->join('termin')->on('termin.id = ' . $this->getTable() . '.termin')
			->where($filters)
			->where('termin.zacatek > %t', new DateTime());
		if (count($order)) {
			$query->orderBy(implode(" ", $order));
		}
		return $query;
	}



	/**
	 * @param array $filters
	 * @param array $order
	 * @return Query
	 */
	public function getdoneExams($filters = array(), $order = array())
	{
		$query = $this->createQueryObject()
			->removeClause('select')->select($this->getTable() . '.*')
			->join('termin')->on('termin.id = ' . $this->getTable() . '.termin')
			->where($filters)
			->where('termin.zacatek < %t', new DateTime());
		if (count($order)) {
			$query->orderBy(implode(" ", $order));
		}
		return $query;
	}
}
