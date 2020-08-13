<?php

namespace App\Http\Controllers;

use App\Forms\ClientForm;
use App\Helpers\ControllerHelper;
use App\Http\Requests\Client\ClientCreateRequest;
use App\Model\Clients;
use App\Repository\ClientRepository;
use App\Repository\CoefficientRepository;
use App\Repository\RegistryRepository;
use App\Repository\ServicesItemRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    use ControllerHelper;

    /**
     * @var Clients;
     */
    private $ModelClient;

    /**
     * @var ClientRepository
     */
    private $ClientRepository;

    /**
     * @var ServicesItemRepository
     */
    private $ServicesItemRepository;

    /**
     * @var CoefficientRepository
     */
    private $CoefficientRepository;

    /**
     * ClientController constructor.
     */
    public function __construct()
    {
        $this->ModelClient = app(Clients::class);
        $this->ClientRepository = app(ClientRepository::class);
        $this->ServicesItemRepository = app(ServicesItemRepository::class);
        $this->CoefficientRepository = app(CoefficientRepository::class);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $clientDataTable = $this->ClientRepository->getForDataTable();
        return view("client.index", [
            "title" => __("page.client.showAll.title"),
            "table_id" => "client_data_table",
            "card_title" => __("page.client.showAll.title"),
            "clientDataTable" => $clientDataTable,
        ]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return Factory|View
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ClientForm::class, [
            "method" => "post",
            "url" => route("client.store")
        ]);

        return view("layouts.simples.simple_form",
            [
                "form" => $form,
                "title" => __("page.client.title"),
                "card_title" => __("page.client.title"),
            ]
        );
    }

    /**
     * @param ClientCreateRequest $request
     * @return RedirectResponse
     */
    public function store(ClientCreateRequest $request)
    {
        $result = $this->ModelClient->store($request->except("_token"));
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return Factory|View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $formData = $this->ClientRepository->client()->getForEdit($id);
        $form = $formBuilder->create(ClientForm::class, [
            "method" => "PUT",
            "url" => route("client.update", $id),
            "model" => $formData
        ]);

        return view("layouts.simples.simple_form",
            [
                "form" => $form,
                "title" => __("page.client.edit"),
                "card_title" => __("page.client.edit"),
            ]
        );

    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->input(), ["name" => "required|unique:clients,name,$id"])->validate();

        $result = $this->ModelClient->store($request->except(["_token"]), $id);

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Validator::make(['id' => $id], ["id" => "exists:job_log,client_id,NULL"]);
        $result = $this->ModelClient->where("id", $id)->delete();

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function monthlyServicesForm($id)
    {
        $clientInfo = $this->ClientRepository->getForEdit($id);

        $services_item = $this->ServicesItemRepository
            ->getByClientId($id)
            ->whereIn('unit_id', config("my.monthly_services_id"))
            ->pluck("name", "id");

        return view("client.monthly_services",
            [
                "title" => "Щомісячні платежі клієнта - " . $clientInfo->name,
                "card_title" => "Щомісячні платежі клієнта - <strong>" . $clientInfo->name . "</strong>",
                "clientInfo" => $clientInfo,
                "service_item_id" => $services_item,
                "coefficient" => $this->CoefficientRepository->getForSelect(),
            ]
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function monthlyServicesAdd($id, Request $request)
    {
        $clientModel = new Clients();
        $result = $clientModel->store($request->except("_token"), $id);
        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @param $services_item_id
     * @return RedirectResponse
     */
    public function monthlyServicesDelete($id, $services_item_id)
    {
        $clientModel = new Clients();
        $result = $clientModel->delete_monthly_service_item($id, $services_item_id);
        return $this->resultRedirect($result);
    }

}
