<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTemplateTableMap;
use Domain\System\Models\SystemTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\System\SystemTemplateType;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SyncSystemTemplates extends AbstractVestaSync
{
    /**
     * SyncSystemTemplates constructor.
     */
    public function __construct()
    {
        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "system_templates";
    }

    /**
     * @return void
     */
    protected function initialize(): void
    {
        $this->database = SystemTemplate::all();
        $webTemplates = Vesta::api()->get(
            VestaCommand::GET_WEB_TEMPLATES
        )->crossJoin([SystemTemplateType::WEB->value]);

        $dnsTemplates = Vesta::api()->get(
            VestaCommand::GET_DNS_TEMPLATES
        )->crossJoin([SystemTemplateType::DNS->value]);

        $proxyTemplates = Vesta::api()->get(
            VestaCommand::GET_PROXY_TEMPLATES
        )->crossJoin([SystemTemplateType::PROXY->value]);

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
