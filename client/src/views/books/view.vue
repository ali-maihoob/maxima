<template>
    <app-skeleton v-if="loading"></app-skeleton>
    <div v-else class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-5">{{ book.title }}</h2>
            <div class="flex items-center space-x-2">
                <p class="text-gray-600 font-bold">Author:</p>
                <p class="text-gray-400">{{ book.author }}</p>
            </div>
        </div>
        <hr class="border-gray-200 my-4">
        <div class="mb-4">
            <div class="flex items-center space-x-2">
                <p class="text-gray-600 font-bold">Publication Date:</p>
                <p class="text-gray-400">{{ book.publication_date }}</p>
            </div>
        </div>
        <hr class="border-gray-200 my-4">
        <div class="mb-4">
            <div class="flex items-center space-x-2">
                <p class="text-gray-600 font-bold">Description:</p>
                <p class="text-gray-400">{{ book.description }}</p>
            </div>
        </div>
        <hr class="border-gray-200 my-4">
        <div>
            <div class="flex items-center space-x-2">
                <p class="text-gray-600 font-bold">Created At:</p>
                <p class="text-gray-400">{{ book.created_at }}</p>
            </div>
        </div>

        <!-- Display the cover image if it exists -->
        <div class="mt-4" v-if="book.image">
            <p class="text-gray-600 font-bold">Cover Image:</p>
            <img :src="book.image" alt="Cover Image" class="w-32 h-32 object-cover mt-2">
        </div>
    </div>
</template>


<script>
import {customGet} from "@/services/axios";

export default {
    name: 'BookDetails',
    data() {
        return {
            book: {},
            loading: true
        }
    },
    created() {
        customGet(
            '/books/' + this.$route.params.id,
            (response) => {
                this.book = response.data.data;
                this.loading = false;
            },
            (error) => {
                console.log(error);
            }
        );
    }
};
</script>

<style scoped>
/* Optional component-specific styles can be added here */
</style>
