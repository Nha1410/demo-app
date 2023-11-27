<script>
export default {
    data() {
        return {

       }
    },
    props: {
        showDropdownEmoji: {
            type: Boolean,
            default: false
        },
        emojiIcon: {
            type: Array,
            default: null
        },
        post: {
            type: Object,
            default: {}
        },
        notificationTypes: {
            type: Object,
            default: [],
        }
    },
    setup(props, {emit}) {
        const handleEmojiClick = async(event, emojiType, postId, notificationTypeAction) => {
            console.log(`Selected emoji: ${emojiType}`);
            try {
                const response = await axios.post(route('post.like-specific-post', { post: postId }), {
                    'emoji_type' : emojiType,
                    'notification_type_id' : notificationTypeAction,
                });
                emit('updateReaction', { 'newPost' : response.data, event});
            } catch (error) {
                console.error('Error liking specific post:', error);
            }
        };
        return {
            handleEmojiClick
        }
    }
}
</script>
<template>
    <div v-if="showDropdownEmoji"
        class="dropdown my-1 absolute flex bg-blue-100 rounded-[20px] shadow-md top-[-40px] transform transition-transform transition-opacity duration-500"
        >
        <button
            v-for="icon in emojiIcon"
            :key="icon.value"
            @click="handleEmojiClick($event, icon.value, post.id, notificationTypes.like_post)"
            class="rounded px-2 py-1 focus:outline-none hover:scale-125 hover:text-blue-700"
            >
            <i :class="icon.label"></i>
        </button>
    </div>

</template>
<style>
.transform-enter-active,
.transform-leave-active {
  transition: transform 0.5s;
}
.transform-enter-from,
.transform-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>