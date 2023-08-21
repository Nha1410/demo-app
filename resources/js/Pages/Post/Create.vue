<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import 'vuetify/dist/vuetify.min.css'
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex-col flex items-center justify-center mt-8">
            <div class="rounded-lg shadow-xl bg-gray-50 lg:w-1/2">
                <div class="m-6">
                    <label
                        for="Title"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your Title
                    </label>
                    <input
                        v-model="formPost.title"
                        type="text"
                        id="Title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Title"
                        required
                    />
                </div>
                <div class="m-6">
                    <label
                        for="content"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your content
                    </label>
                    <resize-textarea
                        v-model="formPost.content"
                        type="text"
                        id="content"
                        class="resize-none overflow-hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                    </resize-textarea>
                </div>
                <div class="m-4">
                    <label class="inline-block mb-2 text-gray-500"
                        >Upload Image(jpg,png,svg,jpeg)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label
                            class="flex flex-col w-full h-[24rem] border-4 border-dashed hover:bg-gray-100 hover:border-gray-300"
                        >
                            <div
                                class="flex flex-col items-center justify-center pt-7"

                            >
                                <div class="relative">
                                    <img
                                    v-if="!imagePreview"
                                    class="h-auto max-w-lg rounded-lg"
                                    src="/images/image-1@2x.jpg"
                                    alt="image description"
                                    
                                    />
                                    <img v-if="imagePreview" :src="imagePreview" alt="Image Preview" class="h-auto max-w-lg rounded-lg">
                                    <v-btn 
                                        v-if="imagePreview"
                                        color="primary" 
                                        class="flex z-1 border w-[30px] h-[30px] rounded-full top-[-10px] right-[-10px]"
                                        position="absolute"
                                        rounded="xl"
                                        @click = "removeImage($event)"
                                    >
                                        <i class="flex w-full fa-solid fa-x items-center justify-center"></i>
                                    </v-btn>
                                </div>
                                <p
                                    class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600"
                                >
                                    Select a photo
                                </p>
                            </div>
                            <input ref="inputImage" type="file" class="opacity-0" @change="previewImage($event)"/>
                        </label>
                    </div>
                </div>
                <div class="flex p-2 space-x-4">
                    <button
                        class="px-4 py-2 text-white bg-red-500 rounded shadow-xl"
                    >
                        Cannel
                    </button>
                    <v-btn
                        color="green"
                        class="px-4 py-2 text-white bg-green-500 rounded shadow-xl"
                        @click="submitForm($event)"
                    >
                        Create
                    </v-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script type="module">
    export default {
        data() {
            return {
                formPost: {
                    title: "",
                    content: "",
                    selectedImage: null,
                },
                imagePreview: null,
            };
        },
        methods: {
            selectImages(event) {
                event.stopPropagation();
                this.$refs.inputImage.click();
                // document.getElementById("inputImage").click();
            },
            previewImage(event) {
                this.formPost.selectedImage = event.target.files[0];
                this.imagePreview = URL.createObjectURL(this.formPost.selectedImage);
            },
            removeImage(event) {
                event.preventDefault();
                event.stopPropagation();
                this.imagePreview = null;
                this.formPost.selectedImage = null;
                this.$refs.inputImage.value = "";
            },
            async submitForm(event) {
                event.preventDefault();
                let formData = new FormData();
                formData.append('title', this.formPost.title);
                formData.append('content', this.formPost.content);
                formData.append('image', this.formPost.selectedImage);
                try {
                    const response = await axios.post('/post/create', formData);
                    console.log(response.data);
                } catch (error) {
                    console.error(error);
                }
            }
        }
    };
</script>
<style scoped>
        textarea {
            resize: none;
            overflow: hidden;
            box-sizing: border-box;
            width: 100%;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
        }
 </style>
