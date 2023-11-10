<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import axios from "axios";
import { ref, onMounted } from "vue";

const listFriendRequests = ref([]);
const page = 1;

const loadFriendRequests = async () => {
    await axios.get(route("friend.get-list-friend-request")).then((res) => {
        listFriendRequests.value.push(...res.data);
    });
};

const handleFriendRequest = async (friendRequestId, accept, index) => {
    await axios.put(route("friend.handle-friend-request", {
        friendRequest: friendRequestId,
    }),
        { accept: accept })
        .then((res) => {
            console.log(res.status);
            if (res.status == 200) {
                listFriendRequests.value.splice(index, 1);
            }
        })
        .catch((error) => {
            console.error(error);
        });
};

onMounted(() => {
    loadFriendRequests();
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
                <Dropdown align="right" width="96" contentClasses="py-1 bg-white w-[420px]">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button" class="flex cursor-pointer mr-2">
                                <i class="px-4 text-gray-600 text-[18px] fa-solid fa-user-group"></i>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <div class="h-auto">
                            <h1 class="font-bold text-[18px] p-4">Notification</h1>
                            <div class="flex flex-row gap-x-2 justify-evenly">
                                <button type="button" class="button-choose-active py-1 px-[40px] rounded-[15px]"
                                    :class="{ 'mb-2 bg-green-400': isAllActive, 'mb-4 bg-gray-200': !isAllActive }" @click="toggleAllActive">
                                    Unread
                                </button>

                                <button type="button" class="button-choose-active bg-gray-200 py-1 px-[40px] rounded-[15px]"
                                    :class="{ 'mb-2 bg-green-400': !isAllActive, 'mb-4 bg-gray-200': isAllActive }" @click="toggleAllActive">
                                    All
                                </button>
                            </div>
                            <div class="p-4">
                                <TransitionGroup name="list" tag="ul" enter-active-class="transition ease-out duration-1000"
                                    enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-1000"
                                    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"
                                    class="py-2">
                                    <li v-for="(friendRequest, index) in listFriendRequests" :key="friendRequest.id"
                                        class="bg-gray-100 rounded-lg p-2 mb-2">
                                        <div v-if="friendRequest" class="flex flex-row gap-x-2 items-center">
                                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                                <img src="/images/blank_avt.png" />
                                            </div>
                                            <p>
                                                You have a friend request from
                                                <span class="font-bold">{{ friendRequest.sender.name }}</span>
                                            </p>
                                            <div class="">
                                                <button @click="handleFriendRequest(friendRequest.id, true, index)"
                                                    class="text-green-500 px-2 py-1 rounded-md">
                                                    <i class="fa-solid fa-check"></i>
                                                    Accept
                                                </button>
                                                <button @click="handleFriendRequest(friendRequest.id, false, index)"
                                                    class="text-red-500 px-2 py-1 rounded-md">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    Decline
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </TransitionGroup>
                            </div>
                        </div>
                    </template>

                </Dropdown>
                <div class="py-1">
                    <span class="inline-flex rounded-md">
                        <button type="button" class="flex cursor-pointer mr-2">
                            <i class="px-4 text-gray-600 text-[18px] fa-solid fa-message"></i>
                        </button>
                    </span>
                </div>
                <div class="py-1">
                    <span class="inline-flex rounded-md">
                        <button type="button" class="flex cursor-pointer mr-2">
                            <i class="px-4 text-gray-600 text-[18px] fa-solid fa-bell"></i>
                        </button>
                    </span>
                </div>
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