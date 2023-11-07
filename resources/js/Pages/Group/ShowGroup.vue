<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import MessageContainer from "./MessageContainer.vue";
import InputMessage from "./InputMessage.vue";
import Pusher from "pusher-js";
import Echo from "laravel-echo";

const props = defineProps(["group"]);
const messages = ref([]);
const members = ref([]);
const remainUsers = ref([]);
const suggestMembers = ref([]);
const visible = ref(false);

const visibleHandler = () => {
    visible.value = !visible.value
}

const getMessages = async () => {
    await axios
        .get("/chat/group/" + props.group.id + "/messages")
        .then((response) => {
            messages.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const getMembers = async () => {
    await axios
        .get("/group/" + props.group.id + "/members")
        .then((response) => {
            members.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const getRemainInviteUsers = async () => {
    await axios
        .get(`/group/${props.group.id}/remain`)
        .then((response) => {
            remainUsers.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const joinHandler = () => {
    axios.post("/group/join",{
        group_id : props.group.id,
        members : suggestMembers.value
    })
    .then(response => {
        console.log(response)
    })
    .catch(error => {
        console.log(error)
    })
}

const loadInitialData = async () => {
    await getMessages();
    await getMembers();
    await getRemainInviteUsers();
};

onMounted(() => {
    loadInitialData();
});

window.Echo.private(`groupMessage.${props.group.id}`).listen(
    ".sendMessage",
    () => {
        getMessages();
    }
);

</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.group.name }} Group
            </h2>

            <button
            @click="visibleHandler"
            class="px-6 py-2 rounded-md bg-teal-400">Members</button>

        </template>
        <div class="py-12">
            <div v-show="visible" class=" bg-slate-200 h-96 w-96 right-3 p-3 absolute overflow-y-scroll">
                <div class="">
                    <h1 class=" font-semibold text-xl">Members</h1>
                    <hr>
                    <ul>
                        <li class="cursor-pointer" v-for="member in members">
                            {{ member.name }}
                        </li>
                    </ul>
                </div>
                <div class="my-3">
                    <h1 class=" font-semibold text-xl">Suggested</h1>
                    <hr>
                    <div class="my-3 flex gap-3 items-center" v-for="user in remainUsers">
                        <input type="checkbox" :value="user.id" v-model="suggestMembers">
                        <label for="">{{ user.name }}</label>
                    </div>
                    <button @click="joinHandler" class=" px-6 py-2 bg-blue-500 text-white rounded-md">Add</button>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <MessageContainer :messages="messages" />
                    <InputMessage :currentGroup="props.group" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
