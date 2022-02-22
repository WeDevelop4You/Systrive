<template>
    <group-badges v-model="item.tags" />
</template>

<script>
    import ActionProps from "../../../../mixins/ActionProps";
    import GroupBadges from "../../../items/GroupBadges";

    export default {
        name: "Tags",

        components: {
            GroupBadges
        },

        mixins: [
            ActionProps
        ],
    }
</script>
