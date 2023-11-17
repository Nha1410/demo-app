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
        }
    },
    setup(props, {emit}) {
        const handleEmojiClick = async(event, emojiType, postId) => {
            console.log(`Selected emoji: ${emojiType}`);
            console.log(postId);
            try {
                const response = await axios.post(route('post.like-specific-post', { post: postId }), {
                    'emoji_type' : emojiType,
                });
                console.log('Response:', response.data);
                emit('endHover', event);
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
        class="dropdown py-1 absolute flex bg-gray-100 rounded shadow-md top-[-35px]">
        <button v-for="icon in emojiIcon" :key="icon.value" @click="handleEmojiClick($event, icon.value, post.id)"
            class="rounded px-2 py-1 focus:outline-none hover:scale-125 hover:text-blue-700 transition-colors duration-200">
            <i :class="icon.label"></i>
        </button>
    </div>

</template>