<template>
    <v-row dense>
        <v-col>
            <v-text-field
                v-model="data.name"
                :error-messages="errors.name"
                :label="$vuetify.lang.t('$vuetify.word.name')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('name')"
            />
        </v-col>
        <v-col cols="12">
            <v-row
                v-for="(group, key) in permissionGroupsItems"
                :key="key"
                class="my-0"
            >
                <v-col
                    class="pb-0"
                    order="first"
                    cols="12"
                >
                    <v-subheader
                        class="subtitle-1 px-0"
                        style="height: 25px"
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
                                v-model="data.permissions"
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
                                v-model="data.permissions"
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
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import CustomFormProperties from "../../../mixins/Form/CustomFormProperties";

    export default {
        name: "CompanyRole",

        mixins: [
            CustomFormProperties
        ],

        computed: {
            isViewSelected() {
                return (group, id) => {
                    if (group === null) {
                        return false;
                    }

                    let permissions = this.data.permissions

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
                permissionGroupsItems: 'permissions/items'
            })
        },
    }
</script>
