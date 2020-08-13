<?php

namespace App\Forms;

use App\Repository\TranslationLanguagesReposiotry;
use Kris\LaravelFormBuilder\Form;
use \App\Repository\TranslationRepository;

/**
 * Class TranslationsForm
 * @package App\Forms
 */
class TranslationsForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $TranslationLanguagesReposiotry = new TranslationLanguagesReposiotry();

        $this
            ->add('locale', 'select', [
                "label" => __("form.translations.attr.locale"),
                'choices' => $TranslationLanguagesReposiotry->getForSelect(),
                'selected' => config("app.locale"),
            ])
            ->add('namespace', 'text', [
                "label" => __("form.translations.attr.namespace"),
                "value" => "*"
            ])
            ->add('group', 'text', [
                "label" => __("form.translations.attr.group"),
            ])
            ->add('item', 'text', [
                "label" => __("form.translations.attr.item"),
            ])
            ->add('text', 'text', [
                "label" => __("form.translations.attr.text"),
            ])
            ->add("OK", "submit", [
                "attr" => [
                    "class" => "form-control btn btn-success"
                ]
            ])
        ;
    }
}
