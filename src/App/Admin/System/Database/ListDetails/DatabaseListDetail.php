<?php

namespace App\Admin\System\Database\ListDetails;

use Domain\System\Models\SystemDatabase;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemActive;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\ListDetailsHelper;

class DatabaseListDetail extends AbstractListDetails
{
    public function __construct(
        private SystemDatabase $database
    ) {
        //
    }

    protected function handle(): ListDetailsHelper
    {
        return ListDetailsHelper::create()
            ->addSubheader(trans('word.database.database'))
            ->addDetails([
                ListItemText::create('name', trans('word.name.name'), $this->database->name),
                ListItemText::create('username', trans('word.username.username'), $this->data->get('DBUSER')),
                ListItemText::create('type', trans('word.type.type'), $this->data->get('TYPE')),
                ListItemText::create('charset', trans('word.charset.charset'), $this->data->get('CHARSET')),
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
