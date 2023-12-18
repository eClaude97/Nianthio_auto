<?php

namespace App;

use App\Models\Mark;
use App\Models\Model;
use Class\Controller;

class AppController extends Controller
{
    protected string $template = 'admin-layout';

    public function __construct(){
        $this->path = ROOT . "/views/";
    }

}