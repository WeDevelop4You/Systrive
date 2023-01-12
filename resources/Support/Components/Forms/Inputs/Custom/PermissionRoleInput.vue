<template>
    <v-row no-gutters>
        <v-col cols="12">
            <v-row
                v-for="(group, key) in component.data.groups"
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
                        v-text="group.name"
                    />
                </v-col>
                <template v-for="(subGroups, name) in group.permissions">
                    <template v-for="(item, index) in subGroups">
                        <v-col
                            v-if="name === 'view'"
                            :key="`${key}_${name}_${index}`"
                            class="py-0"
                            cols="12"
                            order="0"
                        >
                            <v-checkbox
                                v-model="data.permissions"
                                :value="item.id"
                                :label="item.name"
                                dense
                                hide-details
                            />
                        </v-col>
                        <v-col
                            v-else
                            :key="`${key}_${name}_${index}`"
                            class="py-0"
                            cols="auto"
                        >
                            <v-checkbox
                                v-model="data.permissions"
                                :value="item.id"
                                :label="item.name"
                                :disabled="isViewSelected(group.id)"
                                hide-details
                                dense
                            />
                        </v-col>
                    </template>
                    <v-col
                        v-if="Object.keys(group.permissions).pop() !== name"
                        :key="`${key}_${name}`"
                        class="py-0"
                        cols="12"
                    >
                        <v-divider class="mt-2" />
                    </v-col>
                </template>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import FormComponentBase from "../../../Base/FormComponentBase";
    import {mapGetters} from "vuex";

    export default {
        name: "PermissionRoleInput",

        extends: FormComponentBase,

        computed: {
            isViewSelected() {
                return (id) => {
                    if (id === null) {
                        return false;
                    }

                    return !this.data.permissions.includes(id)
                }
            }
        },
    }
</script>
