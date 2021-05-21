<?php

namespace App\Services\Mailer;

use Illuminate\Contracts\Mail\Mailable;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\SMTP;

/**
 * Mailer - Classe que dispara um e-mail implementando o PHPMailer como driver
 */
class Mailer
{

    private $mailObject;

    private static $mailer = null;

    /**
     * Recebe uma instância da classe de e-mail do Laravel e realiza o disparo
     *
     * @param  mixed $mail
     * @return void
     */
    public function __construct(Mailable $mail)
    {
        // $this->$mailObject = $mail;
    }



    /**
     * send
     *
     * @param  mixed $mail
     * @return void
     */
    public static function send(Mailable $mail)
    {
        $mail = $mail->build();

        self::configPHPMailer();
        self::setMailSender($mail->from);
        self::setMailReceiver($mail->to, $mail->cc, $mail->bcc);
        self::setMailContent($mail);
        self::$mailer->send();
    }


    /**
     * configPHPMailer
     *
     * @param  mixed $config
     * @return void
     */
    private static function configPHPMailer($config = 'smtp')
    {
        $config = config('mail.mailers.' . $config);

        $view = view('locatarioCadastrado', ['teste' => 'Galgal'])->render();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        if ($config['mailer_debug']) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        }

        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = $config['encryption'];

        $mail->Host = $config['host'];
        $mail->Port = $config['port'];

        self::$mailer = $mail;
    }

    /**
     * setMailSender
     *
     * @param  mixed $senderAddres
     * @param  mixed $senderName
     * @return void
     */
    public static function setMailSender($senderAddres = null, $senderName = null)
    {
        self::$mailer;
        if (empty($senderAddres)) {
            $senderAddres = config('mail.from.address');
            $senderName = config('mail.from.name');
        }

        var_dump($senderAddres);
        self::$mailer->setFrom($senderAddres, $senderName);
        self::$mailer->AddReplyTo($senderAddres, $senderName);
    }

    /**
     * setMailReceiver
     *
     * @param  mixed $receivers
     * @param  mixed $cc
     * @param  mixed $bcc
     * @return void
     */
    private static function setMailReceiver($receivers, $cc  = null, $bcc = null)
    {
        foreach ($receivers as $receiver) {
            if (!empty($receiver['name'])) {
                self::$mailer->addAddress($receiver['address'], $receiver['name']);
            } else {
                self::$mailer->addAddress($receiver['address']);
            }
        }

        if (!empty($cc)) {
            foreach ($cc as $receiver) {
                if (!empty($receiver['name'])) {
                    self::$mailer->AddCC($receiver['address'], $receiver['name']);
                } else {
                    self::$mailer->AddCC($receiver['address']);
                }
            }
        }

        if (!empty($bcc)) {
            foreach ($bcc as $receiver) {
                if (!empty($receiver['name'])) {
                    self::$mailer->AddBCC($receiver['address'], $receiver['name']);
                } else {
                    self::$mailer->AddBCC($receiver['address']);
                }
            }
        }
    }

    /**
     * setMailContent
     *
     * @param  mixed $viewName
     * @param  mixed $data
     * @param  mixed $subject
     * @param  mixed $altBody
     * @return void
     */
    private static function setMailContent(Mailable $mail)
    {
        $viewData = array_merge(self::getMailAtributteData($mail), $mail->viewData);

        self::$mailer->isHTML(true);
        self::$mailer->Subject = $mail->subject;

        self::$mailer->Body = view($mail->view, $viewData);
        if (!empty($mail->textView)) {
            self::$mailer->AltBody = $mail->textView;
        }

        foreach($mail->attachments as $attachment) {
            self::$mailer->AddAttachment = $attachment;
        }
    }

    private function renderView($viewName, $data = null)
    {
        return view($viewName, $data);
    }

    private static function getMailAtributteData($mailObject)
    {
        $expectedAttributes = [
            "locale",
            "from",
            "to",
            "cc",
            "bcc",
            "replyTo",
            "subject",
            "view",
            "textView",
            "viewData",
            "attachments",
            "rawAttachments",
            "diskAttachments",
            "callbacks",
            "theme",
            "mailer",
            "connection",
            "queue",
            "chainConnection",
            "chainQueue",
            "chainCatchCallbacks",
            "delay",
            "afterCommit",
            "middleware",
            "chained",
            "viewDataCallback"
        ];

        $classVars = get_class_vars(get_class($mailObject));

        $objectAttributes = array_keys($classVars);

        $attributesWithData = [];
        foreach ($objectAttributes as $key) {
            if (!in_array($key, $expectedAttributes)) {
                $attributesWithData[$key] = $classVars[$key];
            }
        }

        return $attributesWithData;
    }


    // +teste: "Matheus Galdino da Silva"


    // +subject: "Teste from server"
    // +view: "locatarioCadastrado"
    // +attachments: []


    // +textView: null
    // +viewData: []

    // +rawAttachments: []
    // +diskAttachments: []
    // +callbacks: []
    // +theme: null
    // +mailer: null
    // #assertionableRenderStrings: null
    // +connection: null
    // +queue: null
    // +chainConnection: null
    // +chainQueue: null
    // +chainCatchCallbacks: null
    // +delay: null
    // +afterCommit: null
    // +middleware: []
    // +chained: []



    // Mail::send('Html.view', $data, function ($message) {
    //     $message->from('john@johndoe.com', 'John Doe');
    //     $message->sender('john@johndoe.com', 'John Doe');
    //     $message->to('john@johndoe.com', 'John Doe');
    //     $message->cc('john@johndoe.com', 'John Doe');
    //     $message->bcc('john@johndoe.com', 'John Doe');
    //     $message->replyTo('john@johndoe.com', 'John Doe');
    //     $message->subject('Subject');
    //     $message->priority(3);
    //     $message->attach('pathToFile');
    // });
    // Mail::send(new LocatarioCadastrado());
    // return  new LocatarioCadastrado();

    // return config('mail.mailers.smtp');
}
