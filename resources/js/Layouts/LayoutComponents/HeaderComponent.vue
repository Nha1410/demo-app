<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import axios from "axios";
import { ref, watch, onMounted } from "vue";
import NotificationDropdown from "./HeaderComponents/NotificationDropdown.vue"

const props = defineProps({
    userInfo: Object
});
let isUserInfoLoaded = ref(false);

const listFriendRequests = ref([]);
const page = 1;

const loadFriendRequests = async () => {
    await axios.get(route("friend.get-list-friend-request"))
        .then((res) => {
            listFriendRequests.value.push(...res.data);
        })
        .catch((err) => {
            console.log("No friend requests");
            // should add toast message
        });
};

const handleFriendRequest = async (payload) => {
    await axios.put(route("friend.handle-friend-request", {
        friendRequest: payload.friendRequestId,
    }),
        { accept: payload.accept })
        .then((res) => {
            if (res.status == 200) {
                listFriendRequests.value.splice(payload.index, 1);
            }
        })
        .catch((error) => {
            console.log("No friend requests");
            // should add toast message
        });
};

const listenNotification = (userInfo) => {
    window.Echo.private(`add-friend-notification.${userInfo.id}`)
        .listen('AddFriendNotification', (res) => {
            console.log('New Notification:', res.newFriendRequest.name);
            listFriendRequests.value.unshift(res.newFriendRequest);
        })
        .error((error) => {
            console.error('Error listening for AddFriendNotification:', error);
        });
};

onMounted(() => {
    loadFriendRequests();
    // make sure the userInfo is loaded in DashboardComponent
    watch(() => props.userInfo, (newUserInfo) => {
        if (newUserInfo) {
            listenNotification(newUserInfo);
            isUserInfoLoaded.value = true;
        }
    });
});
</script>
<template>
    <nav
        class="absolute top-0 left-0 w-full z-10 lg:flex-row lg:flex-nowrap lg:justify-start flex items-center py-1 px-4 lg:bg-blue-100">
        <div class="w-full mx-aut0 items-center flex justify-between lg:flex-nowrap flex-wrap lg:px-6 px-4">
            <a :href="route('post.index')"
                class="text-blueGray-800 lg:text-blue-800 text-sm uppercase inline-block font-semibold my-3">POST</a>
            <button
                class="ml-auto cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-blueGray-400 rounded bg-transparent block outline-none focus:outline-none text-blueGray-300 lg:hidden"
                type="button">
                <i class="fas fa-bars"></i>
            </button>
            <div
                class="items-center w-full lg:flex lg:w-auto flex-grow duration-300 transition-all ease-in-out lg:h-auto-important hidden">
                <div class="flex flex-row items-center w-full justify-center mt-3">
                    <div class="flex flex-row w-[70%] mb-3 pt-0">
                        <input placeholder="Search here" type="text"
                            class=" border-transparent shadow px-3 py-2 text-sm placeholder-blueGray-200 text-blueGray-700 relative bg-white rounded-md outline-none focus:ring focus:ring-lightBlue-500 focus:ring-1 focus:border-lightBlue-500 border border-solid transition duration-200" />
                        <a :href="route('friend.add-friend-template')">
                            <i class="px-3 pt-2 text-blue-700 fa-solid fa-magnifying-glass"></i>
                        </a>
                    </div>
                </div>
                <NotificationDropdown
                    :isAllActive="isAllActive"
                    :listFriendRequests= "listFriendRequests"
                    @toggleAllActive="toggleAllActive"
                    @handleFriendRequest="handleFriendRequest"
                    :contentClasses="{
                        'buttonIcon' : 'px-4 text-gray-600 text-[18px] fa-solid fa-user-group'
                    }"
                >
                </NotificationDropdown>
                <NotificationDropdown
                    :isAllActive="isAllActive"
                    :listFriendRequests= "listFriendRequests"
                    @toggleAllActive="toggleAllActive"
                    @handleFriendRequest="handleFriendRequest"
                    :contentClasses="{
                        'buttonIcon' : 'px-4 text-gray-600 text-[18px] fa-solid fa-message'
                    }"
                >
                </NotificationDropdown>
                <NotificationDropdown
                    :isAllActive="isAllActive"
                    :listFriendRequests= "listFriendRequests"
                    @toggleAllActive="toggleAllActive"
                    @handleFriendRequest="handleFriendRequest"
                    :contentClasses="{
                        'buttonIcon' : 'px-4 text-gray-600 text-[18px] fa-solid fa-bell'
                    }"
                >
                </NotificationDropdown>
                <a class="text-blueGray-500 block" :href="route('user.edit-avatar')">
                    <div class="items-center flex">
                        <span
                            class="w-12 h-12 text-sm text-white bg-blueGray-300 inline-flex items-center justify-center rounded-full"><img
                                alt="..."
                                class="w-[3rem] h-[3rem] rounded-full align-middle border-none shadow-lg object-cover"
                                :src="userInfo.profile_image" /></span>
                    </div>
                </a>
                <div class="block z-50">
                    <div
                        class="bg-white text-base float-left p-2 border list-none text-left rounded-lg shadow-lg min-w-48 transition-all duration-100 ease-in-out transform scale-95 opacity-0 absolute origin-top-right">
                        <a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100">Action</a><a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100">Another
                            action</a><a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100">Something
                            else here</a>
                        <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                        <a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100">Seprated
                            link</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    props: {
        userInfo: Object,
    },
    data() {
        return {
            showNotification: false,
            isAllActive: false,
            isUnreadActive: true
        };
    },
    methods: {
        toggleAllActive() {
            this.isAllActive = !this.isAllActive;
            this.isUnreadActive = !this.isUnreadActive;
        }
    }

};
</script>
<style>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.button-choose-active {
    transition: all .2s ease-in-out;
    transform: scale(1);
}

.button-choose-active:hover,
.button-choose-active:focus {
    transform: scale(1.05);
    background-color: #48cf80;
}
</style>