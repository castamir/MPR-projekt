<?php

namespace App\FrontModule;

use App\Tables\Role;
use App\Tables\Uzivatel;
use Joseki\Form\Form;
use Joseki\LeanMapper\NotFoundException;



class RegistrationPresenter extends BasePresenter
{
	/** @var \App\Tables\UzivatelRepository @inject */
	public $userRepository;




	/**
	 * @return Form
	 */
	protected function createComponentRegister()
	{
		$form = new Form();
		$form->addText('email', 'Email')
			->addRule(Form::FILLED, 'Zadejte Vaši emailovou adresu (bude sloužit k přihlášení)')
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
		$this->userRepository->persist($uzivatel);
		$uzivatel->addToRole(Role::USER);
		$this->userRepository->persist($uzivatel);

		// todo poslat verifikacni mail

		$this->redirect('this');
	}



	public function actionVerify($hash)
	{
		$this->setView('failed');
		$this->setView('successfull');
	}
}
