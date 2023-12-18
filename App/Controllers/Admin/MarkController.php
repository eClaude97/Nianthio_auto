<?php

namespace App\Controllers\Admin;

use App\AppController;
use App\Functions;
use App\Models\Mark;
use Class\Form;
use DateTime;

class MarkController extends AppController
{

    /**
     * @param $success
     * @param $error
     * @return void
     */
    public function index($success = null, $error = null): void
    {
        $marks = Mark::all();
        $this->render('admin.mark.index', compact('marks', 'success','error' ));
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function add(?string $error = null): void
    {
        $form = new Form();
        $this->render('admin.mark.form', compact('form', 'error'));
    }

    /**
     * @return void
     */
    public function store(): void
    {
        if (isset($_POST['add'])){
            extract($_POST);
            $resp = Functions::uploadFiles($_FILES['logo'], 'Storage/logo/');
            if ($resp['success'] && $resp['error'] === false) {
                $now = new DateTime();
                $token = Functions::createToken(Mark::all(['token'], false));
                $datas = array(
                    'token' => $token,
                    'name' => $name,
                    'logo' => $resp['name'],
                    'create_at' => $now->format('Y-m-d-H-i'),
                    'update_at' => $now->format('Y-m-d-H-i')
                );
                $response = Mark::create($datas);
                if ($response){
                   header('location: ?p=admin.mark.index');
                }
            } else {
                $this->add($resp['error']);
            }
        }
    }

    /**
     * @return void
     */
    public function update(): void
    {
        if (isset($_POST['edit'])){
            extract($_POST);
            $mark = Mark::find($_POST['edit']);
            $resp = Functions::uploadFiles($_FILES['logo'], 'Storage/logo/');
            if ($resp['success'] && $resp['error'] === false) {
                $oldPath = $mark->logoPath;
                $now = new DateTime();
                $datas = array(
                    'name' => $name,
                    'logo' => $resp['name'],
                    'update_at' => $now->format('Y-m-d-H-i')
                );
                $response = $mark->update($datas);
                if ($response){
                    if (file_exists($oldPath)) unlink($oldPath);
                    $this->index('La Marque a été modifier avec succès');
                }
            } else {
                $this->edit('Erreur d\'édition de la marque');
            }
        }
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function edit(?string $error = null): void
    {
        $mark = Mark::find($_GET['id'],keyName:  'token');
        $form = new Form();
        $this->render('admin.mark.form', compact('form', 'mark', 'error'));
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if (isset($_POST['delete']))
        {
            extract($_POST);
            /* @var Mark $mark*/
            $mark = Mark::find($delete);
            if (!is_object($mark)){
                $this->index(error: 'Erreur de suppression de l\'élément');
            } else {
                $dir = $mark->logoPath;
                if ($mark->delete()) {
                    if (file_exists($dir)) unlink($dir);
                    header("location:  ?p=admin.mark.index");
                }
            }
        }
    }

}