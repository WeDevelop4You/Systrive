<?php

namespace App\Admin\Cms\Forms;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\ComboboxInputComponent;
use Support\Client\Components\Forms\Inputs\PasswordInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Forms\Utils\Logic;

class CmsForm extends AbstractForm
{
    /**
     * @var string
     */
    private string $prefix;

    /**
     * @var Collection
     */
    private Collection $databases;

    /**
     * @var int
     */
    private readonly int $prefixLength;

    public function __construct(
        Company $company,
    ) {
        $this->prefix = "{$company->system->username}_";
        $this->prefixLength = \strlen($this->prefix);

        $this->databases = $company->cms->unique(function (Cms $cms) {
            return $cms->username->decrypt;
        })->sortBy(function (Cms $cms) {
            return $cms->username->decrypt;
        });
    }

    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('name')
                            ->setLabel(trans('word.name.name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('database')
                            ->setHint($this->prefix, true)
                            ->setLabel(trans('word.database.name'))
                            ->setCounter(64 - $this->prefixLength)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        ComboboxInputComponent::create()
                            ->setClearable()
                            ->setItems(
                                $this->databases->map(
                                    fn (Cms $cms): KeyValueObject => KeyValueObject::create()
                                        ->setValue($cms->id)
                                        ->setText(
                                            Str::after($cms->username->decrypt, '_')
                                        )
                                )->toArray()
                            )
                            ->setKey('username')
                            ->setLabel('word.username')
                            ->setHint($this->prefix, true)
                            ->setCounter(32 - $this->prefixLength)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setKey('password')
                            ->setLabel(trans('word.password.password'))
                            ->addHiddenLogic(
                                Logic::contain('username.value')->setValues($this->databases->pluck('id')->toArray())
                            )
                    ),
            ]);
    }
}
