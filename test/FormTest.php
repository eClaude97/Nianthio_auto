<?php

namespace test;

use Class\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInputField(): void
    {
        $form = new Form();
        $result = $form->inputField('name');

        $expect = "<div class='form-group '><label for=name>Name</label><input type=text class='form-control'"
            ." id=name name=name placeholder=Name value=''  ><div class='invalid-feedback'>Champ requis !</div></div>";

        $this->assertSame($expect, $result);
    }

    public function testSelectField(): void
    {
        $form = new Form();

        $options = array(
            ['value' => 1, 'text' => 'option 1'],
            ['value' => 2, 'text' => 'option 2']
        );
        $result = $form->selectField('select', $options, required: 'required', class: 'col');

        $expect = "<div class='form-group col'><label for=select>Select*</label><select id=select" .
            " name=select class='form-control' required><option selected disabled>Choose Select*</option>" .
            "<option  value='1'>option 1</option><option  value='2'>option 2</option></select><div class='invalid-feedback'>Champ requis !</div></div>";

        $this->assertSame($expect, $result);
    }

    public function testFileField(): void
    {
        $form = new Form();
        $result = $form->fileField('fichier', 'Picture', 'required', 'col');

        $expect = "<div class='custom-file col'><input type='file' required class='custom-file-input' id=fichier name=fichier >";
        $expect .= "<label class='custom-file-label' for=fichier >Picture*</label><div class='invalid-feedback'>Champ requis !</div></div>";

        $this->assertSame($expect, $result);

    }

    public function testCheckboxField()
    {
        $form = new Form();
        $result = $form->checkboxField('sold');

        $expect = "<div class='form-check '><input type='checkbox' class='form-check-input' id=sold name=sold value='0'  >";
        $expect .= "<label for=sold>Sold</label><div class='invalid-feedback'>Champ requis !</div></div>";

        $this->assertSame($expect, $result);

    }

}
