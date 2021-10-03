<template>
    <div>
        <HeaderImage space="150" title="OUR WORK" subtitle="" picture="/images/work.jpg"/>
        <section class="main-content">
            <div class="container">
                <div class="container" style="padding: 50px 12px;">
                    <div class="row justify-content-center mb-3">
                        <div class="spinner-border text-accent-1" role="status" v-if="!done">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <WorkCard v-for="(website, index) in websites" :key="index" amount="col-xl-3 col-lg-4 col-md-6 col-sm-7" :name="website.title" :image="website.image" :link="website.url" data-aos="fade-up" data-aos-duration="1000"/>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import HeaderImage from "../../Header";
    import WorkCard from "./Work-card"

    export default {
        name: "Work",

        components: {
            HeaderImage,
            WorkCard,
        },

        data() {
            return {
                done: false,
                websites: [],
            }
        },

        mounted() {
            this.getWebsites();
        },

        methods: {
            getWebsites() {
                let app = this;
                this.axios({
                    url: 'data/websites',
                    method: 'GET'
                }).then((res) => {
                    app.done = true;
                    app.websites = res.data.websites
                })
            }
        }
    }
</script>

<style scoped>

</style>
