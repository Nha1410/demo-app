<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import 'vuetify/dist/vuetify.min.css'
import { ref, onMounted } from "vue";
import axios from "axios";

const listNoneFriends = ref([]);
const page = ref(1);

const loadFriends = async () => {
    await axios.get(route('friend.get-list')+`?page=${page.value}`)
        .then((res)=> {
            listNoneFriends.value.push(...res.data)
        });
}
const loadMoreFriend = async () => {
    page.value++;
    await loadFriends();
}
onMounted(() => {
    loadFriends();
});
</script>

<template>
    <DashboardLayout>
        <div class="col-span-9 mt-4">
            <div class="friend-list-container">
                <h2 class="text-2xl font-bold mb-4">Danh sách bạn bè</h2>
                <div v-for="friend in listNoneFriends" :key="friend.id" class="friend-card">
                    <img src="/images/image-1@2.jpg" alt="Friend Avatar" class="rounded-full w-16 h-16 object-cover mb-2">
                    <p class="font-semibold">{{ friend.name }}</p>
                    <button @click="sendFriendRequest(friend.id)" class="hover:bg-blue-300 bg-blue-500 text-white px-4 py-2 rounded-full">
                        Kết Bạn
                    </button>
                </div>
                <div class="flex mb-4 items-center justify-center">
                    <button
                    @click="loadMoreFriend()"
                    class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        Button
                    </button>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
<script>

export default {
    data() {
        return {
        };
    },
    methods: {
        sendFriendRequest(userId) {
            console.log(`Adding friend with ID: ${userId}`);
        },
    },
};
</script>
<style scoped>
/* Thêm các tùy chỉnh CSS theo yêu cầu */
.friend-list-container {
    max-width: 600px;
    margin: 0 auto;
}

.friend-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 16px;
}
</style>
