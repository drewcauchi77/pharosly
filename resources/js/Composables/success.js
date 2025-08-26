import { onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

export function useSuccessProps(success) {
    onMounted(() => {
        const { props } = usePage();

        props.title = success.title;
        props.description = success.description;
    });
}
