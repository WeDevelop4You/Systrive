<template>
    <v-hover v-slot="{ hover }">
        <div>
            <a
                :class="[hover ? 'primary--text' : color]"
                :href="href"
                target="_blank"
                v-text="name || href"
            />
            <v-icon
                class="mt-n1"
                style="transition: none"
                :class="[hover ? 'primary--text' : color]"
                size="20"
            >
                fa-external-link-alt
            </v-icon>
        </div>
    </v-hover>
</template>

<script>
    export default {
        name: "Url",

        props: {
            href: {
                required: true,
                type: String
            },

            name: {
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
