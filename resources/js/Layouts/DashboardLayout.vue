<script setup>
import "vuetify/dist/vuetify.min.css";
import "tw-elements";
import SidebarComponent  from './LayoutComponents/SidebarComponent.vue';
import FooterComponent  from './LayoutComponents/FooterComponent.vue';
import HeaderComponent  from './LayoutComponents/HeaderComponent.vue';


</script>
<template #header>
    <div class="w-full relative flex ct-docs-disable-sidebar-content">
        <SidebarComponent></SidebarComponent>
        <div class="relative md:ml-64 bg-blueGray-100 w-full">
            <HeaderComponent></HeaderComponent>
            <div class="relative pt-32 pb-32 bg-lightBlue-500">
                <slot></slot>
                <FooterComponent></FooterComponent>
            </div>
        </div>
    </div>
</template>
