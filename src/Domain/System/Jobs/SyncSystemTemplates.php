<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTemplateTableMap;
use Domain\System\Models\SystemTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\System\SystemTemplateTypes;
use Support\Enums\VestaCommands;
use Support\Services\Vesta;

;

class SyncSystemTemplates extends AbstractVestaSync
{
    public function uniqueId(): string
    {
        return "system_templates";
    }

    /**
     * @return void
     */
    protected function setup(): void
    {
        $this->database = SystemTemplate::all();
        $webTemplates = Vesta::api()->get(
            VestaCommands::GET_WEB_TEMPLATES
        )->crossJoin([SystemTemplateTypes::WEB->value]);

        $dnsTemplates = Vesta::api()->get(
            VestaCommands::GET_DNS_TEMPLATES
        )->crossJoin([SystemTemplateTypes::DNS->value]);

        $proxyTemplates = Vesta::api()->get(
            VestaCommands::GET_PROXY_TEMPLATES
        )->crossJoin([SystemTemplateTypes::PROXY->value]);

        $this->vesta = Collection::make([
            ...$webTemplates,
            ...$dnsTemplates,
            ...$proxyTemplates,
        ])->map(function (array $data) {
            return [
                SystemTemplateTableMap::TYPE => $data[1],
                SystemTemplateTableMap::VALUE => strtolower($data[0]),
            ];
        });
    }

    /**
     * @param Model|SystemTemplate $model
     *
     * @return bool
     */
    protected function contains(SystemTemplate|Model $model): bool
    {
        return $this->vesta->contains(SystemTemplateTableMap::VALUE, $model->value);
    }

    /**
     * @param Model|SystemTemplate $model
     *
     * @return Collection
     */
    protected function reject(SystemTemplate|Model $model): Collection
    {
        return $this->vesta->reject(function ($data) use ($model) {
            return (
                $model->type === $data[SystemTemplateTableMap::TYPE] &&
                $model->value === $data[SystemTemplateTableMap::VALUE]
            );
        });
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $systemTemplate = new SystemTemplate();

        $systemTemplates = $this->vesta->map(function (array $data) use ($systemTemplate) {
            $systemTemplate->fill($data);

            return $systemTemplate->attributesToArray();
        })->toArray();

        SystemTemplate::upsert(
            $systemTemplates,
            [
                SystemTemplateTableMap::TYPE,
                SystemTemplateTableMap::VALUE,
            ]
        );
    }
}
