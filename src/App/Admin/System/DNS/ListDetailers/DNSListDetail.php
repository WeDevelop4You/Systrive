<?php

namespace App\Admin\System\DNS\ListDetailers;

use Domain\System\Models\SystemDNS;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemActive;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\ListDetailsHelper;
use function trans;

class DNSListDetail extends AbstractListDetails
{
    public function __construct(
        private SystemDNS $dns
    ) {
        //
    }

    protected function handle(): ListDetailsHelper
    {
        return ListDetailsHelper::create()
            ->addSubheader(trans('word.dns.dns'))
            ->addDetails([
                ListItemText::create('domain', trans('word.domain.domain'), $this->dns->name),
                ListItemText::create('template', trans('word.template.template'), $this->data->get('TPL')),
                ListItemText::create('ttl', trans('word.ttl.ttl'), $this->data->get('TTL')),
                ListItemText::create('soa', trans('word.soa.soa'), $this->data->get('SOA')),
                ListItemText::create('expired', trans('word.expired.expired'), $this->data->get('EXP')),
            ], 2)
            ->addDivider()
            ->addSubheader(trans('word.general.general'))
            ->addDetails([
                ListItemText::create('serial', trans('word.serial.number'), $this->data->get('SERIAL')),
                ListItemText::create('created_at', trans('word.create_at'))
                    ->setValue("{$this->data->get('DATE')} {$this->data->get('TIME')}"),
                ListItemActive::create('suspended', trans('word.suspended.suspended'))
                    ->setValue($this->data->get('SUSPENDED'), true),
            ], 2);
    }
}
