<script setup>
import axios from "axios";
import {  defineProps } from "vue";

const { strangers } = defineProps(["strangers"]);

const sendRequestHandler = (id) => {
    axios
        .post("/request", {
            receiver_id: id,
        })
        .then((response) => {
            // console.log(response)
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
<template>
    <div class="my-3">
        <h1 class="font-semibold text-lg">Suggestions</h1>
        <div class="my-3 flex flex-col gap-3">
            <div
                v-for="user in strangers"
                class="my-3 p-5 border shadow-md rounded-md flex justify-between"
            >
                <h1>{{ user.name }}</h1>
                <button
                    @click="sendRequestHandler(user.id)"
                    class="px-6 py-2 rounded-md bg-blue-500 text-white"
                >
                    Add Friend
                </button>
            </div>
        </div>
    </div>
</template>
