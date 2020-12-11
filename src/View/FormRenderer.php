<?php

declare(strict_types=1);

namespace App\View;

class FormRenderer {

    public function articlePrintErrors($fieldName, $errors) {
        if (!isset($errors[$fieldName])) {
            return '';
        }

        foreach ($errors[$fieldName] as $error) {
            echo '<div class="invalid-feedback">' . $error . '</div>';
        }
    }

    public function printErrors($fieldName, $errors): string {
        if (!isset($errors[$fieldName])) {
            return '';
        }

        $html = [];
        foreach ($errors[$fieldName] as $error) {
            $html[] = '<div class="invalid-feedback">' . $error . '</div>';
        }

        return join("\n", $html);
    }

    public function printInput($type, $fieldName, $regData, $errors): string {
        $cssClass = 'form-control' . (!empty($errors[$fieldName]) ? ' is-invalid' : '');
        $value = $regData[$fieldName] ?? null;

        return '<input type="' . $type . '" class="' . $cssClass . '" id="reg-' . $fieldName . '" name="reg[' . $fieldName . ']" value="' . $value . '" required="">';
    }

    public function printField($type, $fieldName, $label, $regData, $errors) {
        $html = [
            '<label for="reg-' . $fieldName . '">' . $label . '</label>',
            $this->printInput($type, $fieldName, $regData, $errors),
            $this->printErrors($fieldName, $errors)
        ];

        return join("\n", $html);
    }

}
