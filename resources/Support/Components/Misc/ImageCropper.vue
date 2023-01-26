<template>
    <v-row
        class="fill-height"
        align="center"
        justify="center"
        no-gutters
    >
        <v-progress-circular
            v-show="loading"

            indeterminate
            color="grey lighten-5"
        />
        <cropper
            ref="cropper"
            :src="image"
            :move-image="false"
            :resize-image="false"
            :stencil-props="stencilProps"
            class="cropper-height"
            @change="change"
            @ready="loading = false"
        />
    </v-row>
</template>

<script>
    import { Cropper } from 'vue-advanced-cropper'
    import 'vue-advanced-cropper/dist/style.css';
    import 'vue-advanced-cropper/dist/theme.compact.css';
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "ImageCropper",

        components: {
            Cropper,
        },
        
        extends: ComponentBase,

        data() {
            return {
                image: '',
                loading: false,
                vuexNamespace: this.value.data.vuexNamespace,
                stencilProps: {
                    aspectRatio: this.value.data.aspectRatio,
                }
            }
        },

        created() {
            this.$store.watch(
                (state, getters) => getters[`${this.vuexNamespace}/file`],
                (file) => this.create(file)
            )

            window.addEventListener("resize", this.reset);
        },

        beforeDestroy() {
            window.removeEventListener("resize", this.reset);
        },

        methods: {
            create(file) {
                const reader = new FileReader();

                if (file instanceof File) {
                    this.loading = true

                    reader.onload = () => {
                        this.image = reader.result
                    };
                    reader.readAsDataURL(file);
                }
            },

            change({coordinates}) {
                this.$store.commit(`${this.vuexNamespace}/setCoordinates`, coordinates)
            },

            reset() {
                this.$refs.cropper.reset()
            }
        },
    }
</script>