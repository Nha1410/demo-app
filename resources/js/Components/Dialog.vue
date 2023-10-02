<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="auto">
            <template v-slot:activator="{ props }">
                <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
            </template>

            <v-card>
                <v-card-text> 
                    <div class="w-full">
                        <span>Upload your avatar here</span>
                    </div>
                </v-card-text>
                <v-divider
                    :thickness="10"
                    class="border-opacity-100"
                    color="#000"
                ></v-divider>
                <v-card-actions>
                    <v-btn color="primary" 
                    block
                    @click="dialog = false"
                    >
                        Close Dialog
                    </v-btn
                >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dialog: false,
        };
    },
};
</script>
