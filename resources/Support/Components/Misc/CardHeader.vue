<template>
    <v-app-bar
        v-bind="component.attributes"
        flat
        dense
        class="px-2"
    >
        <v-toolbar-title
            class="text-h6 white--text pl-2"
            v-text="component.content.title"
        />
        <v-spacer />
        <wrapper
            v-if="component.data.button"
            :value="component.data.button"
        />
    </v-app-bar>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";
    import Wrapper from "../Layouts/Wrapper.vue";

    export default {
        name: "CardHeader",

        components: {
            Wrapper,
        },

        extends: ComponentBase,
    }
</script>
