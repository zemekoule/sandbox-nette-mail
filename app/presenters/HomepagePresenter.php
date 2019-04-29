<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/** @var \MailSender @inject */
	public $mailSender;

	public function actionDefault() {
		//set_time_limit(15);

//		header("Content-Type: image/jpg");
//		$test = file_get_contents("https://static.booktook.cz/files/photos/x/a/a19e16c1d32293b46b70827c9591e4049be43944.jpg");
//		print $test;
//		exit;
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentEmailForm()
	{
		$form = new Nette\Application\UI\Form();

		// = $form->addCheckbox('setRandomData', 'Vyplnit náhodná data');
		$form->addEmail('emailTo', 'Email')
			->setRequired('Zadejte email příjemce');
		$form->addText('subject', 'Předmět')
			//->addConditionOn($setRandomDataControl, Form::EQUAL, false)
				->setRequired('Zadejte předmět');
		$form->addTextArea('message', 'Text emailu')
			//->addConditionOn($setRandomDataControl, Form::EQUAL, false)
				->setRequired('Zadejte text zprávy');
//		$form->addCheckbox('customSettings', 'Odeslat přes vlastní smtp server')
//			->addCondition($form::EQUAL, true)
//			->toggle('emailFrom')
//			->toggle('host')
//			->toggle('username')
//			->toggle('password')
//			->toggle('port')
//			->toggle('secure');
		//$form->addEmail('emailFrom', 'Email odesílatele')
			//->setOption('id', 'emailFrom')
			//->addConditionOn($form['customSettings'], Form::EQUAL, true)
		//		->setRequired('Zadejte email odesílatele');
//		$form->addText('host', 'Host:')
//			->setOption('id', 'host')
			//->addConditionOn($form['customSettings'], Form::EQUAL, true)
				//->setRequired('Zadejte host');
//		$form->addText('username', 'Přihl.jméno')
//			->setOption('id', 'username')
			//->addConditionOn($form['customSettings'], Form::EQUAL, true)
		//		->setRequired('Zadejte přihlašovací jméno');
//		$form->addPassword('password', 'Zadejte heslo')
//			->setOption('id', 'password')
			//->addConditionOn($form['customSettings'], Form::EQUAL, true)
				//->setRequired('Zadejte heslo');
//		$form->addSelect('port', 'Port', [25, 465, 587,])
//			->setOption('id', 'port');
//		$form->addSelect('secure', 'Zabezpečení', ['none', 'ssl', 'tls'])
//			->setOption('id', 'secure');
		$form->addSubmit('Odeslat');
		$form->onSuccess[] = [$this, 'emailFormSucceeded'];

		return $form;
	}

	/**
	 * @param \Nette\Application\UI\Form $form
	 *
	 * @throws \Nette\Application\AbortException
	 */
	public function emailFormSucceeded(Nette\Application\UI\Form $form) {
		$values = $form->getValues();

		$mail = new Nette\Mail\Message();
		$mail->setFrom('noreply@webaplikace.cloud');
		//$mail->setFrom('info@web66.cz');
		$mail->addTo($values->emailTo);
		$mail->setSubject($values->subject);
		$mail->setBody($values->message);



//		if($values->customSettings) {
//			$customSettings = [
//				'host' => $values->host,
//				'username' => $values->username,
//				'password' => $values->password,
//				'port' => $values->port,
//				'secure' => $values->secure,
//			];
//		}
//		else $customSettings = null;

		$this->mailSender->sendEmail($mail);

		$this->flashMessage('Email byl odeslán', 'success');
		$this->redirect('this');
	}

}

