<template>
    <badge
        v-model="item.status.text"
        :color="item.status.color"
    />
</template>

<script>
    import actionProps from "../../../mixins/ActionProps";
    import Badge from "../../items/Badge";

    export default {
        name: "Status",

        components: {
            Badge
        },

        mixins: [
            actionProps
        ]
    }
</script>
