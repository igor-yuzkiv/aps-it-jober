<?php

namespace App\Http\Controllers;

use App\Forms\UnitsForm;
use App\Helpers\ControllerHelper;
use App\Repository\RegistryRepository;
use App\Repository\UnitsRepository;
use Illuminate\Http\Request;
use App\Model\Units;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class UnitsController
 * @package App\Http\Controllers
 */
class UnitsController extends Controller
{
    use ControllerHelper;

    /**
     * @var UnitsRepository
     */
    private $UnitsRepository;

    public function __construct()
    {
        $this->UnitsRepository = app(UnitsRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("units.index", [
            "title" => "Одиниці виміру",
            "card_title" => "Одиниці виміру",
            "dataTable" => $this->UnitsRepository->getAll()
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UnitsForm::class, [
            "method" => "POST",
            "url" => route("units.store"),
        ]);

        return view($this->__DefaultFormView, [
            "title" => "Додати одиницю виміру",
            "card_title" => "Додати одиницю виміру",
            "form" => $form,
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->input(), ["name" => "required|unique:units,name"])->validate();

        $UnitsModel = new Units();
        $result = $UnitsModel->store($request->except("_token"));

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $model = $this->UnitsRepository->getForEdit($id);

        $form = $formBuilder->create(UnitsForm::class, [
            "method" => "PUT",
            "url" => route("units.update", $id),
            "model" => $model,
        ]);

        return view($this->__DefaultFormView, [
            "title" => "Редагувати одиницю виміру - " . $model->name,
            "card_title" => "Редагувати одиницю виміру - " . $model->name,
            "form" => $form,
        ]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        Validator::make($request->input(), ["name" => "required|unique:units,name,$id"])->validate();

        $UnitsModel = new Units();
        $result = $UnitsModel->store($request->except("_token"), $id);

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = Units::whereId($id)->delete();
        return $this->resultRedirect($result);
    }
}
