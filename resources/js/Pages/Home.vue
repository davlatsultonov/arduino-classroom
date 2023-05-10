<template>
    <Head>
        <title>Home Page</title>
    </Head>
    <div class="my-5">
        <div class="row border-bottom">
            <div class="col col-lg-6">
                <h2 class="mb-3 fw-bold">Дарси Муосир Оид Ба Arduino</h2>
                <p class="fs-5">
                    Аз асосҳо то мавзӯъҳои пешрафта бо тавзеҳоти оддӣ, вале муфассал.
                </p>
            </div>
            <div class="col col-lg-6">
                <div class="d-flex justify-content-end mt-2 mb-5 small">
                    Охирин навсозӣ 9 майи 2023
                </div>

<!--                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Дар дастур ҷустуҷӯ кунед" aria-describedby="button-addon2">
                    <button class="btn btn-dark font-monospace" type="button" id="button-addon2">Ҷустуҷӯ</button>
                </div>-->
            </div>
        </div>
        <div class="row mt-4 mb-5">
            <div class="col col-lg-9">
                <h5 class="mb-3">Дарсҳои Arduino ва робототехника</h5>

                <p>Хуш омадед ба сайти бахшида ба омӯзиши Arduino! Дар ин ҷо шумо тавсифи муфассали технология, қобилият ва татбиқи онро пайдо мекунед. Мо маводҳоро ба бобҳо тақсим кардем, то омӯзиши шуморо осон созем ва ба мавзӯъҳое, ки ба шумо таваҷҷӯҳ доранд, диққат диҳем.</p>
            </div>
        </div>
        <TutorialsList :tutorials="$page.props.shared.tutorials"/>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import Accordion from "../Shared/Accordion.vue";
import TutorialsList from "./Tutorial/TutorialsList.vue";

export default {
    components: {TutorialsList, Accordion, Navbar, Head, Link},
}
</script>
