import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import 'bootstrap/dist/js/bootstrap.bundle.min';
import DefaultLayout from "./Layouts/DefaultLayout.vue";
import mitt from "mitt";
const emitter = mitt();

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
        const app = createApp({ render: () => h(App, props) })
        app.config.globalProperties.emitter = emitter;

        app.mixin({ methods: {route}})
            .use(plugin)
            .mount(el)

        // Hide preloader after app setup
        document.getElementById('preloader-custom').style.display = 'none'
    },
})
