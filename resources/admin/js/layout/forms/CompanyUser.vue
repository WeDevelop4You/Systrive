<template>
    <div>
        <v-text-field
            v-if="!isEditing"
            v-model="value.email"
            :label="$vuetify.lang.t('$vuetify.word.email')"
            :error-messages="errors.email"
            dense
            outlined
        />
        <v-autocomplete
            v-model="roles"
            :items="roleItems"
            :label="$vuetify.lang.t('$vuetify.word.roles')"
            item-text="name"
            deletable-chips
            return-object
            small-chips
            multiple
            chips
            dense
            outlined
            @change="changeRolePermissions"
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
                            v-model="permissions"
                            :label="$vuetify.lang.t(item.name)"
                            :value="item.id"
                            hide-details
                            dense
                            :disabled="hasRolePermissions(item.id)"
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
                            v-model="permissions"
                            :label="$vuetify.lang.t(item.name)"
                            :value="item.id"
                            :disabled="isViewSelected(group.id) || hasRolePermissions(item.id)"
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
        name: "CompanyUser",

        props: {
            value: {
                required: true,
                type: Object
            }
        },

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
                errors: 'company/users/errors',
                isEditing: 'company/users/isEditing',
                roleItems: 'company/roles/listItems',
                permissionGroupsItems: 'permissions/items'
            })
        },

        watch: {
            permissions: function() {
                this.value.roles = this.roles.map(role => role.id)
                this.value.permissions = this.permissions.filter(x => !this.rolesPermissions.includes(x))
            }
        },

        beforeCreate() {
            this.$store.dispatch('company/roles/dropList');
        },

        mounted() {
            this.getData()
        },

        methods: {
            getData() {
                let data = this.$store.getters["company/users/data"]

                this.roles = data.roles
                this.permissions = data.permissions

                this.changeRolePermissions(data.roles)
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
