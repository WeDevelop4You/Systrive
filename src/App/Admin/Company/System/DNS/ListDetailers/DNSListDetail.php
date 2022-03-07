<?php

namespace App\Admin\Company\System\DNS\ListDetailers;

use Domain\System\Models\SystemDNS;
use Support\Abstracts\AbstractListDetails;
use Support\Helpers\Details\Items\ListItemText;
use Support\Helpers\Details\ListDetailsHelper;

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
            ]);
    }
}
