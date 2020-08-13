<?php

namespace App\Forms;

use App\Repository\ClientRepository;
use Kris\LaravelFormBuilder\Form;

class ServicesGroupForm extends Form
{
    public function buildForm()
    {
        $ClientRepository = new ClientRepository();

        $this
            ->add("name", "text", [
                "label" => "Назва",
                "attr" => [],
            ])
            ->add("client_id", "select", [
                "label" => "Для клієнта",
                "empty_value" => __("form.base.attr.select_empty_val"),
                'choices' => $ClientRepository->getForSelect(),
                "attr" => [
                    "id" => "client_id"
                ]
            ])
            ->add('submit', 'submit', [
                'label' => __("basic.label.save"),
                'attr' => [
                    "class" => "form-control btn-success"
                ]
            ]);
    }
}
