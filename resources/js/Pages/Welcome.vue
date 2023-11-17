<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter selection:bg-red-500 selection:text-white"
    >
        <div class="sm:fixed sm:top-0 sm:left-0 p-6 text-right z-10">
            <h1 class="text-3xl font-serif font-semibold">YatKwat</h1>
        </div>

        <div
            v-if="canLogin"
            class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10"
        >
            <Link
                v-if="$page.props.auth.user"
                :href="route('chat')"
                class="font-semibold"
                >Chat</Link
            >

            <template v-else>
                <Link :href="route('login')" class="font-semibold">Login</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <h1 class="text-7xl font-serif font-semibold">
                Welcome to YatKwat
            </h1>
        </div>
    </div>
</template>

<style></style>
