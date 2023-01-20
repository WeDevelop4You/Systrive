<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;

class GroupBadgesComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'GroupBadgesComponent';
    }

    /**
     * @param array $badges
     *
     * @return $this
     */
    public function setBadges(array $badges): static
    {
        foreach ($badges as $badge) {
            if ($badge instanceof BadgeComponent) {
                $this->addBadge($badge);
            }
        }

        return $this;
    }

    /**
     * @param BadgeComponent $badge
     *
     * @return GroupBadgesComponent
     */
    public function addBadge(BadgeComponent $badge): static
    {
        return $this->setData('badges', $badge->export(), true);
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function convertArray(array $values): static
    {
        foreach ($values as $value) {
            $this->addBadge(
                BadgeComponent::create()->setValue($value)->setOutlined()
            );
        }

        return $this;
    }
}
