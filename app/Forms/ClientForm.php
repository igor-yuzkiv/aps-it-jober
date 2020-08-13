<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class ClientForm
 * @package App\Forms
 */
class ClientForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => __("form.client.attr.name"),
            ])
            ->add("short_name", "text", [
                "label" => "Коротака назва"
            ])
            ->add("position", "number", [
                "label" => __("form.base.attr.position")
            ])
            ->add('submit', 'submit', [
                'label' => __("basic.label.save"),
                'attr' => [
                    "class" => "form-control btn-success"
                ]
            ]);
    }
}
