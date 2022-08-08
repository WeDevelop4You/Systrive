<template>
    <v-select
        v-model="data[key]"
        v-bind="value.attributes"
        :disabled="isDisabled"
        :items="value.data.items"
        :label="value.content.label"
        @change="$actions.call(value.data.changeAction)"
    />
</template>

<script>
    import FormProperties from "../../../mixins/Form/FormProperties";

    export default {
        name: "SelectInput",

        mixins: [
            FormProperties
        ],
    }
</script>
