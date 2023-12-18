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
                header("location: ?p=admin.user.index");
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

    public function mailToActivate(){
        $to = "edemclaudek@gmail.com";
        $subject = "test d'envoi de mail";
        $message = "Envoie reussi :)";

        $header = "Content-Type: text/plain; charset: utf-8\r\n";
        $header .= "From: edemkumaza30@gmail.com\r\n";

        if (mail($to, $subject, $message, $header)){
            echo "envoyer";
        } else {
            echo "Erreur";
        }
    }

}