<script>
    import {get as _get} from "lodash";
    import NumberInput from "../NumberInput.vue";

    export default {
        name: "DimensionInput",

        extends: NumberInput,

        computed: {
            aspectRatioWidth() {
                return _get(this.data, 'properties.custom_image_aspect_ratio_width');
            },

            aspectRatioHeight() {
                return _get(this.data, 'properties.custom_image_aspect_ratio_height');
            }
        },

        watch: {
            aspectRatioWidth(value) {
                this.recalculate(value)
            },
            aspectRatioHeight(value) {
                this.recalculate(value)
            }
        },

        methods: {
            handler(value) {
                this.$nextTick(() => {
                    value = this.format(value)

                    if (!isNaN(value)) {
                        let key, otherValue

                        if (this.key.endsWith('width')) {
                            key = 'properties.custom_image_dimension_height'
                            otherValue = Math.round(value * (this.aspectRatioHeight / this.aspectRatioWidth))
                        } else {
                            key = 'properties.custom_image_dimension_width'
                            otherValue = Math.round(value * (this.aspectRatioWidth / this.aspectRatioHeight))
                        }

                        if (otherValue < 1) {
                            otherValue = null
                        }

                        this.setValue(value)
                        this.setData(key, otherValue)
                    }
                })

                this.clearError(this.key)
            },

            recalculate(value) {
                if (value > 0) {
                    this.handler('' + this.input)
                }
            }
        }
    }
</script>