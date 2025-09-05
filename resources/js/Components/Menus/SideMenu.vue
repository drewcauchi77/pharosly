<script setup>
import MenuGroup from "@/Components/Menus/MenuGroup.vue";
</script>

<template>
    <div
        class="px-5 py-4 h-[calc(100%-30px)] overflow-y-auto"
    >
        <nav>
            <MenuGroup
                title="Menu"
                :items="[
                    { route: 'dashboard', name: 'Dashboard', icon: 'chart-line' }
                ]"
            />

            <MenuGroup
                title="Academy"
                :items="[
                    { route: 'episodes.index', name: 'Episodes', icon: 'video' },
                    { route: 'workspaces.index', name: 'Workspaces', icon: 'briefcase' }
                ]"
            />

            <MenuGroup
                title="Settings"
                :items="[
                    { route: 'episodes.index', name: 'User', icon: 'gear' }
                ]"
            />

            <MenuGroup
                title="User"
                :items="[
                    { route: 'login.destroy', name: 'Logout', icon: 'arrow-right-from-bracket', method: 'delete' }
                ]"
            />
        </nav>
    </div>
</template>
