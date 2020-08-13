<?php

namespace App\Http\Controllers;

use App\Forms\ImportServicesForm;
use App\Forms\ServicesItemForm;
use App\Helpers\ControllerHelper;
use App\Imports\ServicesImport;
use App\Model\Services\ServicesItem;
use App\Repository\ClientRepository;
use App\Repository\RegistryRepository;
use App\Repository\ServicesGroupRepository;
use App\Repository\ServicesItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

/**
 * Class ServicesItemController
 * @package App\Http\Controllers
 */
class ServicesItemController extends Controller
{
    use ControllerHelper;

    /**
     * @var ServicesItem
     */
    private $ServicesItemModel;

    /**
     * @var ServicesItemRepository
     */
    private $ServicesItemRepository;

    /**
     * @var ServicesGroupRepository
     */
    private $ServicesGroupRepository;

    /**
     * @var ClientRepository
     */
    private $ClientRepository;

    /**
     * ServicesController constructor.
     */
    public function __construct()
    {
        $this->ServicesItemModel = app(ServicesItem::class);
        $this->ServicesItemRepository = app(ServicesItemRepository::class);
        $this->ServicesGroupRepository = app(ServicesGroupRepository::class);
        $this->ClientRepository = app(ClientRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $dataForTable = $this->ServicesItemRepository->getForTable();
        return view("services_item.index", [
            "title" => __("page.service.showAllItem.title"),
            "card_title" => __("page.service.showAllItem.title"),
            "dataForTable" => $dataForTable,
            "table_id" => "services_item",
            "formFilter" => [
                "services_item_client_id" => $this->ClientRepository->getForSelect(),
                "service_group_id" => $this->ServicesGroupRepository->getForSelect()
            ]
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ServicesItemForm::class, [
            "method" => "POST",
            "url" => route("services.item.store"),
        ]);

        return view("services_item.create",
            [
                "form" => $form,
                "title" => __("page.services.item.create.title"),
                "card_title" => __("page.services.item.create.title"),
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->input(), [
            "name" => "required|unique:services_item,name",
            "price" => "required",
            "unit_id" => "required|exists:units,id",
            "service_group_id" => "required|exists:services_group,id",
        ])->validate();

        $result = $this->ServicesItemModel->store($request->except(["_token"]));
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $model = RegistryRepository::services_item()->getForEdit($id);
        $form = $formBuilder->create(ServicesItemForm::class, [
            "method" => "PUT",
            "url" => route("services.item.update", $id),
            "model" => $model,
        ]);

        $servicesGroups = $this->ServicesGroupRepository
            ->getByClientId($model->client_id,["services_group.id as id", DB::raw("CONCAT_WS('',`clients`.`short_name`, ' - ' ,`services_group`.`name`) as name")])
            ->pluck("name", "id")
            ->toArray();

        $form->modify("service_group_id", "select", [
            'choices' => $servicesGroups,
            'attr' => [
                "class" => "form-control select2",
                "id" => "services_group_id"
            ],
        ], true);

        return view("services_item.update",
            [
                "form" => $form,
                "title" => __("page.services.item.update.title"),
                "card_title" => __("page.services.item.update.title"),
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
        Validator::make($request->input(), [
            "name" => "required",
            "price" => "required",
            "unit_id" => "required|exists:units,id",
            "service_group_id" => "required|exists:services_group,id",
        ])->validate();

        $result = $this->ServicesItemModel->store($request->except(["_token"]), $id);
        return $this->resultRedirect($result);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = $this->ServicesItemModel->is_deleted($id);
        return $this->resultRedirect($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesItem(Request $request)
    {
        $result = RegistryRepository::services_item()->getForCreateJob($request->id);
        $result = ($result !== NULL) ? $result->toArray() : ["null"];
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesItemByClientId(Request $request)
    {
        $result = $this->ServicesItemRepository->getByClientId($request->client_id, ["id", "name as text"]);
        $result = ($result !== NULL) ? ["results" => $result->toArray(), "pagination" => ["more" => false]] : ["null"];
        return response()->json($result);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formImport(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ImportServicesForm::class, [
            "method" => "POST",
            "enctype" => "multipart/form-data",
        ]);

        return view("layouts.simples.simple_form", [
            "form" => $form,
            "title" => __("page.services.import"),
            "card_title" => __("page.services.import"),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Storage::disk("local")->putFileAs("tmp/", $request->file("xlsx_file"), "import_services.xlsx");

        $ServicesItemImport = new ServicesImport();
        $array = Excel::toArray($ServicesItemImport, 'tmp\import_services.xlsx');

        $ModelServicesItem = new ServicesItem();
        $ModelServicesItem->import($array[0]);

        return redirect()->back()->with("message", __("main.Success"));
    }
}
