<template>
    <nav class="navbar navbar-expand-lg position-absolute w-100 navbar-custom px-lg-5" style="z-index: 1050">
        <router-link class="navbar-brand d-lg-none d-none d-sm-block p-0" to="/">
            <img :src="'/images/logo-white.png'" height="25" alt="Logo">
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"/>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav m-auto w-100">
                <li class="nav-item">
                    <router-link class="navbar-brand d-none d-lg-block p-0" to="/">
                        <img :src="'/images/logo-white.png'" height="25" alt="Logo">
                    </router-link>
                </li>
                <li class="nav-item ml-lg-auto">
                    <router-link to="/" class="nav-link">HOME</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/Team" class="nav-link">TEAM</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/Work" class="nav-link">OUR WORK</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/Contact" class="nav-link">CONTACT</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Nav-Bar"
    }
</script>

<style scoped>

</style>
