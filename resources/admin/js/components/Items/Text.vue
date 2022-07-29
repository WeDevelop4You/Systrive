<template>
    <p :class="value.data.classes">
        {{ value.content.value }}
    </p>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Badge",

        mixins: [
            ComponentProperties
        ]
    }
</script>
