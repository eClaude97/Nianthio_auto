<?php

namespace App\Controllers;

use App\AppController;
use App\Models\User;
use Class\Form;

class AuthController extends AppController
{
    protected string $template = 'auth-layout';

    public function __construct()
    {
        parent::__construct();
    }

    public function login(?string $error = null): void
    {
        $form = new Form();
        $this->render('login', compact('form', 'error'));
    }

    public function log() : void
    {
        if (isset($_POST['log'])){
            extract($_POST);
            $user = User::connect($login, SHA1($password));
            if (!$user) {
                $this->login('Login ou mot de passe incorrect');
            } else {
                $_SESSION['user'] = $user;
                if ($user['active']) {
                    header("location: ?p=admin.user.index");
                } else {
                    if ($this->mail_for_activation((array)$user)){
                        $this->activate_form();
                    } else {
                        $this->login('Erreur d\'envoie du mail d\'activation veuillez verifier votre address email 
                        ou le changer si possible');
                    }
                }
            }
        }
    }

    public function logout() : void
    {
        if ( isset($_POST['logout'] )){
            $_SESSION = [];
            session_reset();
            session_destroy();
            header("location: ?p=auth.login");
        }
    }

    public function activate_form(?string $error = null): void
    {
        $form = new Form();
        $this->render('compte-activation', compact('form', 'error'));
    }

    public function mail_for_activation(array $user): bool
    {
        $to = $user['email'];
        $subject = "Nianthio_auto Code d'activation";
        $message = "Salut, {$user['firstname']} {$user['lastname']}\r\n";
        $message .= "Votre Code d'activation : \r\n \r\n";
        $message .= "{$user['activation_code']} \r\n \r\n";

        $header = "Content-Type: text/plain; charset: utf-8\r\n";
        $header .= "From: edemkumaza30@gmail.com\r\n";

        return mail($to, $subject, $message, $header);
    }

    /**
     * Cette methode permet d'activer le compte d'un utilisateur
     * @return void
     */
    public function activate(): void
    {
        if (isset($_POST['activate']) && !empty($_SESSION)){
            extract($_POST);
            if ( !$_SESSION['user']['active'] && $_SESSION['user']['activation_code'] == $_POST['code'] ) {
                if ( User::activate($_SESSION['user']['id']) ) {
                    header("location: ?p=admin.user.index"); // TODO lien à modifier
                } else {
                    $this->activate_form("Erreur d'activation du compte");
                }
            } else {
                $this->activate_form("Code d'activation incorrecte");
            }
        }
    }

}