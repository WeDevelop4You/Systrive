<?php

namespace App\Admin\System\DNS\Controllers;

use App\Admin\System\DNS\DataTables\SystemDNSRecordTable;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Enums\VestaCommands;
use Support\Helpers\Data\Build\DataTable;
use Support\Services\Vesta;

class SystemDNSRecordTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getDataTable(): AbstractTable
    {
        return SystemDNSRecordTable::create();
    }

    /**
     * @param Company   $company
     * @param System    $system
     * @param SystemDNS $dns
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemDNS $dns): JsonResponse
    {
        $records = Vesta::api()
            ->get(VestaCommands::GET_USER_DNS_RECORDS, $system->username, $dns->name);

        return DataTable::create($this->getDataTable())
            ->withoutQuery($records)
            ->export();
    }
}
