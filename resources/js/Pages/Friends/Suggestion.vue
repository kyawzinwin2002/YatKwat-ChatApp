<script setup>
import axios from "axios";
import { defineProps, ref, onMounted } from "vue";

const { strangers, authUser } = defineProps(["strangers", "authUser"]);
const allRequests = ref([]);
const sentRequests = authUser.sent_friend_requests;

const getAllRequests = async () => {
    await axios
        .get("/request")
        .then((response) => {
            allRequests.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    getAllRequests();
});

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

const checkSentOrNot = (sender, receiver) => {
    return sentRequests.some(
        (r) => r.sender_id == sender && r.receiver_id == receiver
    );
};

const cancelHandler = (sender, receiver) => {
    const requestId = allRequests.value.find(
        (r) => r.sender_id === sender && r.receiver_id === receiver
    ).id;

    axios
        .delete(`/request/${requestId}`)
        .then((response) => {
            console.log(response);
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
                    @click="
                        checkSentOrNot(authUser.id, user.id)
                            ? cancelHandler(authUser.id, user.id)
                            : sendRequestHandler(user.id)
                    "
                    class="px-6 py-2 rounded-md"
                    :class="
                        checkSentOrNot(authUser.id, user.id)
                            ? 'bg-gray-500 text-white'
                            : 'bg-blue-500 text-white'
                    "
                >
                    {{
                        checkSentOrNot(authUser.id, user.id)
                            ? "Cancel Request"
                            : "Add Friend"
                    }}
                </button>
            </div>
        </div>
    </div>
</template>
