<script setup>
import Dropdown from "@/Components/Dropdown.vue";
</script>
<template>
    <Dropdown align="right" width="96" contentClasses="py-1 bg-white w-[420px]">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button type="button" class="flex cursor-pointer mr-2">
                    <i :class="contentClasses.buttonIcon"></i>
                </button>
                <div v-if="isShowUnreadNotification"
                    class="absolute w-2 h-2 bg-red top-[-10%] right-[30%] rounded"
                ></div>
            </span>
        </template>
        <template #content>
            <div class="h-auto">
                <h1 class="font-bold text-[18px] p-4">Notification</h1>
                <div class="flex flex-row gap-x-2 justify-evenly">
                    <button
                        type="button"
                        class="button-choose-active py-1 px-[40px] rounded-[15px]"
                        :class="{
                            'mb-2 bg-green-400': isAllActive,
                            'mb-4 bg-gray-200': !isAllActive,
                        }"
                        @click="$emit('toggleAllActive')"
                    >
                        Unread
                    </button>

                    <button
                        type="button"
                        class="button-choose-active bg-gray-200 py-1 px-[40px] rounded-[15px]"
                        :class="{
                            'mb-2 bg-green-400': !isAllActive,
                            'mb-4 bg-gray-200': isAllActive,
                        }"
                        @click="$emit('toggleAllActive')"
                    >
                        All
                    </button>
                </div>
                <div class="p-4">
                    <TransitionGroup
                        name="list"
                        tag="ul"
                        enter-active-class="transition ease-out duration-1000"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-1000"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                        class="py-2"
                    >
                        <li
                            v-for="(friendRequest, index) in listFriendRequests"
                            :key="friendRequest.id"
                            class="bg-gray-100 rounded-lg p-2 mb-2"
                        >
                            <div
                                v-if="friendRequest"
                                class="flex flex-row gap-x-2 items-center"
                            >
                                <div class="w-10 rounded-full overflow-hidden">
                                    <img
                                        :src="
                                            friendRequest.sender.profile_image
                                        "
                                    />
                                </div>
                                <p>
                                    You have a friend request from
                                    <span class="font-bold">{{
                                        friendRequest.sender.name
                                    }}</span>
                                </p>
                                <div class="">
                                    <button
                                        @click="
                                            $emit('handleFriendRequest', {
                                                friendRequestId:
                                                    friendRequest.id,
                                                accept: true,
                                                index: index,
                                            })
                                        "
                                        class="text-green-500 px-2 py-1 rounded-md"
                                    >
                                        <i class="fa-solid fa-check"></i>
                                        Accept
                                    </button>
                                    <button
                                        @click="
                                            $emit('handleFriendRequest', {
                                                friendRequestId:
                                                    friendRequest.id,
                                                accept: false,
                                                index: index,
                                            })
                                        "
                                        class="text-red-500 px-2 py-1 rounded-md"
                                    >
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
</template>
<script>
export default {
    props: {
        isAllActive: {
            type: Boolean,
            default: false,
        },
        listFriendRequests: {
            type: Array,
            default: [],
        },
        contentClasses: {
            type: Object,
            default: {},
        },
        isShowUnreadNotification: {
            type: Boolean,
            default: false,
        }
    },
};
</script>
