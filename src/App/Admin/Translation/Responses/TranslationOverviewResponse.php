<?php

namespace App\Admin\Translation\Responses;

use Domain\Translation\Mappings\TranslationKeyTableMap;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;
use WeDevelop4You\TranslationFinder\Models\TranslationKey;

class TranslationOverviewResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                ServerTableComponent::create()
                    ->setSearchable()
                    ->setTitle(trans('word.translations'))
                    ->setVuexNamespace('translations/dataTable')
                    ->setHeaderRoute(route('admin.translation.table.headers', [
                        'frontend',
                    ]))
                    ->setItemsRoute(route('admin.translation.table.items', [
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
                            ->setKey(TranslationKeyTableMap::COL_ENVIRONMENT)
                            ->setItems(
                                TranslationKey::select(TranslationKeyTableMap::COL_ENVIRONMENT)
                                    ->distinct()
                                    ->pluck(TranslationKeyTableMap::COL_ENVIRONMENT)
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
                        BtnComponentType::create()
                            ->setColor()
                            ->setTitle(trans('word.publish'))
                            ->setAction(
                                RequestAction::create()
                                    ->post(route('admin.translation.publish'))
                            )
                    )
            );
    }
}
