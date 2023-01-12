<template>
    <div>
        <v-subheader
            class="subtitle-1 px-0"
            style="height: 25px"
            v-text="component.content.label"
        />
        <v-row class="my-0">
            <v-col
                v-for="(item, index) in getValue"
                :key="index"
                class="py-0"
                cols="auto"
            >
                <v-checkbox
                    v-model="item.value"
                    :label="item.title"
                    hide-details
                    dense
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "GroupCheckboxInput",

        extends: FormComponentBase
    }
</script>
