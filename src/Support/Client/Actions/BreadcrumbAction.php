<?php

namespace Support\Client\Actions;

use Support\Client\Components\Navbar\Helpers\VueRouteHelper;

class BreadcrumbAction extends Action
{
    /**
     * @param string              $text
     * @param VueRouteHelper|null $route
     *
     * @return BreadcrumbAction
     */
    public function add(string $text, ?VueRouteHelper $route = null): BreadcrumbAction
    {
        $data = [
            'label' => $text,
            'additional' => [
                'added' => true,
            ],
        ];

        if ($route instanceof VueRouteHelper) {
            $data['to'] = $route->export();
        }

        return $this->setName('breadcrumbsAddAction')
            ->setData($data, true);
    }
}
