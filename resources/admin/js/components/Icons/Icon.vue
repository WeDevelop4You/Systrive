<template>
    <v-icon :color="color">
        {{ value.content.type }}
    </v-icon>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Icon",

        mixins: [
            ComponentProperties
        ],

        props: {
            color: {
                type: String,
                default: undefined
            }
        }
    }
</script>
