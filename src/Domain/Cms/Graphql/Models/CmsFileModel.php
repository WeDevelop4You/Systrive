<?php

namespace Domain\Cms\Graphql\Models;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsFile;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Field;
use Support\Graphql\Definitions\Types\ModelType;

class CmsFileModel extends ModelType
{
    public function __construct(
        private readonly string $table,
        private readonly CmsColumn $column
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        $name = Str::of($this->table);

        $name = $this->column->type === CmsColumnType::FILE
            ? $name->append('File')
            : $name->append('Image');

        return $name->append('For', Str::ucfirst($this->column->key))
            ->studly()
            ->toString();
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): callable|array
    {
        return [
            Field::create(
                'url',
                Type::string(),
                resolve: fn (CmsFile $root) => Storage::url($root->path)
            )
        ];
    }
}
