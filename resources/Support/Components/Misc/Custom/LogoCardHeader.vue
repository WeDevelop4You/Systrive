<template>
    <v-card-title>
        <svg-logo-line class="ma-6" />
        <div
            class="mx-auto text-h6 font-weight-bold"
            v-text="component.content.title"
        />
    </v-card-title>
</template>

<script>
    import SvgLogoLine from "../../Svg/Logo.vue";
    import ComponentBase from "../../Base/ComponentBase";

    export default {
        name: "LogoCardHeader",

        components: {
            SvgLogoLine,
        },

        extends: ComponentBase,
    }
</script>
