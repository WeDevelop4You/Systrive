<?php

namespace App\Admin\Translation\Responses;

use Domain\Translation\Mappings\TranslationKeyTableMap;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Forms\InputTypes\SelectInputComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;
use WeDevelop4You\TranslationFinder\Models\TranslationKey;

class TranslationOverviewResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                ServerTableComponent::create()
                    ->setSearchable()
                    ->setTitle(trans('word.translations'))
                    ->setVuexNamespace('translations')
                    ->setHeaderUrl(route('admin.admin.translation.table.headers', [
                        'frontend',
                    ]))
                    ->setItemsUrl(route('admin.admin.translation.table.items', [
                        'frontend',
                    ]))
                    ->setPrependComponent(
                        SelectInputComponent::create()
                            ->setHideDetails()
                            ->setDisabledOnLoading()
                            ->setValue('frontend')
                            ->setLabel(trans('word.environments'))
                            ->setAdditionalStyling('max-width: 150px')
                            ->setVuexNamespace('translations/environmentForm')
                            ->setKey(TranslationKeyTableMap::ENVIRONMENT)
                            ->setItems(
                                TranslationKey::select(TranslationKeyTableMap::ENVIRONMENT)
                                    ->distinct()
                                    ->pluck(TranslationKeyTableMap::ENVIRONMENT)
                                    ->toArray()
                            )
                            ->setChangeAction(
                                VuexAction::create()->dispatch(
                                    'translations/changeEnvironment',
                                    'admin.translation.table.items'
                                )
                            )
                    )
                    ->setAppendComponent(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.publish'))
                            ->setAction(
                                RequestAction::create()
                                    ->post(route('admin.admin.translation.publish'))
                            )
                    )
            );
    }
}
