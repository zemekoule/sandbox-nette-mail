<?php declare(strict_types = 1);

use Nette\Mail\Message;

class MailSender {

	/** @var Nette\Application\LinkGenerator */
	private $linkGenerator;

	/** @var Nette\Application\UI\ITemplateFactory */
	private $templateFactory;

	/** @var Nette\Mail\IMailer */
	private $mailer;

	function __construct(Nette\Application\LinkGenerator $generator, Nette\Application\UI\ITemplateFactory $templateFactory, Nette\Mail\IMailer $mailer) {
		$this->linkGenerator = $generator;
		$this->mailer = $mailer;
		$this->templateFactory = $templateFactory;
	}

	public function sendEmail(Message $mail) {

		//$link = $this->linkGenerator->link('Sign:ResetPassword', ['id' => $code]);
		//$body = str_replace('#link#', $link, $emailTemplate->text);

		$template = $this->createTemplate();

		$template->body = $mail->getSubject();
		$template->subject = $mail->getHtmlBody();
		$template->setFile(__DIR__ . '/../presenters/templates/email.latte');

		//$this->mailer->commandArgs = '-finfo@webaplikace.eu';

		$this->mailer->send($mail);

//		if($customSettings) {
//			$mailer = new Nette\Mail\SmtpMailer([
//				'host' => $customSettings['host'],
//				'username' => $customSettings['username'],
//				'password' => $customSettings['password'],
//				'secure' => $customSettings['secure'],
//				'port' => $customSettings['port'],
//			]);
//
//			$mailer->send($mail);
//		}
//		else {
//			$this->mailer->send($mail);
//		}
	}

	protected function createTemplate() {
		$template = $this->templateFactory->createTemplate();
		$template->getLatte()->addProvider('uiControl', $this->linkGenerator);

		return $template;
	}
}
