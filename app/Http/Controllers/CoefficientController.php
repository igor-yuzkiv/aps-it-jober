<?php

namespace App\Http\Controllers;

use App\Forms\CoefficientForm;
use App\Helpers\ControllerHelper;
use App\Model\Coefficient;
use App\Repository\CoefficientRepository;
use App\Repository\RegistryRepository;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Http\Request;

/**
 * Class CoefficientController
 * @package App\Http\Controllers
 */
class CoefficientController extends Controller
{
    use ControllerHelper;

    /**
     * @var CoefficientRepository
     */
    private $CoefficientRepository;


    public function __construct()
    {
        $this->CoefficientRepository = app(CoefficientRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("coefficient.index", [
            "title" => "Коефіцієнти",
            "card_title" => "Коефіцієнти",
            "dataTable" =>  $this->CoefficientRepository->getAll(),
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CoefficientForm::class, [
            "method" => "POST",
            "url" => route("coefficient.store")
        ]);

        return view("coefficient.form", [
            "title" => "Створити коефіцієнт",
            "card_title" => "Створити коефіцієнт",
            "form" => $form
        ]);
    }

    /**
     * @param Request $request
     * @param Coefficient $CoefficientModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Coefficient $CoefficientModel)
    {
        Validator::make($request->input(), ["name" => "required|unique:coefficient,name", "services_items_id" => "required"])->validate();

        $result = $CoefficientModel->store($request->except(["_token", "client_id"]));
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $model = $this->CoefficientRepository->getForEdit($id);

        $form = $formBuilder->create(CoefficientForm::class, [
            "method" => "PUT",
            "url" => route("coefficient.update", $id),
            "model" => $model
        ]);

        return view("coefficient.form", [
            "title" => "Редагувати коефіцієнт - " . $model->name,
            "card_title" => "Редагувати коефіцієнт - " . $model->name,
            "form" => $form
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @param Coefficient $CoefficientModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request, Coefficient $CoefficientModel)
    {
        Validator::make($request->input(), ["name" => "required|unique:coefficient,name,${id}", "value" => "required", "services_items_id" => "required"])->validate();

        $result = $CoefficientModel->store($request->except(["_token", "client_id"]), $id);
        return $this->resultRedirect($result);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $CoefficientModel = Coefficient::find($id);
        $result = $CoefficientModel->delete();

        return $this->resultRedirect($result);
    }
}
