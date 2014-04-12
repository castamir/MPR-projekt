<?php

namespace App\FrontModule;

use App\Tables\Role;
use App\Tables\Uzivatel;
use Joseki\Form\Form;
use Joseki\LeanMapper\NotFoundException;



class InstallPresenter extends BasePresenter
{
	/** @var \App\Tables\UzivatelRepository @inject */
	public $userRepository;



	public function actionDefault()
	{
		$admins = $this->userRepository->createQueryObject()->select('uzivatel.*')
			->join('uzivatel_role')
			->on('uzivatel.id = uzivatel_role.uzivatel')
			->where('uzivatel_role.role = %s', Role::PROJECT_ADMIN)->count();
		if ($admins > 0) {
			$this->redirect(':Front:Homepage:');
		}
	}



	/**
	 * @return Form
	 */
	protected function createComponentInstall()
	{
		$form = new Form();
		$form->addText('email', 'Email')
			->addRule(Form::FILLED, 'Zajte Vaši emailovou adresu (bude sloužit k přihlášení)')
			->addRule(callback($this->duplicateEmailValidator), "Zvolený email jej iž obsazen")
			->addRule(Form::EMAIL, 'Zadejte email ve formátu john@domain.ltd');
		$form->addText('jmeno', 'Jméno')->addRule(Form::FILLED, 'Zadejte své jméno');
		$form->addText('prijmeni', 'Příjmení')->addRule(Form::FILLED, 'Zadejte své přjmení');
		$form->addPassword('heslo', 'Heslo')
			->addRule(Form::FILLED, 'Zadejte heslo');
		$form->addPassword('heslo_znovu', 'Heslo znovu')
			->addRule(Form::EQUAL, 'Hesla musí být shodné', $form['heslo']);

		$form->addSubmit("send", "Registrovat");
		$form->onSuccess[] = $this->installSucceeded;

		return $form;
	}



	public function duplicateEmailValidator($item, $arg)
	{
		try {
			$this->userRepository->findOneBy(array("email" => $item->value));
		} catch (NotFoundException $e) {
			return TRUE;
		}
		return FALSE;
	}



	/**
	 * @param Form $form
	 */
	public function installSucceeded(Form $form)
	{
		$values = $form->getValues(TRUE);
		unset ($values['heslo_znovu']);

		$uzivatel = new Uzivatel($values);
		$uzivatel->aktivni = 1;
		$this->userRepository->persist($uzivatel);
		$uzivatel->addToRole(Role::USER);
		$uzivatel->addToRole(Role::PROJECT_ADMIN);
		$this->userRepository->persist($uzivatel);
		$this->redirect('this');
	}
}
