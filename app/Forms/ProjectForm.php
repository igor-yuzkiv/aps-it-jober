<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProjectForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                "label" => __("form.base.attr.name")
            ])
            ->add('comment', 'text', [
                "label" => __("form.base.attr.comment")
            ]);
    }
}
