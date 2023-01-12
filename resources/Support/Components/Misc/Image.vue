<template>
    <v-img v-bind="component.attributes">
        <template #placeholder>
            <v-row
                class="fill-height ma-0"
                align="center"
                justify="center"
            >
                <v-progress-circular
                    indeterminate
                    color="grey lighten-5"
                />
            </v-row>
        </template>
    </v-img>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "LazyImage",

        extends: ComponentBase,
    }
</script>
