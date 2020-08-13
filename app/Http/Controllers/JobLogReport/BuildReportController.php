<?php

namespace App\Http\Controllers\JobLogReport;

use App\Exports\JobLogReportExport;
use App\Helpers\ControllerHelper;
use App\Http\Controllers\Controller;
use App\Repository\RegistryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BuildReportController extends Controller
{
    use ControllerHelper;


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build()
    {
        $filterData = [
            "client_id" => RegistryRepository::client()->getForSelect(),
        ];
        return view("job_log.reporting.build", [
            "title" => "Звіти",
            "options" => [
                "columns" => RegistryRepository::job_log()->ReportingColumns
            ],
            "filterData" => $filterData,
            "clients" => RegistryRepository::client()->getForSelect(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportReport()
    {
        Validator::make(\request()->input(), ["columns" => "required|array"])->validate();

        $JobLogReportExport = new JobLogReportExport();
        $rawDataTable = RegistryRepository::job_log()->getForReportingRaw(\request()->input());

        $JobLogReportExport->setCollection($rawDataTable->get());
        return Excel::download($JobLogReportExport, "job_log_report.xlsx");
    }
}
