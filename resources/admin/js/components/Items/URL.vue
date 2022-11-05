<template>
    <div>
        <template v-if="!component.content.value">
            <v-list-item-subtitle v-text="$vuetify.lang.t('$vuetify.word.no_content')"/>
        </template>
        <v-hover
            v-else
            v-slot="{ hover }"
        >
            <a
                :class="[hover ? 'primary--text' : component.data.color]"
                :href="component.content.value"
                target="_blank"
                class="text-decoration-none max-w-max-content"
            >
                <span class="text-decoration-underline">
                    {{ component.content.anchor || component.content.value.replace(/(^\w+:|^)\/\//, '') }}
                </span>
                <v-icon
                    class="mt-n1"
                    style="transition: none"
                    :class="[hover ? 'primary--text' : component.data.color]"
                    size="20"
                >
                    fa-external-link-alt
                </v-icon>
            </a>
        </v-hover>
    </div>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Url",

        extends: ComponentBase,
    }
</script>
