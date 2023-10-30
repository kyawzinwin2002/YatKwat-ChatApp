<script setup>
import { inject, onMounted, ref } from "vue";
import axios from "axios";

const props = defineProps(["messages"]);

const auth = ref([]);

const messageContainerRef = ref(null);

const scrollToBottom = () => {
    setTimeout(() => {
        if (messageContainerRef && messageContainerRef.value) {
            messageContainerRef.value.scrollTop =
                messageContainerRef.value.scrollHeight;
        }
    }, 300);
};

const getAuthUser = async () => {
    await axios
        .get("/user")
        .then((response) => {
            auth.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });

    scrollToBottom();
};

onMounted(() => {
    getAuthUser();
});

const senderOrNot = (messageId) => {
    if (auth.value.id == messageId) {
        return true;
    }

    return false;
};
</script>

<template>
    <div
        class="h-96 p-3 overflow-hidden overflow-y-scroll"
        ref="messageContainerRef"
    >
        <div class="flex flex-col my-5" v-for="message in props.messages">
            <h1
                :class="{ 'ms-auto': senderOrNot(message.user.id) }"
                class="my-2"
            >
                {{ message.user.name }}
            </h1>
            <p
                v-if="senderOrNot(message.user.id)"
                class="ms-auto p-3 rounded-md bg-slate-300 text-black"
            >
                {{ message.message }}
            </p>
            <p v-else class="me-auto p-3 rounded-md bg-slate-300 text-black">
                {{ message.message }}
            </p>
        </div>
    </div>
</template>

<style></style>
