import { createApp, h } from 'vue';
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
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el)
    },
});
