<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head } from "@inertiajs/vue3";
import "vuetify/dist/vuetify.min.css";
import { ref, onMounted, computed } from "vue";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";
import CommentSection from "./Components/CommentSection.vue";
import ReactPostSection from "./Components/ReactPostSection.vue";
import { useStore } from "vuex";
const store = useStore();

let userOptions = ref([]);
const listPost = ref([]);
const showCommentSection = ref({});
const comments = ref([]);
const isLoadingComment = ref(false);
const pageForComment = ref(1);
const test = {
    complete: "test",
};
let page = 1;
const showDropdownEmoji = ref({});

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
                listPost.value.push(...res.data.posts);
            }
            page++;
        })
        .catch((e) => console.log(e))
        .finally(() => console.log("loading finally"));
};
const loadMoreComment = async (postId) => {
    pageForComment.value++;
    await loadComments(postId);
};
const toggleCommentSection = async (postId) => {
    if (!showCommentSection.value[postId]) {
        await loadComments(postId);
    } else {
        comments.value = comments.value.filter(
            (comment) => comment.commentable_id !== postId
        );
    }
    showCommentSection.value[postId] = !showCommentSection.value[postId];
};

const loadComments = async (postId) => {
    isLoadingComment.value = true;
    await axios
        .get(
            `/comment/get-list-comment-in-post?postId=${postId}&page=${pageForComment.value}`
        )
        .then((response) => {
            // comments.value.push(...response.data.map(comment => ({ ...comment, postId })));
            comments.value.push(...response.data);
        });

    isLoadingComment.value = false;
};
const toggleReactPostSection = (postId) => {
    showDropdownEmoji.value[postId] = !showDropdownEmoji.value[postId];
};

const updateReaction = (payload) => {
    payload.event.stopPropagation();
    showCommentSection.value[payload.postId] = false;
};

const countedLikes = (likes) => computed(() => {
    const counts = {};
    likes.forEach((like) => {
        const emojiType = like.emoji_type;
        counts[emojiType] = (counts[emojiType] || 0) + 1;
    });

    return counts;
});

onMounted(() => {
    store.dispatch("loadUserOptions")
    .then(() => {
        userOptions = store.state.userOptions;
    });
});
</script>
<template>
    <Head title="Post" />
    <DashboardLayout>
        <div class="col-span-9 mt-4">
            <div class="grid grid-cols-8 gap-4">
                <div class="col-span-1"></div>
                <!-- Post -->
                <div class="col-span-6">
                    <div
                        v-for="post in listPost"
                        :key="post.id"
                        class="bg-white rounded shadow p-6 mb-4 flex flex-col"
                    >
                        <h1 class="text-xl font-semibold mb-2">
                            {{ post.title }}
                        </h1>
                        <p class="text-gray-600">
                            {{ post.content }}
                        </p>
                        <div
                            class="w-full max-h-[500px] flex items-center justify-center"
                            v-for="image in post.images"
                            :key="image.id"
                        >
                            <img
                                :src="image.image_path"
                                alt="Image"
                                class="m-4 max-h-[500px] rounded max-w-full w-auto object-cover"
                            />
                        </div>
                        <!-- Like, Comment, Share buttons -->
                        <div class="flex items-center space-x-4 pt-4">
                            <div
                                class="relative"
                                @click="toggleReactPostSection(post.id)"
                            >
                                <button
                                    class="flex items-center hover:text-red-500 mr-2 text-gradient"
                                >
                                    <i
                                        class="fa-solid fa-heart"
                                        :class="{
                                            'text-gray-400':
                                                !post.is_liked_by_user,
                                            'text-red-500':
                                                post.is_liked_by_user,
                                        }"
                                    ></i>
                                    <p class="ml-1 flex">
                                        {{ post.likes.length }}
                                        <span class="ml-1">Reaction</span>
                                    </p>
                                </button>
                                <ReactPostSection
                                    :post="post"
                                    :showDropdownEmoji="
                                        showDropdownEmoji[post.id]
                                    "
                                    :emojiIcon="store.state.userOptions"
                                    @updateReaction="updateReaction($event)"
                                ></ReactPostSection>
                            </div>
                            <div
                                class="flex items-center cursor-pointer select-none"
                            >
                                <button v-for="icon in userOptions"
                                    class="flex items-center text-blue-500 rounded px-1 py-1 focus:outline-none hover:bg-blue-100 transition-colors duration-200"
                                >
                                    <i v-if="countedLikes(post.likes).value[icon.value] > 0"
                                        :class="icon.label"
                                    ></i>
                                    <span
                                        class="font-bold text-sm mt-1 ml-[2px]"
                                        >{{ countedLikes(post.likes).value[icon.value] }}</span
                                    >
                                </button>
                            </div>
                            <button
                                @click="toggleCommentSection(post.id)"
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

                        <Transition name="slide-fade" mode="out-in">
                            <CommentSection
                                v-if="showCommentSection[post.id]"
                                :postId="post.id"
                                :commentPostRoute="
                                    route('comment.store-comment')
                                "
                                :isLoadingComment="isLoadingComment"
                                :showCommentSection="showCommentSection"
                                :comments="
                                    comments.filter(
                                        (comment) =>
                                            comment.commentable_id === post.id
                                    )
                                "
                                @load-more-comment="loadMoreComment(post.id)"
                            />
                        </Transition>
                    </div>
                    <!-- Repeat for other posts -->
                    <InfiniteLoading
                        @infinite="load"
                        class="flex justify-center"
                        :slots="test"
                    />
                </div>
                <div class="col-span-1"></div>
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
    components: {
        CommentSection,
    },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
.text-gradient {
    @apply bg-gradient-to-r from-orange-500 to-pink-500 text-transparent bg-clip-text;
}
</style>
