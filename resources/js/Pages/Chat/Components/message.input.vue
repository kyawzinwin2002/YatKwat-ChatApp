<script setup>
import axios from "axios";
import { ref } from "vue";

const { receiver_id } = defineProps(["receiver_id"]);
const message = ref("");

const sendMessageHandler = () => {
    if (message.value == "") return;

    axios
        .post("/userMessage", {
            receiver_id: receiver_id,
            message: message.value,
        })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });

    message.value = "";
};
</script>
<template>
    <div class="flex gap-3 justify-between p-3">
        <input
            @keyup.enter="sendMessageHandler"
            type="text"
            v-model="message"
            placeholder="Write a message..."
            class="rounded-lg w-full"
        />
        <button
            @click="sendMessageHandler"
            class="rounded-lg bg-blue-500 text-white px-5 py-2"
        >
            Send
        </button>
    </div>
</template>
