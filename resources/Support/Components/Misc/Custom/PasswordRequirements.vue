<template>
    <div class="subtitle-2 font-weight-regular">
        <div :class="[error ? 'error--text' : 'text--disabled']">
            {{ $vuetify.lang.t('$vuetify.text.password.requirements') }}
        </div>
        <ul class="text--disabled">
            <li :class="{'error--text': errors.characters}">
                {{ $vuetify.lang.t('$vuetify.text.password.list.characters') }}
            </li>
            <li :class="{'error--text': errors.mixedCase}">
                {{ $vuetify.lang.t('$vuetify.text.password.list.mixed_case') }}
            </li>
            <li :class="{'error--text': errors.number}">
                {{ $vuetify.lang.t('$vuetify.text.password.list.number') }}
            </li>
            <li :class="{'error--text': errors.symbol}">
                {{ $vuetify.lang.t('$vuetify.text.password.list.symbol') }}
            </li>
        </ul>
    </div>
</template>

<script>
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "PasswordRequirements",

        extends: ComponentBase,

        computed: {
            error() {
                const errors = this.errors

                return errors.characters || errors.mixedCase || errors.number || errors.symbol
            },

            errors() {
                return this.$store.getters[`${this.component.data.vuexNamespace}/errors`];
            }
        }
    }
</script>
