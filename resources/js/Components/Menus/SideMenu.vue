<script setup>
import LinkItem from "@/Components/Elements/LinkItem.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div>
        <div>
            <!-- Logo-->
        </div>

        <nav>
            <span>Menu</span><br>

            <LinkItem routeName="dashboard">Dashboard</LinkItem><br>

            <LinkItem routeName="modules.index">Modules</LinkItem><br>

            <Link as="button" method="delete" :href="route('login.destroy')" class="block w-full px-6 py-3 hover:bg-slate-700 text-left">Logout</Link>

            <span>Settings</span><br>

            <LinkItem routeName="workspaces.index">Workspaces</LinkItem><br>
        </nav>
    </div>
</template>
