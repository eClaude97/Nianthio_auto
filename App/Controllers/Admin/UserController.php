<?php

namespace App\Controllers\Admin;

use App\AppController;
use App\Functions;
use App\Models\User;
use Class\Form;
use DateTime;
use http\Message;

class UserController extends AppController
{

    private array $typeOption  = array(
      ['value' => 'Admin', 'text' => 'Administrateur'],
      ['value' => 'Owner', 'text' => 'Fournisseur'],
      ['value' => 'Customer', 'text' => 'Client']
    );

    const ERROR_RESET_PASS = 1;
    const ERROR_CHANGE_PICTURE = 2;
    const ERROR_CHANGE_DOC = 3;
    const ERROR_USER_EDIT = 4;

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
            /* @var User|bool $user */
            $user = User::find($_POST['edit']);
            if ( $user === false ) $failed = true;
            $_GET['id'] = $user->getToken();
            if (!$failed){
                $datas = array(
                    'firstname' => $firstname, 'lastname' => $lastname, 'tel' => $tel, 'address' => $address,
                    'about' => $about, 'job' => $job,
                    'update_at' => (new DateTime())->format('Y-m-d-H-i')
                );
                $response = $user->update($user->getId(), $datas);
                if ($response){
                    $this->profil("L'utilisateur a été modifier avec succès", true);
                }
            } else {
                $this->profil("Error de mise a jour de l'utilisateur", error: self::ERROR_USER_EDIT);
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
                $response = $user->update($user->getId(), $datas);
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
    public function reset_pass(): void
    {
        if (isset($_POST['reset_pass'])){
            extract($_POST);
            $failed = false;
            /* @var User $user */
            $user = User::find($_POST['reset_pass']);
            if (!$user) $failed = true;
            else{
                if ($user->getPassword() !== SHA1($old_pass) || $new_pass !== $re_new_pass) $failed = true;
            }
            $_GET['id'] = $user->getToken();
            if (!$failed){
                $datas = array(
                    'password' => SHA1($new_pass),
                    'update_at' => (new DateTime())->format('Y-m-d-H-i')
                );
                $response = $user->update($user->getId() , $datas);
                if ($response){
                    $this->profil('Mot de passe modifié avec succès', true);
                }
            } else {
                $this->profil('Mot de passe incorrect', false, self::ERROR_RESET_PASS);
            }
        }
    }

    /**
     * Cette methode permet à l'utilisateur de changer sa photo de profil ou son document descriptif
     * @return void
     */
    public function changeFile(): void
    {
        if (isset($_POST['change_file']) or isset($_POST['del_file'])){
            extract($_POST);
            $failed = false;
            $id = $_POST['change_file'] ?? $_POST['del_file'];
            /* @var User|bool $user */
            $user = User::find($id);
            $fichier = ( isset($_FILES['picture']))
                ? Functions::uploadFiles($_FILES['picture'], 'Storage/profil/img/')
                : Functions::uploadFiles($_FILES['doc'], 'Storage/profil/docs/', 'doc');

            if (!$fichier['success'] || $fichier['error'] !== false || $user === false) $failed = true;
            if (isset($_POST['del_file'])) $failed = false;

            $_GET['id'] = $user->getToken();
            if (!$failed){
                if (isset($_FILES['picture'])) {
                    $datas = array('picture' => $fichier['name'], 'create_at' => (new DateTime())->format('d-m-Y-H-i-s'));
                    $oldFile = $user->picture();
                } else if (isset($_FILES['doc'])) {
                    $datas = array('doc' => $fichier['name'], 'create_at' => (new DateTime())->format('d-m-Y-H-i-s'));
                    $oldFile = $user->doc();
                }
                $response = $user->update($user->getId(), $datas);
                if ($response){
                    if (isset($oldFile) && file_exists($oldFile)) unlink($oldFile);
                    $this->profil('fichier mise à jour avec succès', true);
                }
            } else {
                if (isset($_FILES['picture']))
                    $this->profil("Erreur d'édition de l'image de profil", error:self::ERROR_CHANGE_PICTURE);
                else
                    $this->profil("Erreur d'édition du document de profil", error:self::ERROR_CHANGE_DOC);
            }
        }
    }

    /**
     * @param string|null $message
     * @param bool|null $success
     * @param int|null $error
     * @return void
     */
    public function profil(?string $message = null, ?bool $success = null, ?int $error = null): void
    {
        $form = new Form();
        $user = User::find($_GET['id'], keyName: 'token');
        $this->render('admin.user.profil', compact('form', 'user', 'message', 'success', 'error'));
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if (isset($_POST['delete']))
            {
                extract($_POST);
                /* @var User $user */$user = User::find($delete);
                if (!is_object($user)){
                    $this->index(error: 'Erreur de chargement de l\'utilisateur');
                } else {
                    $oImg = $user->picture();
                    $oDoc = $user->doc();
                    if ($user->delete($user->getId())) {
                        if (file_exists($oDoc)) unlink($oDoc);
                        if (file_exists($oImg)) unlink($oImg);
                        header("location:  ?p=admin.user.index");
                    }
                }
            }

    }

}