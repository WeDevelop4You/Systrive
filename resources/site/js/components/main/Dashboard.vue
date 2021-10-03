<template>
    <div>
        <HeaderImage space="300" title="WE DEVELOP YOUR WEBSITE" subtitle="WE MAKE YOUR CUSTOM WEBSITE." picture="/images/background.jpg"/>
        <section class="main-content" style="min-height: 0">
            <div class="col-lg-7 py-5">
                <div class="offset-lg-3 overflow-hidden">
                    <div data-aos="fade-left" data-aos-duration="2000">
                        <h2>ABOUT</h2>
                        <div class="text-uppercase" v-html="about.about"/>
                    </div>
                </div>
            </div>
        </section>
        <section class="row mx-0">
            <div class="col-lg-7 bg-white py-5">
                <div class="offset-lg-3">
                    <div data-aos="fade-right" data-aos-duration="2000">
                        <h2>TEAM</h2>
                        <div class="row justify-content-center justify-content-xl-start mb-3">
                            <TeamCard v-for="(user, index) in team" :key="index" amount="col-4" :work_function="user.work_function" :image="user.picture" :name="user.name" data-aos="fade-up" data-aos-duration="1000"/>
                        </div>
                        <router-link class="text-accent-1" to="/team"><span class="text-uppercase">Learn more about our team &rarr;</span></router-link>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block px-0">
                <Hole class="w-100 h-auto" fill-color="#ffffff" line-color="#2f2f2f"/>
                <div class="bg-white h-100"/>
            </div>
        </section>
    </div>
</template>

<script>
    import Hole from '../svg/Wave-2'
    import HeaderImage from '../Header'
    import TeamCard from "./team/Team-Card";

    export default {
        name: "dashboard",

        components: {
            Hole,
            TeamCard,
            HeaderImage,
        },

        data() {
            return {
                team: [],
                about: '',
            }
        },

        mounted() {
            this.getAbout();
            this.getTeam();
        },

        methods: {
            getAbout() {
                axios({
                    url: 'data/about',
                    method: 'get'
                }).then((res) => {
                    this.about = res.data.about
                })
            },

            getTeam() {
                axios({
                    url: 'data/teammates',
                    method: 'get',
                }).then((res) => {
                    this.team = res.data.team;
                })
            },
        },
    }
</script>

<style scoped>

</style>
