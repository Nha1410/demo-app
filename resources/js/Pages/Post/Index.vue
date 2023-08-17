<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import "vuetify/dist/vuetify.min.css";
</script>
<template>
    <Head title="Post" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-2 bg-gray-800 text-white p-4">
                <h2 class="text-xl font-semibold mb-4">Sidebar</h2>
                <!-- Profile Info -->
                <div class="flex items-center space-x-4 mb-6">
                    <img
                        src="/images/blank_avt.png"
                        alt="Profile Image"
                        class="w-12 h-12 rounded-full"
                    />
                    <div>
                        <h3 class="text-lg font-semibold">John Doe</h3>
                        <p class="text-gray-400">Web Developer</p>
                    </div>
                </div>
                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="#" class="block text-gray-400 hover:text-white"
                        >Home</a
                    >
                    <a href="#" class="block text-gray-400 hover:text-white"
                        >Profile</a
                    >
                    <!-- Add more navigation links -->
                </nav>
            </div>
            <div class="col-span-7">
                <!-- Post -->
                <div class="bg-white rounded shadow p-4 mb-4 flex flex-col">
                    <h1 class="text-xl font-semibold mb-2">Post Title</h1>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
                    <div class="w-full flex items-center justify-center ">
                        <img src="/images/image-1@2x.jpg" alt="Image" class="m-4 rounded max-w-full w-[96%]">
                    </div>
                    <!-- Like, Comment, Share buttons -->
                    <div class="flex items-center space-x-4 mt-4">
                        <button
                            class="flex items-center text-gray-400 hover:text-red-500 mr-2"
                        >
                            <i class="fa-solid fa-heart"></i>
                            <span class="ml-1">Like</span>
                        </button>
                        <button
                            class="flex items-center text-gray-400 hover:text-blue-500"
                        >
                            <i class="fa-solid fa-comment"></i>
                            <span class="ml-1">Comment</span>
                        </button>
                        <button
                            class="flex items-center text-gray-400 hover:text-blue-500"
                        >
                            <i class="fa-solid fa-share"></i>
                            <span class="ml-1">Share</span>
                        </button>
                    </div>
                </div>
                <!-- Repeat for other posts -->
                <div class="bg-white rounded shadow p-4 mb-4">
                    <h1 class="text-xl font-semibold mb-2">Post Title</h1>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
                    <!-- Like, Comment, Share buttons -->
                    <div class="flex items-center space-x-4 mt-4">
                        <button
                            class="flex items-center text-gray-400 hover:text-blue-500"
                        >
                            <svg
                                class="w-5 h-5 mr-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <!-- Heart icon -->
                            </svg>
                            Like
                        </button>
                        <button
                            class="flex items-center text-gray-400 hover:text-blue-500"
                        >
                            <svg
                                class="w-5 h-5 mr-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <!-- Comment icon -->
                            </svg>
                            Comment
                        </button>
                        <button
                            class="flex items-center text-gray-400 hover:text-blue-500"
                        >
                            <svg
                                class="w-5 h-5 mr-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <!-- Share icon -->
                            </svg>
                            Share
                        </button>
                    </div>
                </div>
                <!-- Repeat for other posts -->
            </div>
            <div class="col-span-3 bg-gray-200 p-4">
                <h2 class="text-xl font-semibold mb-4">Friend List</h2>
                <!-- Friends -->
                <ul class="space-y-2">
                    <li class="flex items-center space-x-2">
                        <img
                            src="/images/blank_avt.png"
                            alt="Friend 1"
                            class="w-8 h-8 rounded-full"
                        />
                        <span class="text-gray-600">Friend 1</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <img
                            src="/images/blank_avt.png"
                            alt="Friend 2"
                            class="w-8 h-8 rounded-full"
                        />
                        <span class="text-gray-600">Friend 2</span>
                    </li>
                    <!-- Add more friend list items -->
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "App",
};
</script>

<style>
/* Add Tailwind CSS here or in a separate file */
</style>
