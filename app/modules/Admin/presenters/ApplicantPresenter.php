<?php

namespace App\AdminModule;



use App\Tables\PrihlasenyTermin;
use Joseki\LeanMapper\NotFoundException;
use Nette\Forms\Container;
use Nette\Http\Response;
use Nette\Utils\Paginator;
use Nextras\Datagrid\Datagrid;



class ApplicantPresenter extends BasePresenter
{

	/** @var \App\Tables\PrihlasenyTerminRepository @inject */
	public $prihlasenyTerminRepository;

	/** @var \App\Tables\TerminRepository @inject */
	public $terminRepository;



	public function createComponentMyExams()
	{
		$grid = new Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('zacatek', 'Začátek')->enableSort();
		$grid->addColumn('typZkousky', 'Zkouška')->enableSort();
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
		$filters = array(
			'uzivatel' => $this->user->id
		);


		return $this->prihlasenyTerminRepository->getMyExams($filters, $order);
	}



	public function createComponentDoneExams()
	{
		$grid = new Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('zacatek', 'Začátek')->enableSort();
		$grid->addColumn('typZkousky', 'Zkouška')->enableSort();
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
		$filters = array(
			'uzivatel' => $this->user->id
		);


		return $this->prihlasenyTerminRepository->getDoneExams($filters, $order);
	}



	public function createComponentNewExams()
	{
		$grid = new Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('zacatek', 'Začátek')->enableSort();
		$grid->addColumn('typZkousky', 'Zkouška')->enableSort();
		$grid->addColumn('kapacita', 'Obsazenost')->enableSort();
		$grid->addColumn('cena', 'Cena')->enableSort();
		$grid->addColumn('prihlasit', '');

		$grid->setDataSourceCallback($this->getNewExamsDataSource);

		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.datagrid.latte'));
		$grid->addCellsTemplate(__DIR__ . '/../templates/Applicant/@datagrid.cells.latte');
		return $grid;
	}



	public function getNewExamsDataSource($filter, $order, Paginator $paginator = NULL)
	{
		$query = $this->prepareNewExamsDataSource($filter, $order);
		if ($paginator) {
			$query->limit($paginator->getItemsPerPage(), $paginator->getOffset());
		}
		return $this->terminRepository->findBy($query);
	}



	/**
	 * @param $filter
	 * @param $order
	 * @return \Joseki\LeanMapper\Query
	 */
	private function prepareNewExamsDataSource($filter, $order)
	{
		$query = $this->terminRepository->createQueryObject()->where("zacatek > %t", new \DateTime());
		if (count($order)) {
			$query->orderBy(implode(" ", $order));
		}
		return $query;
	}



	public function actionSignOut($id)
	{
		try {
			$this->prihlasenyTerminRepository->findOneBy(array(
				'id' => $id,
				'uzivatel' => $this->user->id
			));
		} catch (NotFoundException $e) {
			$this->error(NULL, Response::S403_FORBIDDEN);
		}
		$this->prihlasenyTerminRepository->delete($id);
		$this->redirect('myExams');
	}



	public function actionSignIn($id)
	{
		try {
			$this->template->termin = $this->terminRepository->get($id);
		} catch (NotFoundException $e) {
			$this->error();
		}
	}
}
