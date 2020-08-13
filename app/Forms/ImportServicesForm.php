<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class ImportServicesForm
 * @package App\Forms
 */
class ImportServicesForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this
            ->add("xlsx_file", "file" ,[
                "label" => "XLSX File",
                "attr" => [
                    "accept" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
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
