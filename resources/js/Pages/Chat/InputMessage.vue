<script setup>
import axios from "axios";
import { ref } from "vue";

const messages = ref("");

const props = defineProps(["room"]);

const sendMessage = () => {
    if (messages.value == "") return;

    axios
        .post("/chat/room/" + props.room.id + "/message", {
            messages: messages.value,
        })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });

    messages.value = "";
};
</script>

<template>
    <div class="flex gap-3 justify-between p-3">
        <input
            @keyup.enter="sendMessage"
            type="text"
            v-model="messages"
            placeholder="Write a message..."
            class="rounded-lg w-full"
        />
        <button
            @click="sendMessage"
            class="rounded-lg bg-blue-500 text-white px-5 py-2"
        >
            Send
        </button>
    </div>
</template>

<style></style>
