<?php

namespace App\Admin\System\DNS\Controllers;

use App\Admin\System\DNS\DataTables\SystemDNSRecordTable;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Enums\VestaCommand;
use Support\Helpers\DataTable\Build\DataTable;
use Support\Services\Vesta;

class SystemDNSRecordTableController extends AbstractTableController
{
    protected string $dataTable = SystemDNSRecordTable::class;

    /**
     * @param Company   $company
     * @param System    $system
     * @param SystemDNS $dns
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemDNS $dns): JsonResponse
    {
        return $this->headers();
    }

    /**
     * @param Company   $company
     * @param System    $system
     * @param SystemDNS $dns
     *
     * @return JsonResponse
     */
    public function action(Company $company, System $system, SystemDNS $dns): JsonResponse
    {
        $records = Vesta::api()
            ->get(VestaCommand::GET_USER_DNS_RECORDS, $system->username, $dns->name);

        return DataTable::create($this->structure())
            ->withoutQuery($records)
            ->export();
    }
}
