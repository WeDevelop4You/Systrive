<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Attributes\CustomValidation;
use Domain\Cms\Columns\Attributes\FileColumn;
use Domain\Cms\Columns\Options\FIle\FileExtensionColumnOption;
use Domain\Cms\Columns\Options\FIle\FileSizeColumnOption;
use Domain\Cms\Columns\Options\FIle\MaxFileColumnOption;
use Domain\Cms\Columns\Options\FIle\MultipleFileColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\File;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\FileInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Services\Cms;
use Support\Utils\Validations;

class FileColumnType extends AbstractColumnType implements FileColumn, CustomValidation
{
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new MultipleFileColumnOption(),
            new MaxFileColumnOption(),
            new FileExtensionColumnOption(),
            new FileSizeColumnOption(),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'custom_file';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setFormat(function (CmsModel $data) {
                return 'test';
            });
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        $cms = Cms::getCms();
        $table = Cms::getTable();

        return FileInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setUploaderRoute(route('company.cms.table.column.file', [
                $cms->company_id,
                $cms->id,
                $table->id,
                $this->column->id
            ]))
            ->setAccept($this->getPropertyValue('types'))
            ->setMultiple(
                $this->getPropertyValue('multiple', false),
                $this->getPropertyValue('max', 5)
            );
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(
            ['array'],
            ['*' => [
                'name' => new Validations(['required', 'string']),
                'identifier' => new Validations(['required', 'string'])
            ]]
        );
    }

    /**
     * @inheritDoc
     */
    public function getCustomValidation(FormRequest $request): Validations
    {
        return new Validations([
            'required',
            File::types($this->getPropertyValue('types', []))
                ->max($this->getPropertyValue('size', 5120))
                ->min(1)
        ]);
    }
}
