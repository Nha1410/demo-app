<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head } from "@inertiajs/vue3";
import "vuetify/dist/vuetify.min.css";
import { ref, onMounted } from "vue";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";


const listPost = ref([]);
const test = {
    complete: "test",
};
let page = 1;
const load = async ($state) => {
    console.log("loading");

    axios
        .get("/post/get-list?page=" + page)
        .then((res) => {
            // console.log(res);
            if (res.data.length < 10) {
                $state.complete();
                console.log("complete");
            } else {
                listPost.value.push(...res.data);
            }
            page++;
        })
        .catch((e) => console.log(e))
        .finally(() => console.log("loading finally"));
};


</script>
<template>
    <Head title="Post" />
    <DashboardLayout >
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-9 mt-4">
                <div class="grid grid-cols-8 gap-4">
                    <div class="col-span-1"></div>
                    <!-- Post -->
                    <div class="col-span-6">
                        <div v-for="post in listPost" :key="post.id" class="bg-white rounded shadow p-6 mb-4 flex flex-col">
                            <h1 class="text-xl font-semibold mb-2">
                                {{ post.title }}
                            </h1>
                            <p class="text-gray-600">
                                {{ post.content }}
                            </p>
                            <div class="w-full flex items-center justify-center" v-for="image in post.images"
                                :key="image.id">
                                <img :src="image.image_path" alt="Image" class="m-4 rounded max-w-full w-[96%]" />
                            </div>
                            <!-- Like, Comment, Share buttons -->
                            <div class="flex items-center space-x-4 mt-4">
                                <button class="flex items-center text-gray-400 hover:text-red-500 mr-2">
                                    <i class="fa-solid fa-heart"></i>
                                    <span class="ml-1">Like</span>
                                </button>
                                <button class="flex items-center text-gray-400 hover:text-blue-500">
                                    <i class="fa-solid fa-comment"></i>
                                    <span class="ml-1">Comment</span>
                                </button>
                                <button class="flex items-center text-gray-400 hover:text-blue-500">
                                    <i class="fa-solid fa-share"></i>
                                    <span class="ml-1">Share</span>
                                </button>
                            </div>
                        </div>
                        <!-- Repeat for other posts -->
                        <InfiniteLoading @infinite="load" class="flex justify-center" :slots="test" />
                    </div>
                    <!-- Repeat for other posts -->
                    <div class="col-span-1"></div>
                </div>
            </div>
            <div class="col-span-3 bg-gray-200 p-4">
                <h2 class="text-xl font-semibold mb-4">Friend List</h2>
                <!-- Friends -->
                <ul class="space-y-2">
                    <li class="flex items-center space-x-2">
                        <img src="/images/blank_avt.png" alt="Friend 1" class="w-8 h-8 rounded-full" />
                        <span class="text-gray-600">Friend 1</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <img src="/images/blank_avt.png" alt="Friend 2" class="w-8 h-8 rounded-full" />
                        <span class="text-gray-600">Friend 2</span>
                    </li>
                    <!-- Add more friend list items -->
                </ul>
            </div>
        </div>
        <template>
            <InfiniteLoading />
        </template>
    </DashboardLayout>
</template>

<script>
import { onMounted } from "vue";

export default {
    name: "App",
};
</script>

<style>
/* Add Tailwind CSS here or in a separate file */
</style>
