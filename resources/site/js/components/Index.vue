<template>
    <div class="dashboard">
        <div>
            <NavBar/>
        </div>
        <div class="main overflow-hidden">
            <router-view/>
        </div>
        <div>
            <Foot/>
        </div>
    </div>
</template>

<script>
    import NavBar from './nav-bar/Nav-Bar'
    import Foot from './Foot'

    export default {
        name: "Index",

        components: {
            NavBar,
            Foot,
        },

        data() {
            return {
                about: '',
            }
        },

        mounted() {
            this.getAbout();
        },

        methods: {
            getAbout() {
                axios({
                    url: 'data/about',
                    method: 'get'
                }).then((res) => {
                    this.about = res.data.about.replace(/<\/?[^>]+(>|$)/g, "");
                })
            },
        },

        metaInfo() {
            return {
                meta: [
                    {
                        vmid: 'description',
                        name: 'description',
                        content: this.about,
                    },
                    {
                        property: 'og:description',
                        content: this.about,
                        vmid: 'og:description',
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
