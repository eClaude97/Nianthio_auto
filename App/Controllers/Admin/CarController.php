<?php

namespace App\Controllers\Admin;

use App\AppController;
use App\Functions;
use App\Models\Car;
use App\Models\Car_Pictures;
use App\Models\Mark;
use Class\Form;
use DateTime;

class CarController extends AppController
{
    private array $typeOption  = array(
        ['value' => 'SUV', 'text' => 'SUV'],
        ['value' => 'Sport', 'text' => 'Sport'],
        ['value' => 'Fourgonnette', 'text' => 'Fourgonnette']
    );
    
    private array $colorOptions = array(
        ['value' => 'Noir', 'text' => 'Noir'],
        ['value' => 'Blanc', 'text' => 'Blanc'],
        ['value' => 'Bleu', 'text' => 'Bleu'],
        ['value' => 'Jaune', 'text' => 'Jaune'],
        ['value' => 'Rouge', 'text' => 'Rouge'],
        ['value' => 'Gris', 'text' => 'Gris'],
        ['value' => 'Orange', 'text' => 'Orange'],
        ['value' => 'Belge', 'text' => 'Belge'],
        ['value' => 'Marron', 'text' => 'Marron'],
        ['value' => 'Vert', 'text' => 'Vert']
    );
    
    private array $energyOptions = array(
        ['value' => 'Essence', 'text' => 'Essence'],
        ['value' => 'Diesel', 'text' => 'Diesel'],
        ['value' => 'Electric', 'text' => 'Electric'],
        ['value' => 'Hybride', 'text' => 'Hybride']
    );

    private array $transmissionOptions =  array(
        ['value' => 'Automatique', 'text' => 'Automatique'],
        ['value' => 'Semi-Automatique', 'text' => 'Semi-Automatique'],
        ['value' => 'Manuelle', 'text' => 'Manuelle']
    );

    /**
     * Affiche la page d'accueil de tous les véhicules
     * @param string|null $success
     * @param string|null $error
     * @return void
     */
    public function index(?string $success = null, ?string $error = null ): void
    {
        $cars = Car::all();
        $this->render('admin.car.index', compact('cars', 'success', 'error'));
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function add(?string $error = null) : void
    {
        $form = new Form();
        $marks = Mark::all(['id as value', 'name as text'], false);
        $types = $this->typeOption;
        $transmissions = $this->transmissionOptions;
        $colors = $this->colorOptions;
        $energies = $this->energyOptions;
        $this->render('admin.car.form',
            compact('form','error',
                'types', 'transmissions', 'colors', 'energies', 'marks')
        );
    }

    /**
     * @param int $id
     * @return bool
     */
    private function forDelete(int $id) : bool
    {
        /* @var Car $car */
        $car = Car::find($id);
        if (is_object($car)) {
            (new Car_Pictures())->delete('car_id', $car->id);
            foreach ($car->pictures as $picture) {
                if (file_exists($picture->path())) unlink($picture->path()); else {
                    return false;
                }
            }
            if ($car->delete()) return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public function store(): void
    {
        if (isset($_POST['add'])){
            extract($_POST);
            $add_by = $_SESSION['user']->id;
            $token = Car::token(Car::all(['token'], false));
            $datas = array(
                'token' => $token, 'matricule' => $matricule ?? '', 'title' => $title, 'description' => $description,
                'mark_id' => $mark_id, 'model_id' => $model_id, 'type' => $type, 'color' => $color, 'price' => $price,
                'mileage' =>  $mileage, 'doors' => $doors, 'seats' => $seats, 'energy' => $energy, 'transmission' => $transmission,
                'sold' =>  $sold, 'rented' => $rented, 'add_by' => $add_by, 'create_at' => (new DateTime())->format('d-m-Y-H-i-s'),
                'update_at' => (new DateTime())->format('d-m-Y-H-i-s')
            );
            $response = Car::create($datas);
            if ($response){
                extract($_FILES);
                /* @var Car $car */
                $car = Car::findWhere(['id'], ['token' => $token], false);
                $failed = false;
                $images = array();
                $i = null;
                while (isset($_FILES["img$i"])){
                    $picture = Functions::uploadFiles($_FILES['picture'], 'Storage/profil/img/');
                    if ($picture['success'])
                    {
                        $images[] = $picture['name'];
                    } else {
                        $failed = true;
                    }
                    if (is_null($i)) {
                        $i = 1;
                    } else {
                        $i += 1;
                    }
                }
                if (!$failed) {
                    foreach ($images as $image) {
                        $datas = array(
                            'car_id' => $car['id'], 'path' => $image
                        );
                        $rep = Car_Pictures::create($datas);
                        if (!$rep) {
                            $failed = true;
                            break;
                        }
                    }
                    if (!$failed) header('location: ?p=admin.car.index');else {
                        $this->add("Erreur upload de fichier");
                    }
                }
                if ( $failed ){
                    if (!$this->forDelete($car->id)) header('location: page404.php');
                }
            } else {
                $this->add("Add Error");
            }
        }
    }

    /**
     * @param string|null $error
     * @return void
     */
    public function edit(?string $error = null): void
    {
        $car = Car::find($_GET['id'],keyName:  'token');
        if ( $car ) {
            $form = new Form();
            $types = $this->typeOption;
            $transmissions = $this->transmissionOptions;
            $colors = $this->colorOptions;
            $energies = $this->energyOptions;
            $this->render('admin.car.form',
                compact('form','car', 'error',
                    'types', 'transmissions', 'colors', 'energies')
            );
        } else {
            $this->index('Erreur de Chargement du véhicule');
        }
    }

    /**
     * @return void
     */
    public function update(): void{
        if (isset($_POST['edit'])){
            extract($_POST);
            /* @var Car $car*/
            $car = Car::find($_GET['id']);
            $datas = array(
                'matricule' => $matricule ?? '', 'title' => $title, 'description' => $description,
                'type' => $type, 'color' => $color, 'price' => $price, 'mileage' =>  $mileage, 'doors' => $doors,
                'seats' => $seats, 'energy' => $energy, 'transmission' => $transmission, 'update_at' => (new DateTime())->format('d-m-Y-H-i-s')
            );
            $response = $car->update($datas);
            if ($response){
                foreach ($car->pictures as $picture) {
                    if (file_exists($picture->path())) unlink($picture->path());
                }
                $this->index('Véhicule mise a jour avec succès');
            } else {
                $this->add("Add Error");
            }
        }

    }

    /**
     * Cette methode permet retourner la vue de detail d'un Véhicule
     * @return void
     */
    public function show() : void {
        $car = Car::find($_GET['id'], keyName: 'token');
        $this->render('admin.car.show', compact('car'));
    }

    public function changeFile(): void{}

    /**
     * Permet la suppression d'un  vehicle
     * @return void
     */
    public function delete(): void
    {
        if (isset($_POST['delete']))
        {
            extract($_POST);
            if ($this->forDelete($delete)){
                header("location: ?p=admin.car.index");
            } else {
                $this->index(error: 'Erreur de suppression');
            }
        } else {
            $this->index(error: 'Erreur de soumission du formulaire');
        }

    }

}