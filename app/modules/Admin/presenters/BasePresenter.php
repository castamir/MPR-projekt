<?php

namespace App\AdminModule;

use App\BasePresenter as Presenter;
use App\Tables\Role;
use Nette\Http\IResponse;



/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Presenter
{


	public function startup()
	{
		parent::startup();
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Sign:in');
		}

		if (!$this->user->isAllowed($this->getAction(TRUE))) {
			$this->error("Nemáte oprávnění pro přístup do této sekce.", IResponse::S403_FORBIDDEN);
		}
	}



	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->isProjectAdmin = $this->user->isInRole(Role::PROJECT_ADMIN);
		$this->template->isUser = $this->user->isInRole(Role::USER);
		$this->template->isTeacher = $this->user->isInRole(Role::TEACHER);
	}
}
