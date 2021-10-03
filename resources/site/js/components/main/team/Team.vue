<template>
    <div>
        <HeaderImage space="150" title="MEET OUR TEAM" picture="/images/team.jpg"/>
        <section class="main-content">
            <div class="container" style="padding: 50px 12px;">
                <div class="mb-5">
                    <h2>OUR TEAM</h2>
                </div>
                <div class="row justify-content-center mb-3">
                    <TeamCard v-for="(user, index) in team" :key="index" amount="col-xl-3 col-lg-4 col-md-6 col-sm-7" :work_function="user.work_function" :image="user.picture" :name="user.name" :text="user.content" data-aos="fade-up" data-aos-duration="1000"/>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import HeaderImage from "../../Header";
    import TeamCard from './Team-Card'

    export default {
        name: "Team",

        components: {
            HeaderImage,
            TeamCard,
        },

        data() {
            return {
                team: [],
            }
        },

        mounted() {
            this.getTeam();
        },

        methods: {
            getTeam() {
                axios({
                    url: 'data/team',
                    method: 'get',
                }).then( (res) => {
                    this.team = res.data.team;
                })
            },
        },
    }
</script>

<style scoped>

</style>
