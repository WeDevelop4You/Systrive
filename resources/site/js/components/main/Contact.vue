<template>
    <div>
        <HeaderImage space="150" title="CONTACT US" subtitle="" picture="/images/contact.jpg"/>
        <section class="main-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-8 col-xl-6">
                        <div class="text-center mb-4">
                            <h2 class="h2">LEAVE A MESSAGE</h2>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>YOUR NAME: *</label>
                                    <input name="contact-name" type="text" class="form-control" v-model="name">
                                    <small class="text-danger text-uppercase" v-if="has_error && error_message.name">{{ error_message.name[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>EMAIL ADDRESS: *</label>
                                    <input name="contact-email" type="email" placeholder="you@yoursite.com" class="form-control" v-model="email">
                                    <small class="text-danger text-uppercase" v-if="has_error && error_message.email">{{ error_message.email[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>COMPANY NAME:</label>
                                    <input name="contact-company" type="text" class="form-control" v-model="company">
                                    <small class="text-danger text-uppercase" v-if="has_error && error_message.company_name">{{ error_message.company_name[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CONTACT NUMBER:</label>
                                    <input name="contact-phone" type="tel" class="form-control" v-model="number">
                                    <small class="text-danger text-uppercase" v-if="has_error && error_message.contact_number">{{ error_message.contact_number[0] }}</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>MESSAGE:</label>
                                    <textarea class="form-control" name="contact-message" rows="10" placeholder="How can we help?" v-model="text"/>
                                    <small class="text-danger text-uppercase" v-if="has_error && error_message.message">{{ error_message.message[0] }}</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <vue-recaptcha :loadRecaptchaScript="true" sitekey="6LfGdcgUAAAAAM-oKiRtQ6zywSyryabCq8om7pS_" v-on:verify="verified = false" v-on:expired="verified = true" v-on:error="verified = false"/>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" v-on:click="submit()" :disabled="verified">
                                    <span>SEND</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="send" class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="10000" style="position: fixed; bottom: 10px; right: 10px; z-index: 1200">
            <div class="toast-body bg-success">
                <p class="text-uppercase mb-0">{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderImage from "../Header";
    import VueRecaptcha from 'vue-recaptcha';

    export default {
        name: "Contact",

        components: {
            HeaderImage,
            VueRecaptcha,
        },

        data() {
            return {
                name: '',
                email: '',
                company: '',
                number: '',
                text: '',
                message: '',
                verified: true,
                has_error: false,
                has_success: false,
                error_message: {},
            }
        },

        methods: {
            submit() {
                if (!this.verified) {
                    let app = this;
                    this.verified = true;
                    axios({
                        url: 'data/contact',
                        method: 'POST',
                        data: {
                            name: app.name,
                            email: app.email,
                            company_name: app.company,
                            contact_number: app.number,
                            message: app.text,
                        }
                    }).then((res) => {
                        app.message = res.data.message;
                        $('#send').toast('show');
                        app.has_success = true;
                        app.has_error = false;
                        app.name = '';
                        app.email = '';
                        app.company = '';
                        app.number = '';
                        app.text = '';
                        app.verified = false;
                    }, (res) => {
                        app.error_message = res.response.data.errors || {};
                        app.has_success = false;
                        app.has_error = true;
                        app.verified = false;
                    })
                }
            },
        },
    }
</script>

<style scoped>

</style>
