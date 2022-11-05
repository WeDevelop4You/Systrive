<template>
    <v-select
        v-bind="component.attributes"
        :ref="key"
        :value="getValue"
        :disabled="isDisabled"
        :items="component.data.items"
        :label="component.content.label"
        :error-messages="errorMessages"
        @input="setValue($event)"
    />
</template>

<script>
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "SelectInput",

        extends: FormComponentBase,


        mounted() {
            if (this.isset(this.component.attributes, 'return-object')) {
                this.setValue(this.component.data.items.find(item => item.value === this.getValue))
            }

            if (this.isset(this.component.data, 'changeAction')) {
                this.getRef().$on(
                    'change',
                    () => {
                        this.$actions.call(this.component.data.changeAction)
                    }
                )
            }
        },
    }
</script>
