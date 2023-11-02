<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import MessageContainer from "./MessageContainer.vue";
import InputMessage from "./InputMessage.vue";
import Pusher from "pusher-js";
import Echo from 'laravel-echo';


const rooms = ref([]);
const currentRoom = ref([]);
const messages = ref([]);
const message = ref("");

const getRooms = async () => {
    await axios
        .get("/chat/rooms")
        .then((response) => {
            rooms.value = response.data;
            setRoom(response.data[0]);
        })
        .catch((error) => {
            console.log(error);
        });
};



const getMessages = async () => {
    await axios
        .get("/chat/room/" + currentRoom.value.id + "/messages")
        .then((response) => {
            messages.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const setRoom = (room) => {
    currentRoom.value = room;
    getMessages()
};


onMounted(() => {
    getRooms();
});


window.Echo.private("chatchannel")
.listen(".message",(e) => {
    getMessages()
});




</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white  shadow-xl sm:rounded-lg">
                    <MessageContainer :messages="messages" />
                    <InputMessage :room="currentRoom" :message="message"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style></style>
