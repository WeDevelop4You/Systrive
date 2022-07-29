<?php

namespace App\Admin\System\MailDomain\Controllers;

use App\Admin\System\MailDomain\DataTables\SystemMailDomainAddressTable;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Enums\VestaCommands;
use Support\Helpers\DataTable\Build\DataTable;
use Support\Services\Vesta;

class SystemMailDomainAddressTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getDataTable(): AbstractTable
    {
        return SystemMailDomainAddressTable::create();
    }

    /**
     * @param Company          $company
     * @param System           $system
     * @param SystemMailDomain $mailDomain
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemMailDomain $mailDomain): JsonResponse
    {
        $addresses = Vesta::api()
            ->get(VestaCommands::GET_USER_MAIL_ADDRESSES, $system->username, $mailDomain->name)
            ->map(fn ($item, $address) => [...$item, 'email' => "{$address}@{$mailDomain->name}"])
            ->values();

        return DataTable::create($this->getDataTable())
            ->withoutQuery($addresses)
            ->export();
    }
}
