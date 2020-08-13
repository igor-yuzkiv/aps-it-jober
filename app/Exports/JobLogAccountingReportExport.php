<?php


namespace App\Exports;


use App\Repository\RegistryRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class JobLogAccountingReportExport implements FromView
{
    /**
     * @var Collection
     */
    private $Collection;

    /**
     * @param mixed $model
     */
    public function setModel(Collection $Collection): void
    {
        $this->Collection = $Collection;
    }


    public function view(): View
    {
        return view("exports_xls.JobLogBuhReportExport", [
            "dataTable" => $this->Collection,
            "total" => $this->Collection->sum("total_price"),
            "total_pdv" => RegistryRepository::job_log()->calc_pdv($this->Collection->sum("total_price")),
        ]);
    }
}
