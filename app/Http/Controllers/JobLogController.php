<?php

namespace App\Http\Controllers;

use App\Forms\ProjectForm;
use App\Helpers\ControllerHelper;
use App\Http\Requests\JobLog\CreateJobLogRequest;
use App\Model\Clients;
use App\Model\JobLog;
use App\Repository\RegistryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class JobLogController
 * @package App\Http\Controllers
 */
class JobLogController extends Controller
{
    use ControllerHelper;


    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formCreate(FormBuilder $formBuilder)
    {

        $formCreateProject = $formBuilder->create(ProjectForm::class, [
            "attr" => [
                "id" => "formCreateProject"
            ]
        ]);
        return view("job_log.create", [
            "title" => "Додати роботу",
            "card_title" => "Форма",
            "formJobLog" => [
                "service_item_id" => RegistryRepository::services_item()->getForSelect(),
                "user_exec" => RegistryRepository::users()->getForSelect(),
                "project_id" => RegistryRepository::project()->getForSelect(),
                "client_id" => RegistryRepository::client()->getForSelect(),
                "coefficient" => RegistryRepository::coefficient()->getForSelect(),
                "date_time" => Carbon::now()->toDateTimeString()
            ],
            "formCreateProject" => $formCreateProject
        ]);
    }

    /**
     * @param CreateJobLogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateJobLogRequest $request)
    {
        $JobLogModel = new JobLog();
        $result = $JobLogModel->store($request->input());

        return $this->resultRedirect($result);
    }


    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function formUpdate($id, FormBuilder $formBuilder)
    {
        $formCreateProject = $formBuilder->create(ProjectForm::class, [
            "attr" => [
                "id" => "formCreateProject"
            ]
        ]);

        $model = RegistryRepository::job_log()->getForEdit($id)->toArray();

        return view("job_log.update", [
            "title" => "Редагувати роботу",
            "card_title" => "Форма",
            "formJobLog" => [
                "service_item_id" => RegistryRepository::services_item()->getForSelect(),
                "user_exec" => RegistryRepository::users()->getForSelect(),
                "project_id" => RegistryRepository::project()->getForSelect(),
                "client_id" => RegistryRepository::client()->getForSelect(),
                "coefficient" => RegistryRepository::coefficient()->getForSelect(),
                "date_time" => Carbon::now()->toDateTimeString()
            ],
            "formCreateProject" => $formCreateProject,
            "model" => $model,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $JobLogModel = new JobLog();
        $result = $JobLogModel->store($request->input(), $id);

        return $this->resultRedirect($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJobByProject(Request $request)
    {
        $result = RegistryRepository::job_log()->getByProjectId($request->project_id);
        if ($result != NULL) {
            $result = [
                "total" => $result->sum("total_price"),
                "total_pdv" => RegistryRepository::job_log()->calc_pdv($result->sum("total_price")),
                "data" => $result->toArray(),
            ];

        } else {
            $result = ["null"];
        }

        return response()->json($result);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showJobLog(FormBuilder $formBuilder)
    {
        $dataTable = RegistryRepository::job_log()->getForDataTable();

        $filterData = [
            "user_exec" => RegistryRepository::users()->getForSelect(),
            "client_id" => RegistryRepository::client()->getForSelect(),
        ];

        return view("job_log.show", [
            "title" => __("page.job_log.show.title"),
            "card_title" => __("page.job_log.show.title"),
            "dataTable" => $dataTable["dataTable"],
            "total" => $dataTable["total"],
            "filterData" => $filterData,
            "id_data_table" => "jobLogDataTable",
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calcTotalAjax(Request $request)
    {
        Validator::make($request->input(), ["services_item_id" => "required|exists:services_item,id", "coefficient" => "required", "count" => "required|integer"])->validate();

        $data = RegistryRepository::services_item()->getForEdit($request->services_item_id, ['id as services_item_id', 'price'])->toArray();
        $data = $data + ["coefficient" => $request->coefficient, "count" => $request->count];

        $JobLogModel = new JobLog();
        $JobLogModel->prepare_data($data);

        return \response()->json(["total_price" => $JobLogModel->calc_total_price($data)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkMonthlyJobByClientId(Request $request) {
        $result = RegistryRepository::job_log()->checkMonthlyServicesByClientId($request->client_id);
        return \response()->json(!empty($result));
    }

    public function addMonthlyJobByClientId($client_id) {
        $JobLogModel = new JobLog();

        $result = $JobLogModel->addMonthlyServicesByClientId($client_id);

        return view("job_log.addMonthlyResult", [
            "title" => "Щомісячні послуги",
            "card_title" => "Щомісячні послуги",
            "data" => $result,
            "client_id" => $client_id
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        $result = JobLog::whereId($id)->delete();
        return $this->resultRedirect($result);
    }
}
