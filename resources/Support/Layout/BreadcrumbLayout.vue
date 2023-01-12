<template>
    <v-breadcrumbs :items="items">
        <template #item="{ item }">
            <v-breadcrumbs-item
                :to="item.to"
                class="text-subtitle-2 crumb-item"
                exact
            >
                {{ item.label }}
            </v-breadcrumbs-item>
        </template>
    </v-breadcrumbs>
</template>

<script>
    export default {
        name: "Breadcrumb",

        computed: {
            items() {
                return this.$breadcrumbs.items
            }
        }
    }
</script>
