<script setup>
import "vuetify/dist/vuetify.min.css";
import "tw-elements";
import SidebarComponent from './LayoutComponents/SidebarComponent.vue';
import FooterComponent from './LayoutComponents/FooterComponent.vue';
import HeaderComponent from './LayoutComponents/HeaderComponent.vue';
import ListFriendComponent from './LayoutComponents/ListFriendComponent.vue';
import { ref, onMounted } from "vue";

const userInfo = ref([]);

const loadUserInfo = async () => {
    try {
        const response = await axios.get('/user/get-user-info');
        userInfo.value = response.data;
        return response.data;
    } catch (error) {
        console.error('Error loading user info', error);
    }
};
onMounted(
    loadUserInfo
);
</script>
<template #header >
    <div class="w-full relative flex ct-docs-disable-sidebar-content">
        <SidebarComponent
            :userInfo="userInfo"
        >
        </SidebarComponent>
        <div class="relative md:ml-64 bg-blueGray-100 w-full">
            <HeaderComponent
                :userInfo="userInfo"
            ></HeaderComponent>
            <div class="relative pt-16 pb-32 bg-lightBlue-500">
                <div class="bg-[#F0F2F5] grid grid-cols-12 gap-4">
                    <slot></slot>
                    <ListFriendComponent></ListFriendComponent>
                </div>
                <FooterComponent></FooterComponent>
            </div>
        </div>
    </div>
</template>
<script>
export default {
}
</script>