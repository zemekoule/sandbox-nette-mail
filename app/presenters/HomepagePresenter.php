<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentEmailForm()
	{
		$form = new Nette\Application\UI\Form();

		$form->addEmail('emailTo', 'Email');
		$form->addTextArea('message', 'Text emailu');
		$form->addSubmit('Odeslat');
		$form->onSuccess[] = [$this, 'emailFormSucceeded'];

		return $form;
	}
}

