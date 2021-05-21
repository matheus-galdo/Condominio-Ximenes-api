<?php

namespace App\Mail;

use App\Models\Locatario;
use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LocatarioCadastrado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    
    
    public $titulo = 'Seja bem vindo';
    public $assunto = 'Testando o envio de anexos';
    public $img = '';
    public $today = '';
    public $unsubscribeUrl = '';
    
    
    public $nome = '';
    public $destinatario = '';

    public $conteudoView = 'mail.locatarioCadastrado';
    public $conteudoText = 'Autorização de entrada - Locação no Condomínio Ximenes';

    public function __construct(Locatario $locatario)
    {
        $this->nome = $locatario->nome;
        $this->destinatario = $locatario->email;

        $this->unsubscribeUrl = url('/images/handshake.png');
        $this->img = url('/images/handshake.png');
        $this->today = Carbon::now()->locale('pt_BR')->isoFormat("d MMM, YYYY");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fileName = 'Regras Condomínio Ximenes II(Avaliação).pdf';

        $this->subject($this->assunto)
        ->to($this->destinatario)
        ->attach(storage_path('/app/internalFiles/'.$fileName));
        return $this->view($this->conteudoView);
    }
}
