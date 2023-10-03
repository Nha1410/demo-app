<script setup>
import 'vuetify/dist/vuetify.min.css'
import { Head } from "@inertiajs/vue3";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

</script>
<template>
    <Head title="Dashboard" />

    <DashboardLayout>
    <!-- <div class="w-50 h-50 overflow-hidden rounded-full border-4 border-white">
        <img src="/images/image-1@2.jpg" alt="User Avatar" class="w-full h-full object-cover rounded-full">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/60 rounded-full"></div> -->
        <div class="flex-col flex items-center justify-center mt-8">
            <div class="rounded-lg shadow-xl bg-gray-50 lg:w-1/2">
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
                                    class="h-auto max-w-[20rem] rounded-full"
                                    src="/images/image-preview.jpg"
                                    alt="image description"
                                    
                                    />
                                    <img v-if="imagePreview" :src="imagePreview" alt="Image Preview" class="h-auto max-w-[20rem] rounded-full">
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
                        Update
                    </v-btn>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
<script type="module">
    export default {
        data() {
            return {
                formPost: {
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
                formData.append('image', this.formPost.selectedImage);
                try {
                    const response = await axios.post('/user/edit-avatar', formData);
                    console.log(response.data);
                } catch (error) {
                    console.error(error);
                }
            }
        }
    };
</script>
