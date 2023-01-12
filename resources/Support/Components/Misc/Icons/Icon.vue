<template>
    <v-icon :color="iconColor">
        {{ component.content.type }}
    </v-icon>
</template>

<script>
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "Icon",

        extends: ComponentBase,

        props: {
            color: {
                type: String,
                default: undefined
            }
        },

        computed: {
            iconColor() {
                return this.color || this.component.attributes.color
            }
        }
    }
</script>
