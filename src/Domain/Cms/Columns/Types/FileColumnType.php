<?php

namespace Domain\Cms\Columns\Types;

use App\Company\Cms\Resources\CmsTableItemFileResource;
use Domain\Cms\Columns\Definitions\FileColumn;
use Domain\Cms\Columns\Definitions\SubValidation;
use Domain\Cms\Columns\Options\FIle\Extensions\FileExtensionColumnOption;
use Domain\Cms\Columns\Options\FIle\FileSizeColumnOption;
use Domain\Cms\Columns\Options\FIle\MaxFileColumnOption;
use Domain\Cms\Columns\Options\FIle\MultipleFileColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Graphql\Models\CmsFileModel;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\File;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\FileInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Rules\FileExistRule;
use Support\Services\Cms;
use Support\Utils\Validations;

class FileColumnType extends AbstractColumnType implements FileColumn, SubValidation
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
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'custom_file';
    }

    /**
     * {@inheritDoc}
     */
    protected function graphqlType(string $table): ObjectType|ListOfType|ScalarType
    {
        return Type::listOf(
            CmsFileModel::create($table, $this->column)
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function graphqlResolve(): callable|null
    {
        return fn (CmsModel $root) => $root->files->column($this->getKey());
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

        return FileInputComponent::create()
            ->setDefaultValue([])
            ->setAccept($this->getPropertyValue('types'))
            ->setUploaderRoute(route('company.cms.table.column.file', [
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
                ->rules(['required'])
                ->min(1),
        ]);
    }
}
