<template>
    <svg width="700" height="800" viewBox="0 0 700 800" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path :fill="lineColor" d="M0 0H700V4.89093C491.059 26.2462 -21.7743 107.487 39.5 392.944C114.714 743.342 606.343 788.641 700 794.999V800H0V0Z"/>
        <path :fill="fillColor" d="M0 0H700V3C583.98 15.067 373.902 45.0895 221.5 117.964C96.0687 177.941 10.0118 264.886 37.5 392.944C66.5729 528.386 155.61 617.989 263 678.549C430.595 773.06 638.55 792.638 700 797V800H0V0Z"/>
    </svg>
</template>

<script>
    export default {
        name: "Wave-2",

        props: {
            lineColor: String,
            fillColor: String,
        }
    }
</script>

<style scoped>

</style>
