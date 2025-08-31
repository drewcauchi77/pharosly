import { createApp, h } from 'vue';
import { createPinia } from 'pinia'
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";
import { resolveLayout } from "@/Helpers/helpers.js";

createInertiaApp({
    title: (title) => `${title} | Pharosly`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', {
            eager: true
        });

        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = resolveLayout(name);

        return page;
    },
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el)
    },
});
