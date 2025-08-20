import AuthLayout from "@/Layouts/AuthLayout.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

const resolveLayout = (name) => {
    if (name.startsWith('Auth/')) return AuthLayout;
    return DashboardLayout;
};

export { resolveLayout };
