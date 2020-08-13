<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UnitsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                "label" => "Назва"
            ])
            ->add('formula_calc_total', 'text', [
                "label" => "Формула обчислення суми (за замовчуванням = \" (price*count)*coefficient) \")"
            ])
            ->add("submit",  "submit", [
                "label" => "Збдерегти",
                "attr"=>[
                    "class" => "form-control btn-success",
                ]
            ]);
    }
}
