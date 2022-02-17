<template>
    <v-card
        :elevation="$config.elevation"
        rounded="lg"
        outlined
    >
        <v-card-title
            class="text-h5"
            v-text="data.title"
        />
        <v-card-text class="pb-0">
            <component
                :is="data.form_component"
                @action="$refs.buttons.runEventAction()"
            />
        </v-card-text>
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
        name: "Form",

        components: {
            ActionButtons,
            Company: () => import(/* webpackChunkName: "layout/forms/popup/complete" */ '../../forms/popup/Complete'),
            RecoveryCode: () => import(/* webpackChunkName: "layout/forms/popup/recovery_code" */ '../../forms/popup/RecoveryCode'),
            OneTimePassword: () => import(/* webpackChunkName: "layout/forms/popup/one_time_password" */ '../../forms/popup/OneTimePassword'),
        },

        props: {
            data: {
                required: true,
                type: Object,
            },
        },
    }
</script>
