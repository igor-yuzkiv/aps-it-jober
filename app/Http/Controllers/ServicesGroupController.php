<?php

namespace App\Http\Controllers;

use App\Forms\ServicesGroupForm;
use App\Helpers\ControllerHelper;
use App\Model\Services\ServicesGroup;
use App\Repository\RegistryRepository;
use App\Repository\ServicesGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class ServicesGroupController
 * @package App\Http\Controllers
 */
class ServicesGroupController extends Controller
{
    use ControllerHelper;

    /**
     * @var ServicesGroupRepository
     */
    private $ServicesGroupRepository;

    public function __construct()
    {
        $this->ServicesGroupRepository = app(ServicesGroupRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("services_group.index", [
            "title" => __("page.service.showAllGroup.title"),
            "card_title" => __("page.service.showAllGroup.title"),
            "dataForTable" => $this->ServicesGroupRepository->getAll(),
            "table_id" => "services_group"
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ServicesGroupForm::class, [
            "method" => "POST",
            "url" => route("services.group.store"),
        ]);

        return view($this->__DefaultFormView,
            [
                "form" => $form,
                "title" => "Додати групу послуг",
                "card_title" => "Додати групу послуг",
            ]
        );

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->input(), ["name" => "required"])->validate();

        $ServicesGroupModel = new ServicesGroup();
        $result = $ServicesGroupModel->store($request->except("_token"));
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $mode = $this->ServicesGroupRepository->getForEdit($id);
        $form = $formBuilder->create(ServicesGroupForm::class, [
            "method" => "PUT",
            "url" => route("services.group.update", $id),
            "model" => $mode
        ]);

        return view($this->__DefaultFormView,
            [
                "form" => $form,
                "title" => "Редагувати групу послуг",
                "card_title" => "Редагувати групу послуг",
            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->input(), ["name" => "required"])->validate();

        $ServicesGroupModel = new ServicesGroup();
        $result = $ServicesGroupModel->store($request->except("_token"), $id);
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param ServicesGroup $servicesGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, ServicesGroup $servicesGroup)
    {
        return $this->resultRedirect($servicesGroup->is_deleted($id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesGroupByClientId(Request $request)
    {
        $result = $this->ServicesGroupRepository->getByClientId(
            $request->client_id,
            [
                "services_group.id as id",
                DB::raw("CONCAT_WS('',`clients`.`short_name`, ' - ' ,`services_group`.`name`) as text")
            ]
        );

        $result = ($result !== NULL) ? ["results" => $result->toArray(), "pagination" => ["more" => false]] : ["null"];
        return response()->json($result);
    }
}
