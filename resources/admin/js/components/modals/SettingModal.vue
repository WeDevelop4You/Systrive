<template>
    <modal-base
        ref="modal"
        v-model="show"
        :width="width"
        persistent
        button-type="button"
    >
        <template #button>
            <v-btn
                small
                outlined
                color="primary"
                @click="open"
            >
                {{ button }}
            </v-btn>
        </template>
        <card-base
            :title="title"
            :no-padding="noPadding"
        >
            <template #button>
                <close-button @close="close" />
            </template>
            <template #subtitle>
                <slot name="subtitle" />
            </template>
            <slot />
            <template #actions v-if="!noAction">
                <save-and-close-buttons
                    @close="close"
                    @save="$emit('save')"
                />
            </template>
        </card-base>
    </modal-base>
</template>

<script>
    import ModalBaseProperties from "../../mixins/ModalBaseProperties";
    import CloseButton from "../CloseButton";
    import SaveAndCloseButtons from "../SaveAndCloseButtons";

    export default {
        name: "SettingModal",

        mixins: [
            ModalBaseProperties,
        ],

        components: {
            CloseButton,
            SaveAndCloseButtons,
        },

        props: {
            width: {
                required: true,
                type: String
            },

            button: {
                required: true,
                type: String
            },

            noAction: {
                type: Boolean,
                default: false
            },

            noPadding: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
