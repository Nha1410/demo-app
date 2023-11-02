<template>
    <div class="comment-section">
        <div class="mt-4">
            <!-- Danh sách bình luận -->
            <div v-if="!isLoadingComment">
                <button 
                class="text-gray-600 font-light cursor-pointer mb-4 font-semibold w-40 h-6 bg-[#E1DDDD] rounded"
                @click="$emit('loadMoreComment')"
                >
                    Load more comment
                </button>
                <div v-for="(comment, index) in comments" :key="index" class="mb-4">
                    <div class="flex items-center mb-1">
                        <div class="h-8 w-8 rounded-full bg-gray-400"></div>
                        <span class="ml-2 font-semibold">{{ comment.user.name }}</span>
                            <timeago class="ml-2 font-light text-[13px]" :datetime="comment.created_at"/>
                    </div>
                    <p class="text-gray-700">{{ comment.content }}</p>
                </div>
            </div>
            <div v-else-if="isLoadingComment">
                loading...
            </div>
        </div>

        <!-- Form bình luận -->
        <div>
            <h3 class="text-lg font-semibold mb-2">Thêm bình luận mới</h3>
            <form @submit.prevent="addComment($event)" class="">
                <resize-textarea
                    v-model="content"
                    :modelValue="content"
                    class="w-full p-2 border rounded"
                    type="comment"
                    id="content"
                    :rows="1"
                    @update:modelValue="(value)=>useUpdatedValue(value)"
                    @keyup.enter="addComment($event)"
                >
                </resize-textarea>
                <button
                    type="submit"
                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded"
                >
                    Bình luận
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            formPost: {
                selectedImage: "",
                postId: this.postId,
            },
            content: "",
        };
    },
    props: {
        postId: {
            type: Number,
            default: "",
        },
        commentPostRoute: {
            type: String,
            default: "",
        },
        showCommentSection: {
            type: Object,
            required: true,
        },
        comments: {
            type: Array,
            required: true,
        },
        isLoadingComment: {
            type: Boolean,
            required: true,
            default: false,
        }
    },
    methods: {
        useUpdatedValue() {
            return "";
        },
        addComment(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append("content", this.content);
            formData.append("postId", this.formPost.postId);
            formData.append("image", this.formPost.selectedImage);
            axios
                .post(this.commentPostRoute, formData)
                .then((res) => {
                    console.log(res);
                    if (this.content.trim() !== "") {
                        this.comments.push(res.data);
                    }
                    this.content = "";
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
