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
    import {mapGetters} from "vuex";

    export default {
        name: "Breadcrumb",

        computed: {
            ...mapGetters({
                items: 'breadcrumbs/items'
            })
        }
    }
</script>
