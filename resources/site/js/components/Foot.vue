<template>
    <footer class="font-small footer-custom pt-4 w-100">
        <div class="mx-auto">
            <div class="text-center text-lg-left mx-3 mt-3 mb-0">
                <div class="row">
                    <div class="col-lg-4 col-lg-3 mx-auto my-lg-4 my-0 mt-4 mb-1">
                        <div class="row h-100 m-0">
                            <div class="mx-auto mx-lg-0">
                                <img :src="'images/logo-dark.png'" class="w-50" alt="logo">
                            </div>
                            <div class="mx-auto mx-lg-0 align-self-end">
                                <p class="py-3 mx-2 mb-2">© Copyright {{ new Date().getFullYear() }} by WeDevelop4You | All rights reserved</p>
                            </div>
                        </div>
                    </div>
                    <hr class="clearfix w-75 d-lg-none border-white">
                    <div class="col-lg-4 mx-auto my-lg-4 my-0 mt-4 mb-1">
                        <h5 class="font-weight-bold text-uppercase mb-4">Address</h5>
                        <ul class="list-unstyled">
                            <li>
                                <p class="hover"><i class="fas fa-home mr-3"/>Hoogezand, 9603HL, NL</p>
                            </li>
                            <li>
                                <p class="hover"><i class="fas fa-envelope mr-3"/>contact@wedevelop4you.nl</p>
                            </li>
                            <li>
                                <p class="hover"><i class="fas fa-phone mr-3"/>06 40832143</p>
                            </li>
                            <li>
                                <p class="hover"><i class="fas fa-landmark mr-3"/>KVK: 76979547</p>
                            </li>
                        </ul>
                    </div>
                    <hr class="clearfix w-75 d-lg-none border-white">
                    <div class="col-lg-2 text-center mx-auto my-4">
                        <h5 class="font-weight-bold text-uppercase mb-4">Follow Us</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a class="hover" href="https://www.facebook.com/WeDevelop4You-285374809073075/?notif_id=1557329115513025&notif_t=page_fan" target="_blank">
                                    <i class="fab fa-facebook-f text-dark link" style="font-size: 25px"/>
                                </a>
                            </li>
                            <li>
                                <a class="hover" style="font-size: 25px" href="https://twitter.com/develop4we" target="_blank">
                                    <i class="fab fa-twitter text-dark link"/>
                                </a>
                            </li>
                            <li>
                                <a class="hover" style="font-size: 25px" href="https://www.instagram.com/wedevelop4you/" target="_blank">
                                    <i class="fab fa-instagram text-dark link"/>
                                </a>
                            </li>
                            <li>
                                <a class="hover" style="font-size: 25px" href="https://www.linkedin.com/company/wedevelop4you/about/" target="_blank">
                                    <i class="fab fa-linkedin text-dark link"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Foot"
    }
</script>

<style scoped>

</style>
