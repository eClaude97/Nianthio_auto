<?php

namespace App\Controllers\Admin;

use App\AppController;
use App\Functions;
use App\Models\User;
use Class\Form;
use DateTime;

class UserController extends AppController
{
    private array $typeOption  = array(
      ['value' => 'Admin', 'text' => 'Administrateur'],
      ['value' => 'Owner', 'text' => 'Fournisseur'],
      ['value' => 'Customer', 'text' => 'Client']
    );

    /**
     * @param string|null $success
     * @param string|null $error
     * @return void
     */
    public function index(?string $success = null, ?string $error = null): void
    {
        $users = User::all();
        $this->render('admin.user.index', compact('users', 'success', 'error'));
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function add(?string $error = null) : void
    {
        $form = new Form();
        $type = $this->typeOption;
        $this->render('admin.user.form', compact('form','error', 'type'));
    }

    /**
     * @return void
     */
    public function store(): void
    {
        if (isset($_POST['add'])){
            extract($_POST);
            $failed = false;
            $picture = Functions::uploadFiles($_FILES['picture'], 'Storage/profil/img/');
            $doc = Functions::uploadFiles($_FILES['doc'], 'Storage/profil/docs/', 'doc');
            if (!$picture['success'] || $picture['error'] !== false || !$doc['success'] || $doc['error'] !== false) {
                $failed = true;
            }
            if ($password !== $re_password ) $failed = true;

            if (!$failed){
                $token = User::token(User::all(['token'], false));
                $password = SHA1($password);
                $datas = array(
                    'token' => $token, 'firstname' => $firstname, 'lastname' => $lastname, 'login' => $login,
                    'email' => $email, 'password' => $password, 'tel' => $tel, 'address' => $address, 'about' => $about,
                    'type' =>  $type, 'job' => $job, 'activation_code' => Functions::createCode(),
                    'reboot_pass_code' => Functions::createCode(), 'active' => 0, 'picture' =>  $picture['name'],
                    'doc' => $doc['name'],
                    'create_at' => (new DateTime())->format('d-m-Y-H-i-s'),
                    'update_at' => (new DateTime())->format('d-m-Y-H-i-s')
                );
                $response = User::create($datas);
                if ($response){
                    header('location: ?p=admin.user.index');
                }
            } else {
                $this->add("Upload error");
            }
        }
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function edit(?string $error = null): void
    {
        $user = User::find($_GET['id'],keyName:  'token');
        if ( $user) {
            $form = new Form();
            $this->render('admin.mark.form', compact('form', 'user', 'error'));
        } else {
            $this->index('Erreur de Chargement de l\'utilisateur');
        }
    }

    /**
     * @return void
     */
    public function update(): void
    {
        if (isset($_POST['edit'])){
            extract($_POST);
            $failed = false;
            $user = User::find($_POST['edit']);
            if ( $user === false ) $failed = true;
            if (!$failed){
                $datas = array(
                    'firstname' => $firstname, 'lastname' => $lastname, 'tel' => $tel, 'address' => $address,
                    'about' => $about, 'job' => $job,
                    'update_at' => (new DateTime())->format('Y-m-d-H-i')
                );
                $response = $user->update($datas);
                if ($response){
                    $this->index('L\'utilisateur a été modifier avec succès');
                }
            } else {
                $this->profil();
            }
        }
    }

    /**
     * Cette methode permet d'activer le compte d'un utilisateur
     * @return void
     */
    public function activate(): void
    {
        if (isset($_POST['activate'])){
            extract($_POST);
            $failed = false;
            $user = User::find($_POST['activate']);
            if ( $user === false ) $failed = true; else {
                if ( $user->activation_code !== $_POST['activate']) $failed = true;
            }
            if (!$failed){
                $datas = array('active' => 1, 'update_at' => (new DateTime())->format('Y-m-d-H-i'));
                $response = $user->update($datas);
                if ($response){
                    $this->index('Votre compte est désormais actif');
                }
            } else {
                $this->profil('Mot de passe incorrect');
            }
        }
    }

    /**
     * Cette méthode permet à un utilisateur de changer son mode de passe
     * @return void
     */
    public function changePass(): void
    {
        if (isset($_POST['change_pass'])){
            extract($_POST);
            $failed = false;
            $user = User::find($_POST['change_pass']);
            if ( $user === false) $failed = true;
            else{
                if ($user->password !== $oldPass || $newPass !== $reNewPass) $failed = true;
            }
            if (!$failed){
                $datas = array(
                    'password' => SHA1($newPass),
                    'update_at' => (new DateTime())->format('Y-m-d-H-i')
                );
                $response = $user->update($datas);
                if ($response){
                    $this->index('Mot de passe modifié avec succès');
                }
            } else {
                $this->profil('Mot de passe incorrect');
            }
        }
    }

    /**
     * Cette methode permet à l'utilisateur de changer sa photo de profil ou son document descriptif
     * @return void
     */
    public function changeFile(): void
    {
        if (isset($_POST['change_file'])){
            extract($_POST);
            $failed = false;
            /* @var User|bool $user */$user = User::find($_POST['change_file']);
            $fichier = (isset($_FILES['picture']))
                ? Functions::uploadFiles($_FILES['picture'], 'Storage/profil/img/')
                : Functions::uploadFiles($_FILES['doc'], 'Storage/profil/docs/', 'doc');

            if (!$fichier['success'] || $fichier['error'] !== false || $user === false) $failed = true;
            if (!$failed){
                if (isset($_FILES['picture'])) {
                    $datas = array('picture' => $fichier['name'], 'create_at' => (new DateTime())->format('d-m-Y-H-i-s'));
                    $oldFile = $user->picture();
                } else if (isset($_FILES['doc'])) {
                    $datas = array('doc' => $fichier['name'], 'create_at' => (new DateTime())->format('d-m-Y-H-i-s'));
                    $oldFile = $user->doc();
                }
                $response = $user->update($datas);
                if ($response){
                    if (isset($oldFile) && file_exists($oldFile)) unlink($oldFile);
                    $this->profil();
                }
            } else {
                $this->profil("Erreur de mise a jour du profil");
            }
        }
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function profil(?string $error = null): void
    {
        $form = new Form();
        $user = User::find($_GET['id'], keyName: 'token');
        $this->render('admin.user.profil', compact('form', 'user', 'error'));
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if (isset($_POST['delete']))
            {
                extract($_POST);
                $user = User::find($delete);
                if (!is_object($user)){
                    $this->index(error: 'Erreur de chargement de l\'utilisateur');
                } else {
                    $oImg = $user->picture();
                    $oDoc = $user->doc();
                    if ($user->delete()) {
                        if (file_exists($oDoc)) unlink($oDoc);
                        if (file_exists($oImg)) unlink($oImg);
                        header("location:  ?p=admin.user.index");
                    }
                }
            }

    }

}