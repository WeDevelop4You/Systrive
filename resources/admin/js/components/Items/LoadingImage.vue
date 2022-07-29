<template>
    <v-img
        :alt="alt"
        :src="src"
        :lazy-src="lazySrc"
        :max-width="maxWidth"
        :min-width="minWidth"
        :max-height="maxHeight"
        :min-height="minHeight"
    >
        <template #placeholder>
            <v-row
                class="fill-height ma-0"
                align="center"
                justify="center"
            >
                <v-progress-circular
                    indeterminate
                    color="grey lighten-5"
                />
            </v-row>
        </template>
    </v-img>
</template>

<script>
    export default {
        name: "LoadingImage",

        props: {
            alt: {
                required: true,
                type: String,
            },

            src: {
                required: true,
                type: String,
            },

            maxWidth: {
                type: [String, Number],
                default: ''
            },

            minWidth: {
                type: [String, Number],
                default: ''
            },

            maxHeight: {
                type: [String, Number],
                default: ''
            },

            minHeight: {
                type: [String, Number],
                default: ''
            },

            lazySrc: {
                type: String,
                default: ''
            }
        }
    }
</script>
