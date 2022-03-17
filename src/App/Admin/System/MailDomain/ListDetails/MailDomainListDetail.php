<?php

namespace App\Admin\System\MailDomain\ListDetails;

use Domain\System\Models\SystemMailDomain;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemActive;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\ListDetailsHelper;
use function trans;

class MailDomainListDetail extends AbstractListDetails
{
    protected function __construct(
        private SystemMailDomain $mailDomain
    ) {
        //
    }

    protected function handle(): ListDetailsHelper
    {
        return ListDetailsHelper::create()
            ->addSubheader(trans('word.domain.domain'))
            ->addDetails([
                ListItemText::create('name', trans('word.name.name'), $this->mailDomain->name),
                ListItemText::create('catch_all', trans('word.catch.all'), $this->data->get('CATCHALL')),
                ListItemActive::create('anti_virus', trans('word.anti.virus'))
                    ->setValue($this->data->get('ANTIVIRUS')),
                ListItemActive::create('anti_spam', trans('word.anti.spam'))
                    ->setValue($this->data->get('ANTISPAM')),
                ListItemActive::create('dkim', trans('word.dkim.dkim'))
                    ->setValue($this->data->get('DKIM')),
            ], 2)
            ->addDivider()
            ->addSubheader(trans('word.general.general'))
            ->addDetails([
                ListItemText::create('created_at', trans('word.create_at'))
                    ->setValue("{$this->data->get('DATE')} {$this->data->get('TIME')}"),
                ListItemActive::create('suspended', trans('word.suspended.suspended'))
                    ->setValue($this->data->get('SUSPENDED'), true),
            ], 2);
    }
}
