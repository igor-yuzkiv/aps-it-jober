<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class UserForm
 * @package App\Forms
 */
class UserForm extends Form
{
    /**
     * @return UserForm|mixed
     */
    public function buildForm()
    {
        $this
            ->add("name", "text", [
                "label" => "Ім'я",
            ])
            ->add("email", "email", [
                "label" => "E-mail",
            ])
            ->add("password", "password", [
                "label" => "Пароль",
            ])
            ->add("password_confirmation", "password", [
                "label" => "Підтвердіть пароль",
            ])
            ->add("avatar", "file", [
                "label" => "Аватар",
                "attr" => [
                    "" => "",
                ]
            ])
            ->add("submit", "submit", [
                "label" => "Збдерегти",
                "attr"=>[
                    "class" => "form-control btn-success",
                ]
            ]);
    }
}
