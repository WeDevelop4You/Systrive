<template>
    <card-base
        :title="data.title"
    >
        <component
            :is="data.form_component"
            @action="$refs.actions.runEventAction()"
        />
        <template #actions>
            <ActionButtons
                ref="actions"
                v-model="data.buttons"
            />
        </template>
    </card-base>
</template>

<script>
    import ActionButtons from "../../../components/ActionButtons";
    import CardBase from "../../../components/cards/CardBase";

    export default {
        name: "Form",

        components: {
            CardBase,
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
