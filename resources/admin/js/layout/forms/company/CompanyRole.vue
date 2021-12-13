<template>
    <div>
        <v-text-field
            v-model="value.name"
            :label="$vuetify.lang.t('$vuetify.word.name')"
            :error-messages="errors.name"
            dense
            outlined
        />
        <v-row
            v-for="(group, key) in permissionGroupsItems"
            :key="key"
        >
            <v-col
                class="py-0"
                order="first"
                cols="12"
            >
                <v-subheader
                    class="px-0"
                    v-text="$vuetify.lang.t(group.name)"
                />
            </v-col>
            <template v-for="(item, index) in group.permissions">
                <template v-if="group.id === item.id">
                    <v-col
                        :key="index"
                        class="py-0"
                        cols="12"
                        order="0"
                    >
                        <v-checkbox
                            v-model="value.permissions"
                            :label="$vuetify.lang.t(item.name)"
                            :value="item.id"
                            hide-details
                            dense
                        />
                        <v-divider class="mt-2" />
                    </v-col>
                </template>
                <template v-else>
                    <v-col
                        :key="index"
                        class="py-0"
                        cols="auto"
                    >
                        <v-checkbox
                            v-model="value.permissions"
                            :value="item.id"
                            :disabled="isViewSelected(group.id, item.id)"
                            :label="$vuetify.lang.t(item.name)"
                            hide-details
                            dense
                        />
                    </v-col>
                </template>
            </template>
        </v-row>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "CompanyRole",

        props: {
            value: {
                required: true,
                type: Object
            }
        },

        computed: {
            isViewSelected() {
                return (group, id) => {
                    if (group === null) {
                        return false;
                    }

                    let permissions = this.value.permissions

                    if (permissions.includes(group)) {
                        return false;
                    }

                    const index = permissions.indexOf(id);

                    if (index > -1) {
                        permissions.splice(index, 1);
                    }

                    return true;
                }
            },

            ...mapGetters({
                errors: 'company/roles/errors',
                permissionGroupsItems: 'permissions/items'
            })
        }
    }
</script>
