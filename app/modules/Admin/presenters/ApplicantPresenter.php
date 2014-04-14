<?php

namespace App\AdminModule;



use App\Tables\PrihlasenyTermin;
use Nette\Forms\Container;
use Nette\Utils\Paginator;
use Nextras\Datagrid\Datagrid;



class ApplicantPresenter extends BasePresenter
{

	/** @var \App\Tables\PrihlasenyTerminRepository @inject */
	public $prihlasenyTerminRepository;



	public function createComponentMyExams()
	{
		$grid = new Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('zacatek', 'Začátek')->enableSort();
		$grid->addColumn('typ', 'Zkouška')->enableSort();
		$grid->addColumn('datumSplatnosti', 'Datum splatnosti')->enableSort();
		$grid->addColumn('akce', '');

		$grid->setDataSourceCallback($this->getMyExamsDataSource);

		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.datagrid.latte'));
		$grid->addCellsTemplate(__DIR__ . '/../templates/Applicant/@datagrid.cells.latte');
		return $grid;
	}



	public function getMyExamsDataSource($filter, $order, Paginator $paginator = NULL)
	{
		$query = $this->prepareMyExamsDataSource($filter, $order);
		if ($paginator) {
			$query->limit($paginator->getItemsPerPage(), $paginator->getOffset());
		}
		return $this->prihlasenyTerminRepository->findBy($query);
	}



	/**
	 * @param $filter
	 * @param $order
	 * @return \Joseki\LeanMapper\Query
	 */
	private function prepareMyExamsDataSource($filter, $order)
	{
		$filters = array();
//		foreach ($filter as $k => $v) {
//			if ($k === 'gender' || is_array($v)) {
//				$filters[$k] = $v;
//			} else {
//				$filters[$k . ' LIKE ?'] = "%$v%";
//			}
//		}


		return $this->prihlasenyTerminRepository->getMyExams($filters, $order);
	}



	public function createComponentDoneExams()
	{
		$grid = new Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('zacatek', 'Začátek')->enableSort();
		$grid->addColumn('typ', 'Zkouška')->enableSort();
		$grid->addColumn('hodnoceni', 'Hodnocení');

		$grid->setDataSourceCallback($this->getDoneExamsDataSource);

		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.datagrid.latte'));
		$grid->addCellsTemplate(__DIR__ . '/../templates/Applicant/@datagrid.cells.latte');
		return $grid;
	}



	public function getDoneExamsDataSource($filter, $order, Paginator $paginator = NULL)
	{
		$query = $this->prepareDoneExamsDataSource($filter, $order);
		if ($paginator) {
			$query->limit($paginator->getItemsPerPage(), $paginator->getOffset());
		}
		return $this->prihlasenyTerminRepository->findBy($query);
	}



	/**
	 * @param $filter
	 * @param $order
	 * @return \Joseki\LeanMapper\Query
	 */
	private function prepareDoneExamsDataSource($filter, $order)
	{
		$filters = array();
//		foreach ($filter as $k => $v) {
//			if ($k === 'gender' || is_array($v)) {
//				$filters[$k] = $v;
//			} else {
//				$filters[$k . ' LIKE ?'] = "%$v%";
//			}
//		}


		return $this->prihlasenyTerminRepository->getDoneExams($filters, $order);
	}
}
