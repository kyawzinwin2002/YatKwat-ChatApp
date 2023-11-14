<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const { requests } = defineProps(["requests"])

const confirmHandler = (id) => {
    axios.put(`/request/${id}`)
        .then(response => {
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}

const declineHandler = (id) => {
    axios.delete(`/request/${id}`)
        .then(response => {
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Friend Requests
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="my-3 p-3">
                        <h1 class="text-lg font-semibold">Request List</h1>
                        <div v-if="requests.length < 1" class=" my-3">
                            <h1>
                                There is no requests.
                            </h1>
                        </div>
                        <div class=" my-3" v-for="request in requests">
                            <div class=" flex justify-between items-center p-3 border-2 shadow-md rounded-md">
                                <h1>{{ request.sender.name }}</h1>
                                <div class=" flex items-center gap-2">
                                    <button @click="confirmHandler(request.sender.id)" class=" px-6 py-2 rounded-md bg-blue-500 text-white">Confirm</button>
                                    <button @click="declineHandler(request.id)" class=" px-6 py-2 rounded-md bg-gray-500 text-white">Decline</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
