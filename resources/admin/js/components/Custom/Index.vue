<template>
    <component
        :is="value.data.type"
        :value="value"
    />
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Index",

        components: {
            LocaleDropdown: () => import('./LocaleDropdown.vue')
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
