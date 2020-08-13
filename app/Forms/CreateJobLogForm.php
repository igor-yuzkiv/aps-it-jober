<?php

namespace App\Forms;

use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;
use App\Repository\ServicesItemRepository;
use App\Repository\UsersRepository;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CreateJobLogForm
 * @package App\Forms
 */
class CreateJobLogForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $ServiceItemRepository = new ServicesItemRepository();
        $UserRepository = new UsersRepository();
        $ClientRepository = new ClientRepository();
        $ProjectRepository = new ProjectRepository();

        $this
            ->add("services_item_id", "select", [
                "label" => __("form.job_log.create.attr.services_item_id"),
                'choices' => $ServiceItemRepository->getForSelect(),
                'attr' => [
                    "class" => "form-control select2"
                ],
                "empty_value" => __("form.base.attr.select_empty_val")
            ])
            ->add("user_exec", "select", [
                "label" => __("form.job_log.create.attr.user_exec"),
                'choices' => $UserRepository->getForSelect(),
                'choice_options' => [
                    'wrapper' => ['class' => 'choice-wrapper'],
                    'label_attr' => ['class' => 'label-class'],
                ],
                'selected' => Auth::id(),
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    "class" => "duallistbox",
                    "multiple" => "multiple"
                ],
            ])
            ->add("project_id", "select", [
                "label" => __("form.job_log.create.attr.project_id"),
                'choices' => $ProjectRepository->getForSelect(),
                "empty_value" => __("form.base.attr.select_empty_val"),
                'attr' => [
                    "class" => "form-control select2",
                    "id" => "project_id"
                ],
            ])
            ->add("client_id", "select", [
                "label" => __("form.job_log.create.attr.client_id"),
                'choices' => $ClientRepository->getForSelect()
            ])
            ->add("coefficient", "text", [
                "label" => __("form.job_log.create.attr.coefficient"),
                "value" => 1,
                "attr" => [
                    "id" => "coefficient"
                ]
            ])
            ->add("count", "number", [
                "label" => __("form.job_log.create.attr.count"),
                "value" => "1"
            ])
            ->add("price", "text", [
                "label" => __("form.job_log.create.attr.price"),
                "value" => 0,
                "attr" => [
                    "id" => "price",
                    "readonly" => "true"
                ]
            ])
            ->add("total_price", "text", [
                "label" => __("form.job_log.create.attr.total_price"),
                "attr" => [
                    "id" => "total_price",
                    "readonly" => "true"
                ],
                "value" => 0
            ])
            ->add("comment", "textarea", [
                "label" => __("form.job_log.create.attr.comment"),
            ])
            ->add("add", "submit", [
                "label" => __("basic.label.add"),
                "attr" => [
                    "class" => "form-control btn-success",
                    "id" => "btn_add"
                ]
            ]);

    }
}
