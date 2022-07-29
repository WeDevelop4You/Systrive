<template>
    <v-img v-bind="value.attributes" />
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "CImage",

        mixins: [
            ComponentProperties
        ]
    }
</script>
