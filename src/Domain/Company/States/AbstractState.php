<?php

namespace Domain\Company\States;

use Domain\Invite\Models\Invite;

abstract class AbstractState
{
    /**
     * AbstractStates constructor.
     *
     * @param Invite $invite
     */
    public function __construct(
        protected Invite $invite
    ) {
        //
    }

    /**
     * @param ...$states
     *
     * @return void
     */
    public function changeStateWhen(...$states): void
    {
        if (instanceofArray($this, $states)) {
            $this->changeState();
        }
    }

    abstract public function changeState(): void;
}
