<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";

const users = ref([]);
const group = reactive({
    name: "",
    members: [],
});
const errors = ref({});

const router = useRouter();

const submitHandler = () => {
    axios
        .post("/group", group)
        .then((response) => {
            console.log(response);
            if (response.data.status) {
                router.back();
            }
        })
        .catch((error) => {
            console.log(error.response.data.errors);
            errors.value = error.response.data.errors;
        });
};

onMounted(async () => {
    await axios
        .get("/invite")
        .then((response) => {
            users.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Group
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form
                    @submit.prevent="submitHandler"
                    :action="route('group.store')"
                    method="post"
                >
                    <div class="my-3 flex flex-col">
                        <label for="" class="my-3">Group Name</label>
                        <input
                            type="text"
                            v-model="group.name"
                            placeholder="Group Name"
                            class="rounded-md"
                        />
                        <span class="text-red-600" v-if="errors?.name">{{
                            errors.name[0]
                        }}</span>
                    </div>
                    <div class="mt-5">
                        <h1>Add Members (select atleast two members!!)</h1>
                    </div>
                    <div class="mb-3 flex flex-col">
                        <div
                            v-for="user in users"
                            class="my-3 flex gap-4 items-center"
                        >
                            <input
                                type="checkbox"
                                :value="user.id"
                                v-model="group.members"
                            />
                            <label for="">{{ user.name }}</label>
                        </div>
                        <span class="text-red-600" v-if="errors?.members">{{
                            errors.members[0]
                        }}</span>
                    </div>

                    <div class="my-3">
                        <button
                            class="px-6 py-2 bg-blue-600 text-white rounded-md"
                        >
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
