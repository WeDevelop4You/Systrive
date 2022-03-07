<?php

namespace App\Admin\Company\System\Domain\ListDetails;

use Domain\System\Models\SystemDomain;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemActive;
use Support\Helpers\Details\Items\ListItemBadges;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\Items\ListItemURL;
use Support\Helpers\Details\ListDetailsHelper;

class DomainListDetail extends AbstractListDetails
{
    protected function __construct(
        private SystemDomain $domain
    ) {
        //
    }

    protected function handle(): ListDetailsHelper
    {
        return ListDetailsHelper::create()
            ->addSubheader(trans('word.domain.domain'))
            ->addDetails([
                ListItemURL::create('domain', trans('word.domain.domain'))
                    ->setValue($this->domain->name),
                ListItemBadges::create('aliases', trans('word.aliases.aliases'))
                    ->setValue($this->getArray('ALIAS')),
                ListItemActive::create('ssl', trans('word.ssl.ssl'))
                    ->setValue($this->data->get('SSL')),
                ListItemText::create('domain_template', trans('word.template.template'), $this->data->get('TPL')),
            ])
            ->addDivider()
            ->addSubheader(trans('word.proxy.proxy'))
            ->addDetails([
                ListItemText::create('proxy_template', trans('word.template.template'), $this->data->get('PROXY')),
                ListItemBadges::create('extensions', trans('word.extensions.extensions'))
                    ->setValue($this->getArray('PROXY_EXT')),
            ])
            ->addDivider()
            ->addSubheader(trans('word.general.general'))
            ->addDetails([
                ListItemActive::create('suspended', trans('word.suspended.suspended'))
                    ->setValue($this->data->get('SUSPENDED')),
                ListItemText::create('created_at', trans('word.create_at'))
                    ->setValue("{$this->data->get('DATE')} {$this->data->get('TIME')}"),
            ]);
    }

    private function getArray(string $key): string|array
    {
        $data = $this->data->get($key);

        if (empty($data)) {
            return [];
        }

        return $data;
    }
}
