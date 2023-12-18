<?php

namespace App\Controllers\Admin;

use App\AppController;
use App\Functions;
use App\Models\Mark;
use App\Models\Model;
use Class\Form;
use DateTime;

class ModelController extends AppController
{
    /**
     * @param string|null $success
     * @param string|null $error
     * @return void
     */
    public function index(?string $success = null, ?string $error = null): void
    {
        $models = Model::all();
        $this->render('admin.model.index', compact('models', 'success', 'error'));
    }
    /**
     * @return void
     */
    public function add(): void
    {
        $form = new Form();
        $options = Mark::all(['id as value', 'name as text'], false);
        $this->render('admin.model.form', compact('form', 'options'));
    }
    /**
     * @return void
     */
    public function store(): void
    {
        if (isset($_POST['add'])) {
            extract($_POST);
            $now = new DateTime();
            $token = Functions::createToken(Model::all(['token'], false));
            $datas = array(
                'token' => $token,
                'title' => $title,
                'year' => $year,
                'mark_id' => $mark_id,
                'create_at' => $now->format('Y-m-d-H-i'),
                'update_at' => $now->format('Y-m-d-H-i')
            );
            $response = Model::create($datas);
            if ($response) {
                header('location: ?p=admin.model.index');
            } else {
                $this->index(error: 'Erreur de création du modèle');
            }
        }
    }
    /**
     * @param string|null $error
     * @return void
     */
    public function edit(?string $error = null): void
    {
        $form = new Form();
        $options = Mark::all(['id as value', 'name as text'], false);
        $model = Model::find($_GET['id'],keyName: 'token');
        if($model) {
            $this->render('admin.model.form', compact('form', 'model', 'options', "error"));
        } else {
            $this->index(error: 'Erreur de chargement du model');
        }
    }
    /**
     * @return void
     */
    public function update(): void
    {
        if (isset($_POST['edit'])) {
            extract($_POST);
            $model = Model::find($_POST['edit']);
            if (is_object($model)){
                $now = new DateTime();
                $datas = array(
                    'title' => $title,
                    'year' => $year,
                    'mark_id' => $mark_id,
                    'update_at' => $now->format('Y-m-d-H-i')
                );
                $response = $model->update($model->getId(), $datas);
                if ($response) {
                    $this->index('La Marque a été modifier avec succès');
                } else {
                    $this->edit('Erreur de modification');
                }
            }
        } else {
            $this->edit();
        }
    }
    /**
     * @return void
     */
    public function delete(): void
    {
        if (isset($_POST['delete']))
        {
            extract($_POST);
            /* @var Model $model*/
            $model = Model::find($delete);
            if ($model->delete($model->getId())) {
                header('location: ?p=admin.model.index');
            } else {
                $this->index(error: 'Erreur de suppression de l\'élément');
            }
        }
    }

}