<template>
    <card-base :title="data.title">
        <p v-text="data.text" />
        <template #actions>
            <ActionButtons v-model="data.buttons" />
        </template>
    </card-base>
</template>

<script>
    import ActionButtons from "../../../components/ActionButtons";
    import CardBase from "../../../components/cards/CardBase";

    export default {
        name: "Confirm",

        components: {
            CardBase,
            ActionButtons
        },

        props: {
            data: {
                required: true,
                type: Object,
            }
        },
    }
</script>
