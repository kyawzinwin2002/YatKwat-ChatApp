<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, ref, defineProps } from "vue";
import Suggestion from "./Suggestion.vue";

const friends = ref([]);
const strangers = ref([]);

const { user } = defineProps(["user"]);

const getFrisAndStrangers = async () => {
    await axios
        .get(`/contacts/${user.id}`)
        .then((response) => {
            friends.value = response.data.friends;
            strangers.value = response.data.strangers;
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    getFrisAndStrangers();
});
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Friends
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-3">
                    <div class="my-3">
                        <h1 class="text-lg font-semibold">Friend List</h1>

                        <div class="my-3" v-for="friend in friends">
                            <div
                                class="flex justify-between items-center p-5 border-2 shadow-md rounded-md"
                            >
                                <h1>{{ friend.name }}</h1>
                            </div>
                        </div>
                        <div v-if="friends?.length < 1" class=" ">
                            <h1>
                                There is no friend.Add People to make your
                                friend.
                            </h1>
                        </div>
                    </div>
                    <hr />
                    <Suggestion :strangers="strangers" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
