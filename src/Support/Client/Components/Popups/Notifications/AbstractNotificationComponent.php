<?php

namespace Support\Client\Components\Popups\Notifications;

use Support\Client\Components\Popups\AbstractPopupComponent;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\IconType;
use Support\Enums\Component\PopupType;
use Support\Enums\Component\Vuetify\VuetifyAlertType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractNotificationComponent extends AbstractPopupComponent
{
    /**
     * @var string
     */
    private string $text;

    protected function __construct()
    {
        parent::__construct();

        $this->setStayable(false);
        $this->setAlertTypeByStatusCode(Response::HTTP_OK);
    }

    /**
     * @return PopupType
     */
    protected function getType(): PopupType
    {
        return PopupType::NOTIFICATION;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): AbstractPopupComponent
    {
        $this->text = $text;

        return $this->setContent('text', $text);
    }

    /**
     * @param VuetifyAlertType $type
     *
     * @return AbstractPopupComponent
     */
    public function setAlertType(VuetifyAlertType $type): AbstractPopupComponent
    {
        return $this->setAttribute('type', $type->value);
    }

    /**
     * @param IconType $icon
     *
     * @return AbstractPopupComponent
     */
    public function setIcon(IconType $icon): AbstractPopupComponent
    {
        return $this->setAttribute('icon', $icon->value);
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return AbstractPopupComponent
     */
    final public function setColor(VuetifyColor|ThemeComponent $color): AbstractPopupComponent
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @param int $time
     *
     * @return AbstractPopupComponent
     */
    public function setDisplayTime(int $time): AbstractPopupComponent
    {
        return $this->setData('displayTime', $time);
    }

    /**
     * @param bool $value
     *
     * @return AbstractPopupComponent
     */
    public function setStayable(bool $value = true): AbstractPopupComponent
    {
        return $this->setData('stayable', $value);
    }

    /**
     * @param string ...$links
     *
     * @return AbstractPopupComponent
     */
    public function insertLinkInText(string ...$links): AbstractPopupComponent
    {
        $text = $this->text;

        foreach ($links as $link) {
            $htmlLink = "<a class='text--primary' href='{$link}' $1>$2</a>";
            $text = preg_replace('\[(.*)?<(s?.*?s?)>]', $htmlLink, $text);
        }

        return $this->setText($text);
    }

    public function setAlertTypeByStatusCode(int $statusCode)
    {
        switch ($statusCode) {
            case 200:
            case 201:
            case 204:
                $this->setAlertType(VuetifyAlertType::SUCCESS);

                break;
            case 403:
                $this->setAlertType(VuetifyAlertType::WARNING);

                break;
            case 400:
            case 401:
            case 404:
            case 422:
                $this->setAlertType(VuetifyAlertType::ERROR);

                break;
            default:
                $this->setAlertType(VuetifyAlertType::INFO);
                $this->setText(trans('response.unknown.status_code'));
        }
    }
}
