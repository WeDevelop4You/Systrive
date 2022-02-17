<template>
    <v-card>
        <v-card-title
            class="text-h5"
            v-text="data.title"
        />
        <v-card-text v-text="data.text" />
        <v-card-actions>
            <ActionButtons
                ref="buttons"
                :data="data.buttons"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    import ActionButtons from "../../ActionButtons";

    export default {
        name: "Confirm",

        components: {
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
