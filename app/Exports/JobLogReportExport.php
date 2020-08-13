<?php


namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobLogReportExport implements FromCollection
{

    /**
     * @var
     */
    private $collection;

    /**
     * @param Collection $collection
     */
    public function setCollection(Collection $collection): void
    {
        $this->collection = $collection;
    }

    public function collection()
    {
        return $this->collection;
    }
}
