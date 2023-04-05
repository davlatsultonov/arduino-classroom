import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min'
import DefaultLayout from "./Layouts/DefaultLayout.vue";

InertiaProgress.init()

createInertiaApp({
    resolve: (name) => {
        let page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

        page.then((module) => {
            module.default.layout = module.default.layout || DefaultLayout;
        });

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({ methods: {route}, mounted() {
                    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, {
                        offset: [0, 10]
                    }));
                }})
            .use(plugin)
            .mount(el)

        // Hide preloader after app setup
        document.getElementById('preloader-custom').style.display = 'none'
    },
})
