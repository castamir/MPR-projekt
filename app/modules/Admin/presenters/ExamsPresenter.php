<?php

namespace App\AdminModule;



use Joseki\LeanMapper\NotFoundException;



class ExamsPresenter extends BasePresenter
{
	/** @var \App\Tables\TerminRepository @inject */
	public $terminRepository;



	public function actionDetail($id)
	{
		try {
			$this->template->termin = $this->terminRepository->get($id);
		} catch (NotFoundException $e) {
			$this->error();
		}

	}
}
