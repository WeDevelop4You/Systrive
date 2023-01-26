<?php

namespace Domain\Cms\Columns\Types;

use App\Company\Cms\Resources\CmsTableItemFileResource;
use Domain\Cms\Columns\Attributes\FileColumn;
use Domain\Cms\Columns\Attributes\SubValidation;
use Domain\Cms\Columns\Options\FIle\AspectRatios\HeightAspectRatioColumnOption;
use Domain\Cms\Columns\Options\FIle\AspectRatios\WidthAspectRatioColumnOption;
use Domain\Cms\Columns\Options\FIle\Dimensions\HeightDimensionColumnOption;
use Domain\Cms\Columns\Options\FIle\Dimensions\WidthDimensionColumnOption;
use Domain\Cms\Columns\Options\FIle\Extensions\ImageExtensionColumnOption;
use Domain\Cms\Columns\Options\FIle\FileSizeColumnOption;
use Domain\Cms\Columns\Options\FIle\MaxFileColumnOption;
use Domain\Cms\Columns\Options\FIle\MultipleFileColumnOption;
use Domain\Cms\Columns\Options\HintColumnOption;
use Domain\Cms\Columns\Options\LabelColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\File;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\ImageInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Rules\FileExistRule;
use Support\Services\Cms;
use Support\Utils\Validations;

class ImageColumnType extends AbstractColumnType implements FileColumn, SubValidation
{
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new MultipleFileColumnOption(),
            new MaxFileColumnOption(),
            new ImageExtensionColumnOption(),
            new LabelColumnOption(trans('word.aspect_ratio')),
            new WidthAspectRatioColumnOption(),
            new HeightAspectRatioColumnOption(),
            new LabelColumnOption(trans('word.fixed.dimensions')),
            new WidthDimensionColumnOption(),
            new HeightDimensionColumnOption(),
            new HintColumnOption(trans('text.hint.empty.original.size')),
            new FileSizeColumnOption(),
            new RowColColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'custom_image';
    }

    /**
     * {@inheritDoc}
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->getLabel(), $this->getKey())->setFormat(
            fn (CmsModel $data) => $data->files->column($this->getKey())->count()
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        $cms = Cms::getCms();
        $table = Cms::getTable();

        return ImageInputComponent::create()
            ->setDefaultValue([])
            ->setAccept($this->getPropertyValue('types'))
            ->setUploaderRoute(route('company.cms.table.column.image', [
                $cms->company_id,
                $cms->id,
                $table->id,
                $this->column->id,
            ]))
            ->setValue(
                $model->files->column($this->getKey())
                    ->mapInto(CmsTableItemFileResource::class)
                    ->values()
                    ->toArray()
            )
            ->setMultiple(
                $this->getPropertyValue('multiple', false),
                $this->getPropertyValue('max', 5)
            )
            ->setAspectRadio(
                $this->getPropertyValue('aspect_ratio_width', 16),
                $this->getPropertyValue('aspect_ratio_height', 9)
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(
            ['array'],
            ['*' => [
                'name' => new Validations(['required', 'string']),
                'identifier' => new Validations([
                    "required_without:{$this->getKey()}.*.id",
                    'string',
                    new FileExistRule(),
                ]),
            ]]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getSubValidation(FormRequest $request): Validations
    {
        return new Validations([
            File::types($this->getPropertyValue('types', []))
                ->max($this->getPropertyValue('size', 5120))
                ->rules(['required', 'image'])
                ->min(1)
        ]);
    }
}
