<template>
    <nav class="navbar navbar-expand-lg mb-3 ac-navbar">
        <div class="container">
            <Link class="navbar-brand" href="/">Arduino<b>CLASSROOM</b></Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" v-for="{id, name, slug} in categories" :key="id">
                        <Link :class="['nav-link px-3', { 'active': $page.url.startsWith('/' + slug) }]" aria-current="page" :href="'/' + slug">{{ name }}</Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Navbar",
    components: {Link},
    props: {
        categories: Array
    }
}
</script>
