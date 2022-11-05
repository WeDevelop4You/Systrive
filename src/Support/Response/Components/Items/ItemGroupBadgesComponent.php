<?php

namespace Support\Response\Components\Items;

class ItemGroupBadgesComponent extends AbstractItemComponent
{
    /**
     * @inheritDoc
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
    public function setBadges(array $badges): ItemGroupBadgesComponent
    {
        foreach ($badges as $badge) {
            if ($badge instanceof  ItemBadgeComponent) {
                $this->addBadge($badge);
            }
        }

        return $this;
    }

    /**
     * @param ItemBadgeComponent $badge
     *
     * @return ItemGroupBadgesComponent
     */
    public function addBadge(ItemBadgeComponent $badge): ItemGroupBadgesComponent
    {
        return $this->setData('badges', $badge->export(), true);
    }

    /**
     * @param string $value
     * @param string $separator
     *
     * @return $this
     */
    public function convertStringArray(string $value, string $separator = ','): ItemGroupBadgesComponent
    {
        if (empty($value)) {
            return $this->addBadge(
                ItemBadgeComponent::create()
                    ->setValue(trans('word.no_content'))
                    ->setOutlined()
            );
        }

        return $this->convertArray(explode($separator, $value));
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function convertArray(array $values): ItemGroupBadgesComponent
    {
        foreach ($values as $value) {
            $this->addBadge(
                ItemBadgeComponent::create()->setValue($value)->setOutlined()
            );
        }

        return $this;
    }
}
