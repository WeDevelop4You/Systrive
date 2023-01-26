<template>
    <div class="v-messages">
        <div class="v-messages__message">
            {{ component.content.hint }}
        </div>
    </div>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "Hint",

        extends: ComponentBase
    }
</script>
