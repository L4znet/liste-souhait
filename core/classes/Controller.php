<?php

namespace Core;

abstract class Controller
{
    protected function validate($data, $rules = [])
    {
        if (empty($rules) && !empty($this->rules)) {
            $rules = $this->rules;
        }

        $errors = [];

        foreach ($rules as $field => $rule) {
            if (is_array($rule)) {
                foreach ($rule as $rule2) {
                    $errors = $this->applyRule($data, $field, $rule2, $errors);
                }
            } else {
                $errors = $this->applyRule($data, $field, $rule, $errors);
            }
        }

        if (!empty($errors)) {
            flash('data', $data);
            flash('errors', $errors);

            return false;
        } else {
            return true;
        }
    }

    protected function applyRule($data, $field, $rule, $errors)
    {
        @list($rule, $param) = explode(':', $rule);
        
        switch ($rule) {

            case 'required':

                if (empty($data[$field])) {
                    $errors[$field] = 'Ce champ est obligatoire';
                }

                break;

            case 'email':

                if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Ce champ n\'est pas un e-mail';
                }

                break;

            case 'min':

                if (strlen($data[$field]) < $param) {
                    $errors[$field] = 'Ce champ est trop court';
                }

                break;
        }

            
        return $errors;
    }

    protected function redirect($url)
    {
        header("Location: " . BASE_URI . "/{$url}");
    }
}
