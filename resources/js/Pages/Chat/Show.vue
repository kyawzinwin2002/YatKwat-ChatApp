<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
import messageIndex from "./Components/message.index.vue";
import messageInput from "./Components/message.input.vue";
import Pusher from "pusher-js";
import Echo from "laravel-echo";

const { id, name, user } = defineProps(["id", "name", "user"]);
const messages = ref([]);

const getMessages = async () => {
    await axios
        .get(`/userMessage?id=${id}`)
        .then((response) => {
            messages.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    getMessages();
});

window.Echo.private(`message.${user.id}`)
    .listen(".sendChatMessage",() => {
        getMessages()
    })

</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <messageIndex :messages="messages" />
                    <messageInput :receiver_id="id" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
