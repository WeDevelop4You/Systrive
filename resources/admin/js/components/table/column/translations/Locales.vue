<template>
    <GroupBadges
        v-model="locales"
        :no-content="$vuetify.lang.t('$vuetify.word.not_translated')"
    />
</template>

<script>
    import ActionProps from "../../../../mixins/ActionProps";
    import GroupBadges from "../../../items/GroupBadges";

    export default {
        name: "Translated",

        components: {
            GroupBadges
        },

        mixins: [
            ActionProps
        ],

        computed: {
            locales() {
                return this.item.translated.map((locale) => {
                    return locale.toUpperCase()
                })
            }
        }
    }
</script>
