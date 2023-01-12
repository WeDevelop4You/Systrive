<template>
    <v-list-item
        dense
        class="pl-0"
    >
        <v-list-item-content>
            <v-list-item-title
                class="font-weight-bold"
                v-text="component.content.label"
            />
            <v-list-item-subtitle v-text="component.content.value" />
        </v-list-item-content>
    </v-list-item>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Category",

        extends: ComponentBase
    }
</script>
