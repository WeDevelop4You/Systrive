<?php

namespace App\Admin\Translation\Forms;

use Domain\Translation\Models\TranslationKey;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Misc\GroupBadgesComponent;

class TranslationForm extends AbstractForm
{
    /**
     * TranslationForm constructor.
     *
     * @param TranslationKey $translationKey
     */
    public function __construct(
        private readonly TranslationKey $translationKey
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        $form = FormComponent::create()
            ->setItems([
                ColComponent::create()
                    ->setComponent(
                        GroupBadgesComponent::create()->convertArray(
                            $this->translationKey->tags->map(fn (string $value) => ucfirst($value))->toArray()
                        )
                    ),
                ColComponent::create()
                    ->setDefaultCol(6)
                    ->setComponent(
                        CustomComponent::create()
                            ->setType('CategoryComponent')
                            ->setContent('label', trans('word.environment.environment'))
                            ->setContent('value', $this->translationKey->environment)
                    ),
                ColComponent::create()
                    ->setDefaultCol(6)
                    ->setComponent(
                        CustomComponent::create()
                            ->setType('CategoryComponent')
                            ->setContent('label', trans('word.group.group'))
                            ->setContent('value', $this->translationKey->group)
                    ),
                ColComponent::create()
                    ->setDefaultCol(6)
                    ->setComponent(
                        CustomComponent::create()
                            ->setType('CategoryComponent')
                            ->setContent('label', trans('word.key.key'))
                            ->setContent('value', $this->translationKey->key)
                    ),
            ]);

        Config::collect('translation.locales')->each(function (string $locale) use ($form) {
            $form->addItem(
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey("translations[{$locale}].translation")
                            ->setLabel(Str::upper($locale))
                    )
            );
        });

        return $form->addItem(
            ColComponent::create()
                ->setComponent(
                    CustomComponent::create()
                        ->setType('SourceExpansionComponent')
                        ->setContent('label', trans('word.translation.sources'))
                        ->setData('sources', $this->translationKey->sources->pluck('source')->toArray())
                ),
        );
    }
}
