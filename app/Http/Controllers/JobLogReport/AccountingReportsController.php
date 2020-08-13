<?php

namespace App\Http\Controllers\JobLogReport;

use App\Exports\JobLogAccountingReportExport;
use App\Exports\JobLogBuhReportExport;
use App\Http\Controllers\Controller;
use App\Repository\RegistryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class AccountingReportsController
 * @package App\Http\Controllers\JobLogReport
 */
class AccountingReportsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("job_log.reporting.accounting_reports.index_form", [
            "title" => "Звіт для бухгалтерії",
            "formData" => [
                "month_list" => __("main.month_list"),
                "clients" => RegistryRepository::client()->getForSelect()
            ]
        ]);
    }

    /**
     * @param $client_id
     * @param null $month
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddedServices($client_id, $month = null)
    {
        $data = RegistryRepository::job_log()->getByClientIdGroupServices($client_id, $month);

        $month = ($month == null) ? date("m") : $month;

        return view("job_log.reporting.accounting_reports.getAddedServices", [
            "title" => "Звіт для бухгалтерії",
            "data" => $data,
            "client_id" => $client_id,
            "month" => $month,
            "client_name" => RegistryRepository::client()->getForEdit($client_id)->name,
            "month_name" => __("main.month_list." . $month)
        ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadReport(Request $request)
    {
        Validator::make($request->input(), ["client_id => required"])->validate();

        $model = RegistryRepository::job_log()->getForAccountingReport($request->client_id, $request->month, $request->remove_from_report);

        dd($model->toArray());

        $export = new JobLogAccountingReportExport();
        $export->setModel($model);
        return Excel::download($export, "job_log_report.xlsx");

    }
}
