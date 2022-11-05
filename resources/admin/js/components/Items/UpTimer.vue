<template>
    <div>{{ timerFormat }}</div>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "UpTimer",

        extends: ComponentBase,

        data() {
            return {
                uptime: null
            }
        },

        computed: {
            timerFormat() {
                let format = ''

                if (this.uptime !== null) {
                    const days = Math.floor(this.uptime / (3600 * 24))
                    let hours = Math.floor((this.uptime - (days * 3600 * 24)) / 3600)
                    let minutes = Math.floor((this.uptime - (days * 3600 * 24) - (hours * 3600)) / 60)
                    let seconds = this.uptime - (days * 3600 * 24) - (hours * 3600) - (minutes * 60)

                    if (days > 0) {
                        format += days

                        if (days === 1) {
                            format += ' day '
                        } else {
                            format += ' days '
                        }
                    }

                    if (hours < 10) {
                        hours = "0" + hours
                    }

                    if (minutes < 10) {
                        minutes = "0" + minutes
                    }

                    if (seconds < 10) {
                        seconds = "0" + seconds
                    }

                    format += `${hours}:${minutes}:${seconds}`
                }

                return format;
            }
        },

        created() {
            this.calculateUptime()

            this.interval = setInterval(() => {
                this.calculateUptime()
            }, 1000)
        },

        beforeDestroy() {
            clearInterval(this.interval)
        },

        methods: {
            calculateUptime() {
                this.uptime = Math.floor(Date.now() / 1000) - this.component.content.value
           }
        }
    }
</script>
