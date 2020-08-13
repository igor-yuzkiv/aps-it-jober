<?php

namespace App\Forms;

use App\Repository\ClientRepository;
use App\Repository\ServicesGroupRepository;
use App\Repository\UnitsRepository;
use Kris\LaravelFormBuilder\Form;

class ServicesItemForm extends Form
{
    public function buildForm()
    {
        $UnitRepository = new UnitsRepository();
        $ServiceGroupRepository = new ServicesGroupRepository();
        $ClientRepository = new ClientRepository();


        $this->add("name", "text", [
            "label" => __("form.job_log.create.attr.services_item_id"),
            "attr" => [],
        ])
            ->add("price", "text", [
                "label" => __("form.job_log.create.attr.price"),
                "attr" => [],
            ])
            ->add("unit_id", "select", [
                "label" => __("form.service.item.attr.unit"),
                'choices' => $UnitRepository->getForSelect(),
                'attr' => [
                    "class" => "form-control select2"
                ],
            ])
            ->add("client_id", "select", [
                "label" => "Для клієнта",
                "empty_value" =>  __("form.base.attr.select_empty_val"),
                'choices' => $ClientRepository->getForSelect(),
                "attr" => [
                    "id" => "client_id"
                ]
            ])
            ->add("service_group_id", "select", [
                "label" => __("form.service.item.attr.service_group"),
                'choices' => $ServiceGroupRepository->getForSelect(),
                'attr' => [
                    "class" => "form-control select2",
                    "id" => "services_group_id"
                ],
            ])
            ->add("alias", "text", [
                "label" => __("form.service.item.attr.alias"),
                "attr" => [],
            ])
            /*->add('is_deleted', 'checkbox', [
                "label" => "Видалити",
                'value' => 1,
                'checked' => false
            ])*/
            ->add("add", "submit", [
                "label" => __("basic.label.save"),
                "attr" => [
                    "class" => "form-control btn-success",
                ]
            ]);
    }
}
