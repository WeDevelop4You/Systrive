<template>
    <v-hover v-slot="{ hover }">
        <a
            :class="[hover ? 'primary--text' : color]"
            :href="value"
            target="_blank"
        >
            {{ anchor || value.replace(/(^\w+:|^)\/\//, '') }}
            <v-icon
                class="mt-n1"
                style="transition: none"
                :class="[hover ? 'primary--text' : color]"
                size="20"
            >
                fa-external-link-alt
            </v-icon>
        </a>
    </v-hover>
</template>

<script>
    export default {
        name: "Url",

        props: {
            value: {
                required: true,
                type: String
            },

            anchor: {
                type: String,
                default: ''
            },

            color: {
                type: String,
                default: 'text--secondary',
            }
        }
    }
</script>
