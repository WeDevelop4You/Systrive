<template>
    <v-select
        v-show="isHidden"
        v-bind="component.attributes"
        :ref="key"
        :value="input"
        :disabled="isDisabled"
        :items="component.data.items"
        :label="component.content.label"
        :error-messages="errorMessages"
        :hide-details="hideDetails"
        :class="[{'v-input-hidden': !isHidden}, component.attributes.class]"
        @change="setValue($event)"
    />
</template>

<script>
    import DropdownFormComponentBase from "../../Base/DropdownFormComponentBase";

    export default {
        name: "SelectInput",

        extends: DropdownFormComponentBase,

        mounted() {
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
