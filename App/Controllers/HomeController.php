<?php
namespace App\Controllers;

use App\AppController;
use App\Models\Car;

class HomeController extends AppController
{

    protected string $template = 'base';

    public function index(): void
    {
        $cars = Car::all();
        $this->render('index', compact('cars'));
    }

}