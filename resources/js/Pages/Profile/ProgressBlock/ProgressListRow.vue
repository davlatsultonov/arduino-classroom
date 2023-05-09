<template>
    <div class="progress-list-row border rounded-4 p-4 my-3">
        <h3 class="d-flex align-items-center justify-content-between border-bottom pb-3">
            <span>Санҷишҳои анҷомёфтаи шумо</span>
<!--            <Link class="btn btn-link text-black text-decoration-none fw-bold">Ҳама санҷишҳои анҷомшуда</Link>-->
        </h3>
        <div class="row mt-5 mb-4">
            <div class="col-2" v-for="{name, image} in slicedList" v-if="slicedList.length">
                <div class="card">
                    <CardImage class="card-img-top" :image="image" image-height="100" />
                    <div class="card-body p-2">
                        <h5 class="card-title text-center mb-0">{{ name }}</h5>
                    </div>
                </div>
            </div>
            <div v-else class="text-center">
                Ҳанӯз ягон санҷиши анҷомшуда нест...
            </div>
        </div>


        <div class="text-center pt-2">
            <Link :href="route('profile.test.index')" class="btn btn-outline-dark">Худро санҷед</Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import CardImage from "../../../Shared/Card/CardImage.vue";

export default {
    name: "ProgressListRow",
    components: {CardImage, Link},
    props: {
        list: Array
    },
    computed: {
        slicedList() {
            //return this.list.length > 6 ? this.list.slice(0, 6) : this.list;
            return this.list;
        }
    },
}
</script>

<style lang="scss" scoped>
.progress-list-row {

    .btn {
        font-weight: 500;
    }
}
</style>
