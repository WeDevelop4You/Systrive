<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Actions\VuexAction;

class OneTimePasswordInputComponent extends AbstractInputComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'OneTimePasswordInputComponent';
    }

    public function setAction(VuexAction $action): static
    {
        return $this->setData('action', $action->export());
    }
}
