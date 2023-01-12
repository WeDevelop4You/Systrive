<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTemplateTableMap;
use Domain\System\Models\SystemTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\System\SystemTemplateType;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
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
    public function getName(): string
    {
        return "Sync system templates";
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "system_templates";
    }

    /**
     * @throws VestaConnectionFailedException
     * @return void
     */
    protected function initialize(): void
    {
        $this->data = SystemTemplate::all();
        $webTemplates = Vesta::api()->get(
            VestaCommand::GET_WEB_TEMPLATES
        )->crossJoin([SystemTemplateType::WEB->value]);

        $dnsTemplates = Vesta::api()->get(
            VestaCommand::GET_DNS_TEMPLATES
        )->crossJoin([SystemTemplateType::DNS->value]);

        $proxyTemplates = Vesta::api()->get(
            VestaCommand::GET_PROXY_TEMPLATES
        )->crossJoin([SystemTemplateType::PROXY->value]);

        $this->syncData = Collection::make([
            ...$webTemplates,
            ...$dnsTemplates,
            ...$proxyTemplates,
        ])->map(function (array $data) {
            return [
                SystemTemplateTableMap::COL_TYPE => $data[1],
                SystemTemplateTableMap::COL_VALUE => strtolower($data[0]),
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
        return $this->syncData->contains(SystemTemplateTableMap::COL_VALUE, $model->value);
    }

    /**
     * @param Model|SystemTemplate $model
     *
     * @return Collection
     */
    protected function reject(SystemTemplate|Model $model): Collection
    {
        return $this->syncData->reject(function ($data) use ($model) {
            return (
                $model->type === $data[SystemTemplateTableMap::COL_TYPE] &&
                $model->value === $data[SystemTemplateTableMap::COL_VALUE]
            );
        });
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $systemTemplates = $this->syncData->map(function (array $data) {
            $systemTemplate = new SystemTemplate();
            $systemTemplate->fill($data);

            return $systemTemplate->attributesToArray();
        })->toArray();

        SystemTemplate::upsert(
            $systemTemplates,
            [
                SystemTemplateTableMap::COL_TYPE,
                SystemTemplateTableMap::COL_VALUE,
            ]
        );
    }
}
