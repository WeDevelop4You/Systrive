<template>
    <modal-base
        ref="modal"
        v-model="show"
        :rerender="rerender"
        persistent
        width="700"
    >
        <template #button>
            <slot name="button" />
        </template>
        <card-base
            :title="title"
        >
            <template #button>
                <close-button @close="close" />
            </template>
            <div class="pt-1">
                <slot />
            </div>
            <template #actions>
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
        name: "CreateOrEditModal",

        mixins: [
            ModalBaseProperties,
        ],

        components: {
            CloseButton,
            SaveAndCloseButtons,
        },
    }
</script>
