<?php

namespace Class;

class Controller {

    protected string $path;
    protected string $template;

    public function render(string $view, array $variables = []): void
    {
        ob_start();
        extract($variables);
        $dir = str_replace('.', '/', $view);
        require "$this->path$dir.php";
        $content = ob_get_clean();
        require "{$this->path}templates/$this->template.php";
    }

}