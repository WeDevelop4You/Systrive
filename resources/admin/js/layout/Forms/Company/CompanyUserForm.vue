<template>
    <v-row dense>
        <v-col
            v-if="!isEditing"
            cols="12"
        >
            <v-text-field
                v-model="data.email"
                :error-messages="errors.email"
                :label="$vuetify.lang.t('$vuetify.word.email')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('email')"
            />
        </v-col>
        <v-col cols="12">
            <v-autocomplete
                v-model="roles"
                :items="roleItems"
                :label="$vuetify.lang.t('$vuetify.word.roles')"
                chips
                dense
                outlined
                multiple
                small-chips
                hide-details
                return-object
                deletable-chips
                item-text="name"
                @change="changeRolePermissions"
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
                    <v-col
                        v-if="group.id === item.id"
                        :key="`${key}_${index}`"
                        class="py-0"
                        cols="12"
                        order="0"
                    >
                        <v-checkbox
                            v-model="permissions"
                            :value="item.id"
                            :label="$vuetify.lang.t(item.name)"
                            :disabled="hasRolePermissions(item.id)"
                            dense
                            hide-details
                        />
                        <v-divider class="mt-2" />
                    </v-col>
                    <v-col
                        v-else
                        :key="`${key}_${index}`"
                        class="py-0"
                        cols="auto"
                    >
                        <v-checkbox
                            v-model="permissions"
                            :value="item.id"
                            :label="$vuetify.lang.t(item.name)"
                            :disabled="isViewSelected(group.id) || hasRolePermissions(item.id)"
                            hide-details
                            dense
                        />
                    </v-col>
                </template>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from "vuex";
    import CustomFormProperties from "../../../mixins/Form/CustomFormProperties";

    export default {
        name: "CompanyUserForm",

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                roles: [],
                permissions: [],
                rolesPermissions: [],
            }
        },

        computed: {
            isViewSelected() {
                return (id) => {
                    if (id === null) {
                        return false;
                    }

                    return !this.permissions.includes(id)
                }
            },

            hasRolePermissions() {
                return (id) => {
                    return this.rolesPermissions.includes(id);
                }
            },

            ...mapGetters({
                roleItems: 'company/roles/listItems',
                permissionGroupsItems: 'permissions/items'
            })
        },

        watch: {
            permissions: function() {
                this.data.roles = this.roles.map(role => role.id)
                this.data.permissions = this.permissions.filter(x => !this.rolesPermissions.includes(x))
            }
        },

        created() {
            if (this.$store.getters[`${this.vuexNamespace}/status`] === 'ready') {
                this.getData()
            }

            this.unwatch = this.$store.watch(
                (state, getters) => getters[`${this.vuexNamespace}/status`],
                (status) => {
                    switch (status) {
                        case 'ready':
                            this.getData()
                    }
                },
            );
        },

        beforeDestroy() {
            this.unwatch();
        },

        methods: {
            getData() {
                this.roles = this.data.roles
                this.permissions = this.data.permissions

                this.changeRolePermissions(this.data.roles)
            },

            changeRolePermissions(roles) {
                let permissions = roles.map(role => {
                    return role.permissions
                })

                permissions = permissions.flat()

                let uniquePermissions = [...new Set([...this.permissions, ...permissions])]
                let removedPermissions = this.rolesPermissions.filter(x => !permissions.includes(x))

                this.rolesPermissions = permissions
                this.permissions = uniquePermissions.filter(x => !removedPermissions.includes(x))
            }
        }
    }
</script>
