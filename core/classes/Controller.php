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

            case 'min':

                if (strlen($data[$field]) < $param && strlen($data[$field]) > 0) {
                    $errors[$field] = 'Ce champ est trop court';
                }

                break;
                
            case 'max':

                if (strlen($data[$field]) > $param) {
                    $errors[$field] = 'Ce champ est trop long';
                }

                break;
                
            case 'number':
                
                if (!empty($data[$field])) {
                    if (preg_match('/\d/', $data[$field]) == 0) {
                        $errors[$field] = 'Vous devez saisir un nombre.';
                    }
                }
                break;

            case 'url':
                if (!empty($data[$field])) {
                    if (preg_match('/[https|http]+\:\/\/([w]{3,3})?.[a-z0-9]+\.(fr|com|net|shop|store)+(\/?)(.?)+/', $data[$field]) == 0) {
                        $errors[$field] = 'Vous devez saisir une url valide.';
                    }
                }
                break;



            case 'date':
                if (preg_match('/(19[0-9]{2,2}+)-([0-9]{2,2})-([0-9]{2,2})/', $data[$field]) == 0) {
                    $errors[$field] = 'Vous devez saisir une date valide.';
                }
                break;
                
            case 'year':
                if ($data[$field] < date('Y') || strlen($data[$field]) < 4 || strlen($data[$field]) > 4) {
                    $errors[$field] = 'Vous devez saisir une année valide.';
                    break;
                }
        }

            
        return $errors;
    }

    protected function redirect($url)
    {
        header("Location: " . BASE_URI . "/{$url}");
    }
}
