<script setup>
import { onMounted, ref } from "vue";

const { messages } = defineProps(["messages"]);
const auth = ref([]);

const getAuthUser = async () => {
    await axios
        .get("/authUser")
        .then((response) => {
            auth.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
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
    <div class="h-96 flex flex-col-reverse gap-5 overflow-y-scroll p-3">
        <div class="flex flex-col my-5" v-for="message in messages">
            <p
                v-if="senderOrNot(message.sender_id)"
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
