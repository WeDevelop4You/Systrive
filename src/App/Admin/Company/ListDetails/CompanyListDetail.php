<?php

namespace App\Admin\Company\ListDetails;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\Items\ListItemURL;
use Support\Helpers\Details\ListDetailsHelper;

/**
 * Class CompanyListDetail.
 *
 * @property-read Company $data
 */
class CompanyListDetail extends AbstractListDetails
{
    protected function handle(): ListDetailsHelper
    {
        return ListDetailsHelper::create()
            ->addDetails([
                ListItemText::create('id', trans('word.id.id'), $this->data->id),
                ListItemText::create('name', trans('word.name.name'), $this->data->name),
                ListItemText::create('email', trans('word.email.email'), $this->data->email),
                ListItemURL::create('domain', trans('word.domain.domain'))
                    ->setValue($this->data->domain),
            ])
            ->addDivider()
            ->addDetails([
                ListItemText::create('information', trans('word.information.information'), $this->data->information),
            ]);
    }
}
