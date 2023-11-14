<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "./Index.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Groups
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-3">
                    <a
                        :href="route('group.create')"
                        class="px-10 py-3 border-2 rounded-md bg-slate-400"
                        >Create New Group</a
                    >
                </div>
                <hr />
                <div class="my-3">
                    <Index />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
