<?php

namespace App\Http\Controllers\Translation;

use App\Forms\TranslationsForm;
use App\Helpers\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Repository\TranslationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;
use Waavi\Translation\Models\Translation;

/**
 * Class TranslationsController
 * @package App\Http\Controllers\Translation
 */
class TranslationsController extends Controller
{
    use ControllerHelper;

    /**
     * @var TranslationRepository
     */
    private $TranslationRepository;

    /**
     * TranslationsController constructor.
     */
    public function __construct()
    {
        $this->TranslationRepository = app(TranslationRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {
        return view("translation.index", [
            "title" => __("page.translation.show.title"),
            "table_id" => "translation_data_table",
            "dataTable" => $this->TranslationRepository->getForDataTable()
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(TranslationsForm::class, [
            "method" => "POST",
            "url" => route("translations.store")
        ]);

        return view("layouts.simples.simple_form", [
            "form" => $form,
            "title" => __("page.translations.create.title"),
            "card_title" =>__("page.translations.create.title"),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (Request $request) {
        Validator::make($request->input(), [
            "locale" => "required", "namespace" => "required", "group" => "required", "item" => ["required", "unique:translator_translations,item"], "text" => "required",
        ]) -> validate();

        $Translation = new Translation();
        $Translation->timestamps = true;
        $result = $Translation->fill($request->input());
        $result = $result->save();

        return ($result)
            ? redirect()->route("translations.index")->with("message", __("basic.messages.success"))
            : redirect()->back()->withErrors([__("basic.messages.error")]);
    }


    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit ($id, FormBuilder $formBuilder) {
        $form = $formBuilder->create(TranslationsForm::class, [
            "method" => "PUT",
            "url" => route("translations.update", $id),
            "model" => $this->TranslationRepository->getForEdit($id),
        ]);

        return view("layouts.simples.simple_form", [
            "form" => $form,
            "title" => __("page.translations.create.title"),
            "card_title" =>__("page.translations.create.title"),
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update ($id, Request $request) {
        Validator::make($request->input(), [
            "locale" => "required", "namespace" => "required", "group" => "required", "item" => ["required", "unique:translator_translations,item,$id"], "text" => "required",
        ]) -> validate();

        $Translation = Translation::where("id", $id)->first();
        $Translation->timestamps = true;
        $result = $Translation->fill($request->input());
        $result = $result->save();

        return ($result)
            ? redirect()->route("translations.index")->with("message", __("basic.messages.success"))
            : redirect()->back()->withErrors([__("basic.messages.error")]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Validator::make(['id' => $id], ["id" => "exists:job_log,client_id,NULL"]);
        $result = Translation::where("id", $id)->delete();
        return $this->resultRedirect($result);
    }


}
