<?php

namespace App\Admin\System\MailDomain\Controllers;

use App\Admin\System\MailDomain\DataTables\MailDomainAddressTable;
use App\Admin\System\MailDomain\Resources\CompanyMailDomainAddressResource;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\AbstractTableController;
use Support\Enums\VestaCommands;
use Support\Helpers\Data\Build\DataTable;
use Support\Helpers\Vesta\VestaAPIHelper;

class CompanyMailDomainAddressTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getTableStructure(): AbstractTable
    {
        return MailDomainAddressTable::create();
    }

    /**
     * @param Company          $company
     * @param System           $system
     * @param SystemMailDomain $mailDomain
     *
     * @return AnonymousResourceCollection
     */
    public function index(Company $company, System $system, SystemMailDomain $mailDomain): AnonymousResourceCollection
    {
        $addresses = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_MAIL_ADDRESSES, $system->username, $mailDomain->name)
            ->map(fn ($item, $address): object => (object) [...$item, 'EMAIL' => "{$address}@{$mailDomain->name}"])
            ->values()->toArray();

        return DataTable::withoutQuery($addresses)
            ->setColumns($this->getTableStructure())
            ->export(CompanyMailDomainAddressResource::class);
    }
}
