<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref,onMounted,defineProps } from "vue";

const friends = ref([]);
const { user } = defineProps(["user"]);

const getContacts = async () => {
    await axios
        .get(`/contacts/${user?.id}`)
        .then((response) => {
            friends.value = response.data.friends;
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    getContacts();
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chats
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="my-3 p-3">
                        <h1 class="text-lg font-semibold">Chat List</h1>

                        <div class="my-3" v-for="friend in friends">
                            <a
                            :href='route("chatMessage",[{id : friend.id,name : friend.name}])'
                                class="flex cursor-pointer justify-between items-center p-5 border-2 shadow-md rounded-md"
                            >
                                <h1>{{ friend.name }}</h1>
                            </a>
                        </div>
                        <div v-if="friends?.length < 1" class=" ">
                            <h1>
                                There is no friend.Add People to make your
                                friend.
                            </h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style></style>
