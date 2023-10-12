<template>
    <nav
        class="absolute top-0 left-0 w-full z-10 lg:flex-row lg:flex-nowrap lg:justify-start flex items-center py-1 px-4 lg:bg-blue-100"
    >
        <div
            class="w-full mx-aut0 items-center flex justify-between lg:flex-nowrap flex-wrap lg:px-6 px-4"
        >
            <a  href="/post"
                class="text-blueGray-800 lg:text-blue-800 text-sm uppercase inline-block font-semibold my-3"
                >Home Page</a
            >
            <button
                class="ml-auto cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-blueGray-400 rounded bg-transparent block outline-none focus:outline-none text-blueGray-300 lg:hidden"
                type="button"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div
                class="items-center w-full lg:flex lg:w-auto flex-grow duration-300 transition-all ease-in-out lg:h-auto-important hidden"
            >
                <form
                    class="flex flex-row flex-wrap items-center ml-auto mr-3 mt-3"
                >
                    <div class="mb-3 pt-0">
                        <input
                            placeholder="Search here"
                            type="text"
                            class="border-transparent shadow px-3 py-2 text-sm w-full placeholder-blueGray-200 text-blueGray-700 relative bg-white rounded-md outline-none focus:ring focus:ring-lightBlue-500 focus:ring-1 focus:border-lightBlue-500 border border-solid transition duration-200"
                        />
                    </div>
                </form>
                <a class="text-blueGray-500 block" href="/user/edit-avatar">
                    <div class="items-center flex">
                        <span
                            class="w-12 h-12 text-sm text-white bg-blueGray-300 inline-flex items-center justify-center rounded-full"
                            ><img
                                alt="..."
                                class="w-full rounded-full align-middle border-none shadow-lg"
                                :src=userInfo.profile_image
                        /></span>
                    </div>
                </a>
                <div class="block z-50">
                    <div
                        class="bg-white text-base float-left p-2 border list-none text-left rounded-lg shadow-lg min-w-48 transition-all duration-100 ease-in-out transform scale-95 opacity-0 absolute origin-top-right"
                    >
                        <a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100"
                            >Action</a
                        ><a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100"
                            >Another action</a
                        ><a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100"
                            >Something else here</a
                        >
                        <div
                            class="h-0 my-2 border border-solid border-blueGray-100"
                        ></div>
                        <a
                            class="text-sm px-3 py-2 block w-full whitespace-nowrap bg-transparent hover:bg-blueGray-100 rounded transition-all duration-100"
                            >Seprated link</a
                        >
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
    setup(props) {
    // Access the prop using 'props'
    }
}
</script>