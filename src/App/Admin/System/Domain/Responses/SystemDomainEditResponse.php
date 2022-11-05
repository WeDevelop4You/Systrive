<?php

namespace App\Admin\System\Domain\Responses;

use App\Admin\System\Domain\Resources\SystemDomainResource;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Support\Arr;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Form\FormType;
use Support\Enums\VestaCommand;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;
use Support\Services\Vesta;

class SystemDomainEditResponse extends AbstractResponse
{
    /**
     * SystemDomainEditResponse constructor.
     *
     * @param Company      $company
     * @param System       $system
     * @param SystemDomain $domain
     */
    protected function __construct(
        private readonly Company $company,
        private readonly System $system,
        private readonly SystemDomain $domain,
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $data = Vesta::api()->get(
            VestaCommand::GET_USER_DOMAIN,
            $this->system->username,
            $this->domain->name
        )->first();

        Arr::set($data, 'NAME', $this->domain->name);

        return Response::create()
            ->addData(SystemDomainResource::make((object) $data))
            ->addPopup(
                FormModal::create('company/system/domain/form', withoutDataTableRefresh: true)
                    ->setPersistent()
                    ->setForm(
                        CustomFormComponent::create()->setType(FormType::DOMAIN_FORM)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company.system.domain.update',
                            route('admin.system.domain.edit', [
                                $this->company->id,
                                $this->system->id,
                                $this->domain->id,
                            ])
                        )
                    )
            );
    }
}
