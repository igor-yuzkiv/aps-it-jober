<?php

namespace App\Http\Controllers;

use App\Forms\ProjectForm;
use App\Helpers\ControllerHelper;
use App\Model\Projects;
use App\Repository\JobLogRepository;
use App\Repository\ProjectRepository;
use App\Repository\RegistryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;
/**
 * Class ProjectController
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    use ControllerHelper;

    /**
     * @var ProjectRepository
     */
    private $ProjectRepository;

    /**
     * @var JobLogRepository
     */
    private $JobLogRepository;

    public function __construct()
    {
        $this->ProjectRepository = app(ProjectRepository::class);
        $this->JobLogRepository = app(JobLogRepository::class);

    }


    /**
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(FormBuilder $formBuilder)
    {
        $formCreateProject = $formBuilder->create(ProjectForm::class, [
            "attr" => [
                "id" => "formCreateProject"
            ]
        ]);

        return view("projects.index", [
            "title" => __("page.project.showAll.title"),
            "table_id" => "project_data_table",
            "card_title" => __("page.project.showAll.title"),
            "projectDataTable" => $this->ProjectRepository->getAll(),
            "formCreateProject" => $formCreateProject,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAjax(Request $request)
    {
        $validation = Validator::make($request->input(), ["name" => "required|unique:projects,name"]);

        if ($validation->passes()) {
            $ProjectModel = new Projects();
            $result = $ProjectModel->store($request->input());
            return response()->json(["result" => $result]);
        } else {
            return response()->json($validation->errors()->all(), 422);
        }
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $formData = $this->ProjectRepository->getForEdit($id);
        $form = $formBuilder->create(ProjectForm::class, [
            "method" => "PUT",
            "url" => route("project.update", $id),
            "model" => $formData
        ]);

        $form->add("submit", "submit", ["label" => __("basic.label.save"), "attr" => ["class" => "form-control btn-success"]]);

        return view("layouts.simples.simple_form",
            [
                "form" => $form,
                "title" => __("page.client.edit"),
                "card_title" => __("page.client.edit"),
            ]
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        Validator::make($request->input(), ["name" => "required|unique:projects,name,$id"])->validate();
        $ProjectModel = new Projects();
        $result = $ProjectModel->store($request->except(["_token"]), $id);

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = Projects::where("id", $id)->delete();

        return ($result)
            ? redirect()->route("project.index")->with("message", __("basic.messages.success"))
            : redirect()->route("project.index")->withErrors([__("basic.messages.error")]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id)
    {
        $ProjectModel = new Projects();
        $result = $ProjectModel->closeProject($id);

        return $this->resultRedirect($result);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details_info($id) {
        $dataTable = $this->JobLogRepository->getByProjectId($id);
        $project = $this->ProjectRepository->getForEdit($id);

        return view("projects.details_info", [
            "title" => "Виконанні роботи за проектом - ".$project->name,
            "card_title" => "Виконанні роботи за проектом - <strong>".$project->name."</strong>",
            "dataTable" => $dataTable,
            "total" => $dataTable->sum("total_price"),
            "total_pdv" => $this->JobLogRepository->calc_pdv($dataTable->sum("total_price")),
            "project_info" => $project
        ]);
    }


}
