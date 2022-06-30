<template>
    <div>
        <template v-if="!value.content.value">
            {{ $vuetify.lang.t('$vuetify.word.no_content') }}
        </template>
        <v-hover
            v-else
            v-slot="{ hover }"
        >
            <a
                :class="[hover ? 'primary--text' : value.data.color]"
                :href="value.content.value"
                target="_blank"
                style="max-width: max-content"
            >
                {{ value.content.anchor || value.content.value.replace(/(^\w+:|^)\/\//, '') }}
                <v-icon
                    class="mt-n1"
                    style="transition: none"
                    :class="[hover ? 'primary--text' : value.data.color]"
                    size="20"
                >
                    fa-external-link-alt
                </v-icon>
            </a>
        </v-hover>
    </div>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";

    export default {
        name: "Url",

        mixins: [
            ComponentProperties
        ],
    }
</script>
