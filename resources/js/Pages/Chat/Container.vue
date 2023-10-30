<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import MessageContainer from "./MessageContainer.vue";
import InputMessage from "./InputMessage.vue";

const messages = ref([]);
const rooms = ref([]);
const currentRoom = ref([]);

const connect = () => {
    if(currentRoom.value.id){
        getMessages()
        window.Echo.private("chat." + currentRoom.value.id)
        .listen(".message.new" , e => {
            getMessages()
        })
    }
}

watch(currentRoom,() => {
    connect()
})


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
};

onMounted(() => {
    getRooms();
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <MessageContainer :messages="messages" />
                    <InputMessage :room="currentRoom" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style></style>
