<template>
    <ModalBase
        ref="modal"
        v-model="show"
        :rerender="rerender"
        fullscreen
        persistent
        hide-overlay
        no-click-animation
        transition="dialog-bottom-transition"
    >
        <card-base
            :title="title"
            :is-loading="$loading"
            :color="$vuetify.theme.dark ? '#121212' : undefined"
            header-color="#272727"
            no-rounded
            no-outlined
        >
            <template #button>
                <close-button @close="close"/>
            </template>
            <div class="my-5">
                <slot/>
            </div>
        </card-base>
    </ModalBase>
</template>

<script>
    import ModalBase from "./ModalBase";
    import CloseButton from "../CloseButton";
    import ModalBaseProperties from "../../mixins/ModalBaseProperties";

    export default {
        name: "ShowModal",

        mixins: [
            ModalBaseProperties
        ],

        components: {
            ModalBase,
            CloseButton
        },
    }
</script>
