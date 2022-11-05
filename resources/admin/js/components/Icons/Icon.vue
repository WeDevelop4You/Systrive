<template>
    <v-icon :color="color">
        {{ component.content.type }}
    </v-icon>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Icon",

        extends: ComponentBase,

        props: {
            hoverColor: {
                type: String,
                default: undefined
            }
        },

        computed: {
            color() {
                return this.hoverColor || this.component.attributes.color
            }
        }
    }
</script>
