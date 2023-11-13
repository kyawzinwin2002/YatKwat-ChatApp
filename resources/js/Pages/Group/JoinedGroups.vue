<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const user = ref([]);

const getAuthUser = async () => {
    await axios
        .get("/authUser")
        .then((response) => {
            user.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(async () => {
    getAuthUser();
});
</script>
<template>
    <h1 class="my-4">Joined Groups</h1>
    <div class="flex flex-col h-96 overflow-y-scroll">
        <a
            v-for="group in user?.groups"
            :href="route('group.show', [{ id: group.id }])"
            class="my-3 p-5 border shadow-md rounded-md flex justify-between"
        >
            <h1>{{ group.name }}</h1>
        </a>
    </div>
</template>
