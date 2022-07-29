<template>
    <v-breadcrumbs :items="breadcrumbs">
        <template #item="{ item }">
            <v-breadcrumbs-item
                :to="item.to"
                class="text-subtitle-2 crumb-item"
                :disabled="item.disabled"
                exact
            >
                {{ item.text }}
            </v-breadcrumbs-item>
        </template>
    </v-breadcrumbs>
</template>

<script>
    export default {
        name: "Breadcrumb",

        data() {
            return {
                breadcrumbs: []
            }
        },

        watch: {
            '$route.meta.breadcrumbs': {
                handler(value) {
                    if (typeof value === "function") {
                        this.breadcrumbs = value.call(this, this.$route);
                    } else {
                        this.breadcrumbs = value
                    }
                },
                deep: true,
                immediate: true
            }
        },
    }
</script>
