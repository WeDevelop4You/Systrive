<template>
    <div class="subtitle-2 font-weight-regular">
        <div class="text--disabled">
            {{ $vuetify.lang.t('$vuetify.text.password.requirements') }}
        </div>
        <ul class="text--disabled">
            <li :class="{'red--text': errors.characters}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.characters') }}</li>
            <li :class="{'red--text': errors.mixedCase}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.mixed_case') }}</li>
            <li :class="{'red--text': errors.number}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.number') }}</li>
            <li :class="{'red--text': errors.symbol}">{{ $vuetify.lang.t('$vuetify.text.password.reset.list.symbol') }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "PasswordRequirements",

        props: {
            errors: {
                required: true,
                type: Object,
            }
        }
    }
</script>
