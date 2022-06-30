<?php

namespace Support\Response\Actions;

use Support\Response\Components\Navbar\Helpers\VueRouteHelper;

class BreadcrumbAction extends AbstractAction
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
            'text' => $text,
            'added' => true,
        ];

        if ($route instanceof VueRouteHelper) {
            $data['to'] = $route->export();
        }

        return $this->setMethod('actionBreadcrumbsAdd')
            ->setData($data, true);
    }
}
