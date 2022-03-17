<template>
    <active-badge v-model="item[header.value]" />
</template>

<script>
    import actionProps from "../../../../../mixins/ActionProps";
    import ActiveBadge from "../../../../items/Active";

    export default {
        name: "Active",

        components: {
            ActiveBadge,
        },

        mixins: [
            actionProps
        ]
    }
</script>
