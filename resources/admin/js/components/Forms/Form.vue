<template>
    <row
        :value="value.data.form"
    />
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import Row from "../Layouts/Row.vue";

    export default {
        name: "CustomForm",

        components: {
            Row,
        },

        mixins: [
            ComponentProperties
        ]
    }
</script>
