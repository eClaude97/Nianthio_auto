<?php

namespace Class;

class Form
{
    /**
     * @param string $name
     * @param string $type
     * @param string $values
     * @param string|null $label
     * @param string|null $required
     * @param string $placeholder
     * @param string|null $class
     * @return string
     */
    public function inputField(string $name, string $type = 'text',string $values = '', ?string $label = null, ?string $required = null, string $placeholder = '',string $class = null): string
    {
        if (is_null($required)) $label = $label ?? ucfirst($name);else {
            $label = $label ?? ucfirst($name);
            $label .= '*';
        }
        $placeholder = ($placeholder == '') ? $label : $placeholder;
        $field = /* @lang HTML */
            "<div class='form-group " . $class . "'>";
        $field .= "<label for=$name>$label</label>";
        if ($type == 'textarea') {
            $field .= "<textarea id=$name class='form-control' name=$name placeholder={$placeholder}>$values</textarea>";
        } else {
            $field .= "<input type=$type class='form-control' id=$name name=$name placeholder=$placeholder value='" . $values . "' $required >";
        }
        $field .= "<div class='invalid-feedback'>Champ requis !</div></div>";

        return $field;
    }

    /**
     * @param string $name le name est obligatoire.
     * @param array $options ex: array(['value' = > 1, 'text' = > 'option 1'], ['value' = >  2, 'text' => 'option 2'])
     * @param string $old
     * @param string|null $label
     * @param string|null $required
     * @param string|null $class
     * @return string
     */
    public function selectField(string $name, array $options,string $old = '', ?string $label = null, ?string $required = null, ?string $class = null): string
    {
        if (is_null($required)) $label = $label ?? ucfirst($name);else {
            $label = $label ?? ucfirst($name);
            $label .= '*';
        }
        $field = /* @lang HTML */
            "<div class='form-group " . $class . "'>";
        $field .= "<label for=$name>$label</label><select id=$name name=$name class='form-control' $required><option selected disabled>Choose $label</option>";
        foreach ($options as $option) $field .= "<option ". ($old === $option['value'] ? 'selected' : '') ." value='" . $option['value'] . "'>" . $option['text'] . "</option>";
        $field .= "</select><div class='invalid-feedback'>Champ requis !</div></div>";
        return $field;
    }

    /**
     * @param string $name
     * @param string $values
     * @param string|null $label
     * @param string|null $required
     * @param string|null $class
     * @return string
     */
    public function checkboxField(string $name,string $values = '0', ?string $label = null, ?string $required = null,string $class = null): string
    {
        if (is_null($required)) $label = $label ?? ucfirst($name);else {
            $label = $label ?? ucfirst($name);
            $label .= '*';
        }
        $field = /* @lang HTML */
            "<div class='form-check " . $class . "'>";
        $field .= "<input type='checkbox' class='form-check-input' id=$name name=$name value='" . $values . "' $required >";
        $field .= "<label for=$name>$label</label>";
        $field .= "<div class='invalid-feedback'>Champ requis !</div></div>";
        return $field;
    }

    /**
     * @param string $name
     * @param string|null $label
     * @param string|null $required
     * @param string|null $class
     * @return string
     */
    public function fileField(string $name, ?string $label = null, ?string $required = null,string $class = null): string
    {
        if (is_null($required)) $label = $label ?? ucfirst($name);else {
            $label = $label ?? ucfirst($name);
            $label .= '*';
        }
        $field = /* @lang HTML */
            "<div class='custom-file " . $class . "'>";
        $field .= "<input type='file' $required class='custom-file-input' id={$name} name={$name} >";
        $field .= "<label class='custom-file-label' for={$name} >$label</label>";
        $field .= "<div class='invalid-feedback'>Champ requis !</div></div>";
        return $field;
    }

}