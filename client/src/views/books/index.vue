<template>
    <app-skeleton v-if="loading"></app-skeleton>
    <template v-else>
        <button type="button" @click="$router.push('/books/create')" class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 mr-2 mb-2">
            <svg class="w-3 h-3 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
            Add New Book
        </button>
        <div class="flex items-center justify-between mb-3 mt-4">
            <input
                v-model="searchQuery"
                placeholder="Search books..."
                class="flex-grow px-4 py-2 border rounded-l-lg"
            />
            <button
                @click="getBooks"
                class="px-4 py-2 rounded-r-lg bg-blue-500 text-white hover:bg-blue-600 focus:outline-none"
            >
                Search
            </button>
        </div>
        <div class="relative overflow-x-auto mt-3">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <button @click="sortBy('title')">Title</button>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button @click="sortBy('author')">Author</button>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button @click="sortBy('description')">Description</button>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button @click="sortBy('publication_date')">Publication Date</button>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th style="min-width: 215px;" scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="book in books" :key="book.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ book.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ book.author }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="truncate" style="max-width: 150px; display: block">{{ book.description }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ book.publication_date }}
                    </td>
                    <td class="px-6 py-4">
                        <img v-if="book.image" :src="book.image" alt="Book Cover" class="w-20 h-20 object-cover rounded-md">
                        <span v-else>No Image</span>
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" @click='$router.push("/books/" + book.id)'
                                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            view
                        </button>
                        <button type="button" @click='$router.push("/books/" + book.id + "/edit")'
                                class="px-3 mx-2 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300">
                            edit
                        </button>
                        <button type="button" @click="showConfirm(book.id)"
                                class="px-3 py-2 text-xs font-medium text-center rounded-lg text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300">
                            delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination mt-3">
            <vue-awesome-paginate
                :total-items="totalItems"
                :items-per-page="5"
                :max-pages-shown="5"
                v-model="currentPage"
                :on-click="getBooks"
            />
        </div>
        <div id="popup-modal" :class="{'hidden': !showDeleteConfirm}" tabindex="-1" class="fixed !top-1/4 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full m-auto">
                <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this book?</h3>
                        <button @click="confirmDeleteBook" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, I'm sure
                        </button>
                        <button @click="hideConfirm" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import {customGet, customDelete} from "@/services/axios";
import {VueAwesomePaginate} from "vue-awesome-paginate";
import {alert} from "@/utils/alert";

export default {
    name: 'BookIndex',
    components: {
        VueAwesomePaginate,
    },
    data() {
        return {
            searchQuery: '',
            selectedId: '',
            loading: true,
            showDeleteConfirm: false,
            books: [],
            currentPage: 1, // Current page for pagination
            perPage: 5, // Items per page
            totalItems: 0, // Total number of items
            sortOptions: [
                { label: 'Title', value: 'title' },
                { label: 'Publication Date', value: 'publication_date' },
                { label: 'Description', value: 'description' },
                { label: 'Author', value: 'author' },
            ],
            selectedSort: 'created_at', // Default sorting option
            sortOrder: 'DESC'
        }
    },
    methods: {
        async getBooks() {
            this.loading = true;
            try {
                this.loading = true;
                await customGet(
                    'books',
                    (response) => {
                        this.books = response.data.data;
                        this.totalItems = response.data.meta.total;
                        this.loading = false;
                    },
                    (error) => {
                        console.log(error)
                    },
                    {
                        page: this.currentPage, // Pass the current page for pagination
                        per_page: this.perPage, // Pass the items per page
                        q: this.searchQuery,
                        sort_by: this.selectedSort,
                        sort_order: this.sortOrder
                    }
                );

            } catch (error) {
                console.error(error);
            }
        },
        sortBy(criteria) {
            if (this.selectedSort !== criteria) {
                this.sortOrder = 'ASC';
            } else {
                this.sortOrder = this.flipOrder(this.sortOrder)
            }
            this.selectedSort = criteria;
            this.getBooks();
        },
        showConfirm($id) {
            this.selectedId = $id
            this.showDeleteConfirm = true;
        },
        hideConfirm() {
            this.showDeleteConfirm = false;
        },
        flipOrder(oldOrder) {
            return oldOrder === 'ASC' ? "DESC" : "ASC";
        },
        confirmDeleteBook() {
            customDelete(
                'books/' + this.selectedId,
                (response) => {
                    alert.success(response.data.message);
                    this.hideConfirm();
                    this.getBooks();
                },
                (error) => {
                    console.log(error)
                }
            );
        }
    },
    created() {
        this.getBooks();
    }
}
</script>
<style>
.pagination-container {
    display: flex;
    column-gap: 10px;
}
.paginate-buttons {
    height: 40px;
    width: 40px;
    border-radius: 20px;
    cursor: pointer;
    background-color: rgb(242, 242, 242);
    border: 1px solid rgb(217, 217, 217);
    color: black;
}
.paginate-buttons:hover {
    background-color: #d8d8d8;
}
.active-page {
    background-color: #3498db;
    border: 1px solid #3498db;
    color: white;
}
.active-page:hover {
    background-color: #2988c8;
}
</style>
