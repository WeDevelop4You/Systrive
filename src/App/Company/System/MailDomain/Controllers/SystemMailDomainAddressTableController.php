<?php

namespace App\Company\System\MailDomain\Controllers;

use App\Company\System\MailDomain\DataTables\SystemMailDomainAddressTable;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SystemMailDomainAddressTableController extends AbstractTableController
{
    protected string $dataTable = SystemMailDomainAddressTable::class;

    /**
     * @param Company          $company
     * @param System           $system
     * @param SystemMailDomain $mailDomain
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemMailDomain $mailDomain): JsonResponse
    {
        return $this->headers();
    }

    /**
     * @param Company          $company
     * @param System           $system
     * @param SystemMailDomain $mailDomain
     *
     * @return JsonResponse
     */
    public function action(Company $company, System $system, SystemMailDomain $mailDomain): JsonResponse
    {
        $addresses = Vesta::api()
            ->get(VestaCommand::GET_USER_MAIL_ADDRESSES, $system->username, $mailDomain->name)
            ->map(fn ($item, $address) => [...$item, 'email' => "{$address}@{$mailDomain->name}"])
            ->values();

        return Table::create($this->structure())
            ->withoutQuery($addresses)
            ->export();
    }
}
