<template>
    <div class="main">
        <SideBar></SideBar>
        <div class="min-h-screen p-4 sm:ml-64 text-left">
            <div class="h-full p-4 border-2 text-left border-gray-200 rounded-lg">
                {{ $route.meta.title }}
            </div>
            <div class="mt-5 p-4">
                <router-view />
            </div>
        </div>
    </div>
</template>
<script>
import SideBar from "@/components/layout/SideBar.vue";

export default {
    components: {SideBar},
    data() {
        return {}
    },
}
</script>
