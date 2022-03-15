<?php

namespace App\Admin\Company\System\DNS\Controllers;

use App\Admin\Company\System\DNS\DataTables\DNSRecordTable;
use App\Admin\Company\System\DNS\Resources\CompanyDNSRecordResource;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\AbstractTableController;
use Support\Enums\VestaCommands;
use Support\Helpers\Data\Build\DataTable;
use Support\Helpers\Vesta\VestaAPIHelper;

class CompanyDNSRecordTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getTableStructure(): AbstractTable
    {
        return DNSRecordTable::create();
    }

    /**
     * @param Company   $company
     * @param System    $system
     * @param SystemDNS $dns
     *
     * @return AnonymousResourceCollection
     */
    public function items(Company $company, System $system, SystemDNS $dns): AnonymousResourceCollection
    {
        $records = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_DNS_RECORDS, $system->username, $dns->name)
            ->map(fn ($item): object => (object) $item)
            ->toArray();

        return DataTable::withoutQuery($records)
            ->setColumns($this->getTableStructure())
            ->export(CompanyDNSRecordResource::class);
    }
}
