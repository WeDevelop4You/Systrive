<?php

namespace Support\Response\Actions;

use Ramsey\Uuid\UuidInterface;

class PopupModalAction extends AbstractAction
{
    /**
     * @param UuidInterface|null $identifier
     *
     * @return PopupModalAction
     */
    public function close(UuidInterface|null $identifier = null): PopupModalAction
    {
        return $this->setMethod('actionClosePopupModal')
            ->setData([
                'identifier' => $identifier,
            ]);
    }
}
