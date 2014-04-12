<?php

namespace App\AdminModule;

use App\BasePresenter as Presenter;
use Joseki\Form\Form;
use Joseki\LeanMapper\NotFoundException;
use Nette\Security\AuthenticationException;



/**
 * Sign in/out presenters.
 */
class SignPresenter extends Presenter
{

	/** @var \App\Tables\UzivatelRepository @inject */
	public $userRepository;



	public function actionOut()
	{
		$this->getUser()->logout(TRUE);
		$this->flashMessage('Odhlášení proběhlo úspěšně.');
		$this->redirect('in');
	}



	/**
	 * Sign-in form factory.
	 *
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->getElementPrototype()->addAttributes(array('class' => 'login'));
		$form->addText('username', 'Uživatelské jméno:')->setRequired('Zadejte Vaše uživatelské jméno.');

		$form->addPassword('password', 'Heslo:')->setRequired('Zadejte Vaše heslo.');

		$form->addCheckbox('remember', 'Zůstat přihlášen');

		$form->addSubmit('send', 'Přihlásit');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}



	public function signInFormSucceeded(Form $form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('30 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');
		} catch (AuthenticationException $e) {
			$this->flashMessage($e->getMessage());
		}
	}



	/**
	 * @return Form
	 */
	protected function createComponentReset()
	{
		$form = new Form();
		$form->addText('email', 'Email')
			->addRule(Form::FILLED, 'Zajte Vaši emailovou adresu')
			->addRule(Form::EMAIL, 'Zadejte email ve formátu john@domain.ltd');

    $form->addSubmit("send", "Obnovit heslo");
	$form->onSuccess[] = $this->resetSucceeded;

	return $form;
}



	/**
	 * @param Form $form
	 */
	public function resetSucceeded(Form $form)
	{
		try {
			$user = $this->userRepository->findOneBy(array('email' => $form->values->email));
		} catch (NotFoundException $e) {
			$this->flashMessage('Neplatná nebo neexistující emailová adresa');
			$this->redirect('this');
		}

		// TODO new password, encrypt password, save password, send email

		$this->flashMessage('Na emailovou adresu ' . $form->values->email . ' bylo zasláno nové heslo.');
		$this->redirect('this');
	}
}
