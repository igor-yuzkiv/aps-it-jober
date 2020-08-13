<?php

namespace App\Forms;

use App\Repository\ClientRepository;
use App\Repository\ServicesItemRepository;
use Kris\LaravelFormBuilder\Form;

class CoefficientForm extends Form
{
    public function buildForm()
    {
        $ServicesItemRepository = new ServicesItemRepository();
        $ClientRepository = new ClientRepository();
        return $this
            ->add("name", "text", [
                "label" => "Назва",
            ])
            ->add("value", "text", [
                "label" => "Значення",
            ])
            /*->add("client_id", "select", [
                "label" => "Відсортувати по клієнту",
                "empty_value" =>  __("form.base.attr.select_empty_val"),
                'choices' => $ClientRepository->getForSelect(),
                "attr" => [
                    "id" => "client_id"
                ]
            ])*/
            ->add("services_items_id", "select", [
                "label" => "Послуги",
                'choices' => $ServicesItemRepository->getForSelect(),
                'choice_options' => [
                    'wrapper' => ['class' => 'choice-wrapper'],
                    'label_attr' => ['class' => 'label-class'],
                ],
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    "class" => "duallistbox",
                    "multiple" => "multiple",
                    "id" => "services_items_id"
                ],
            ])
            ->add("submit",  "submit", [
                "label" => "Збдерегти",
                "attr"=>[
                    "class" => "form-control btn-success",
                ]
            ]);
    }
}
