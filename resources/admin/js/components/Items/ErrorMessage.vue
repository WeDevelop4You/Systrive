<template>
    <div
        v-if="message.length"
        class="v-text-field__details"
    >
        <div
            :class="[$vuetify.theme.dark ? 'theme--dark' : 'theme--light']"
            class="v-messages error--text"
            role="alert"
        >
            <div class="v-messages__wrapper">
                <div
                    class="v-messages__message"
                    v-text="getMessage"
                />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorMessage",

        props: {
            message: {
                required: true,
                type: [String, Array],
                default: () => [],
            }
        },

        computed: {
            getMessage() {
                if (Array.isArray(this.message)) {
                    return this.message[0]
                }

                return this.message
            }
        }
    }
</script>

