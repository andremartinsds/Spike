<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContatoMail extends Mailable
{
    use Queueable, SerializesModels;

    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $nome, $telefone, $mensagem;

    public function __construct($nome, $telefone, $mensagem)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->mensagem = $mensagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   

        return $this
                ->subject('E-mail enviado do site')
                ->to('secretaria@domboscopremium.com.br')
                ->view('email.contato.email');
    }
}
