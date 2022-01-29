<template>
    <div>{{ itemIndex }}</div>
</template>

<script>
    import ActionProps from "../../../mixins/ActionProps";

    export default {
        name: "Index",

        mixins: [
            ActionProps
        ]
    }
</script>
