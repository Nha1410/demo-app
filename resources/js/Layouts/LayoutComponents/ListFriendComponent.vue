<script setup>
import { ref, onMounted} from "vue"
import axios from "axios";

const listFriends = ref([]);
const page = ref(1);
const hasFriendship = ref(1);

const loadFriends = async () => {
    await axios.get(route('friend.get-list')+`?page=${page.value}&hasFriendship=${hasFriendship.value}`)
        .then((res)=> {
            listFriends.value.push(...res.data)
        });
}

onMounted(() => {
    loadFriends();
});
</script>
<template>
    <div class="col-span-3 bg-gray-200 p-4">
        <h2 class="text-xl font-semibold mb-4">Friend List</h2>
        <!-- Friends -->
        <ul v-for="friend in listFriends" :key="friend.id" class="space-y-2">
            <li class="flex items-center space-x-2 mt-2">
                <img src="/images/blank_avt.png" alt="Friend 1" class="w-8 h-8 rounded-full" />
                <span class="text-gray-600">{{ friend.name }}</span>
            </li>
            <!-- Add more friend list items -->
        </ul>
    </div>
</template>