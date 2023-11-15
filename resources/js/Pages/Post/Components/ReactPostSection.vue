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
        }
    }
}
</script>
<template>
    <div v-if="showDropdownEmoji"
        class="dropdown absolute flex bg-gray-100 rounded shadow-md top-[-35px] ">
        <button
            class="text-blue-500 rounded px-2 py-1 focus:outline-none hover:scale-125 hover:text-blue-700 transition-colors duration-200">
            <i class="fa-solid fa-thumbs-up"></i>
        </button>
        <button
            class="text-red rounded px-2 py-1 focus:outline-none hover:scale-125 hover:text-red-700 transition-colors duration-200">
            <i class="fa-solid fa-heart"></i>
        </button>
        <button
            class="text-yellow-500 rounded px-2 py-1 focus:outline-none hover:scale-125 hover:text-yellow-700 transition-colors duration-200">
            <i class="fa-solid fa-face-laugh"></i>
        </button>
    </div>

</template>