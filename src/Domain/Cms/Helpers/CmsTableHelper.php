<?php

namespace Domain\Cms\Helpers;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Http\FormRequest;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Utils\InputColWrapper;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Utils\TooltipComponent;

class CmsTableHelper
{
    public HasMany $query;

    public function __construct(
        private readonly CmsTable $table
    ) {
        $this->query = $table->columns()->orderBy(CmsColumnTableMap::AFTER);
    }

    /**
     * @param CmsTable $table
     *
     * @return static
     */
    public static function create(CmsTable $table): static
    {
        return new static($table);
    }

    /**
     * @param Column $actions
     *
     * @return array
     */
    public function getColumnStructure(Column $actions): array
    {
        $columns = $this->query->get();
        $total = $columns->count() - 1;

        return $columns->map(function (CmsColumn $column, int $index) use ($total) {
            $component = $column->template()->getColumnComponent();

            return $total === $index ? $component->setDivider() : $component;
        })->push($actions)->toArray();
    }

    /**
     * @param CmsModel $model
     * @param bool     $readonly
     *
     * @return FormComponent
     */
    public function getFormStructure(CmsModel $model, bool $readonly = false): FormComponent
    {
        return FormComponent::create()->setInputs(
            $this->query->where(CmsColumnTableMap::EDITABLE, true)->get()
                ->map(function (CmsColumn $column) use ($model, $readonly) {
                    $template = $column->template();

                    return InputColWrapper::create()
                        ->setCol(
                            ColComponent::create()->setMdCol($template->getColValue())
                        )
                        ->setInput(
                            $template->getFormComponent($model)->setReadonly($readonly)
                        );
                })->toArray()
        );
    }

    public static function getFormRules(FormRequest $request): array
    {
        return CmsColumnType::from($request->type)->options()
            ->mapWithKeys(function (AbstractColumnOption $option) use ($request) {
                return [$option->getFormKey() => $option->getRequirements($request)];
            })->toArray();
    }

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    public function getRules(FormRequest $request): array
    {
        return $this->query->where(CmsColumnTableMap::EDITABLE, true)->get()
            ->mapWithKeys(function (CmsColumn $column) use ($request) {
                return [$column->key => $column->template()->getRule($request)];
            })->toArray();
    }
}
