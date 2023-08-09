<template>
    <app-skeleton v-if="basicLoading"></app-skeleton>
    <div v-else class="bg-white shadow-md rounded-lg p-6">
        <form>
            <div class="mb-4">
                <label for="title" class="block text-gray-600 font-bold">Title:</label>
                <input v-model="book.title" type="text" id="title" class="form-input mt-1 w-full" required>
            </div>
            <div class="mb-4">
                <label for="author" class="block text-gray-600 font-bold">Author:</label>
                <input v-model="book.author" type="text" id="author" class="form-input mt-1 w-full" required>
            </div>
            <div class="mb-4">
                <label for="publication_date" class="block text-gray-600 font-bold">Publication Date:</label>
                <input v-model="book.publication_date" type="date" id="publication_date" class="form-input mt-1 w-full"
                       required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-600 font-bold">Description:</label>
                <textarea v-model="book.description" id="description" class="form-input mt-1 w-full" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-600 font-bold">Cover Image:</label>
                <input type="file" accept="image/*" @change="onImageChange">
                <img v-if="imagePreview" :src="imagePreview" alt="Cover Image" class="w-32 h-32 object-cover mt-2">
            </div>
            <button v-if="loading" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                </svg>
                Loading...
            </button>
            <button v-if="!loading" type="button" @click="save"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300">
                Save
            </button>
        </form>
    </div>
</template>

<script>
import {customPost, customGet} from "@/services/axios";
import {alert} from "@/utils/alert";

export default {
    name: 'AddBook',
    data() {
        return {
            loading: false,
            basicLoading: false,
            selectedImage: null,
            imagePreview: null,
            book: {
                title: '',
                author: '',
                publication_date: '',
                description: '',
            },
        };
    },
    created() {
        if (this.$route.params.id) {
            this.basicLoading = true;
            customGet(
                '/books/' + this.$route.params.id,
                (response) => {
                    this.book = response.data.data;
                    this.imagePreview = this.book.image;
                    this.basicLoading = false;
                },
                (error) => {
                    console.log(error);
                }
            );
        }
    },
    methods: {
        onImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedImage = file;
                this.imagePreview = URL.createObjectURL(file);
            }
        },
        save() {
            if (this.$route.params.id) {
                this.editBook();
            } else {
                this.addBook();
            }
        },
        async addBook() {
            try {
                this.loading = true;
                const formData = new FormData();
                formData.append('title', this.book.title);
                formData.append('author', this.book.author);
                formData.append('publication_date', this.book.publication_date);
                formData.append('description', this.book.description);
                if (this.selectedImage) {
                    formData.append('image', this.selectedImage);
                }
                await customPost(
                    'books',
                    formData,
                    (response) => {
                        this.$router.push('/books');
                        alert.success(response.data.message);
                        this.loading = false;
                    },
                    (error) => {
                        this.loading = false;
                        alert.error(error.response.data.message);
                    }
                );
            } catch (error) {
                await alert.error(error.message);
            }
        },
        async editBook() {
            try {
                this.loading = true;
                const formData = new FormData();
                formData.append("_method", "PUT")
                formData.append('title', this.book.title);
                formData.append('author', this.book.author);
                formData.append('publication_date', this.book.publication_date);
                if (this.book.description) {
                    formData.append('description', this.book.description);
                }
                if (this.selectedImage) {
                    formData.append('image', this.selectedImage);
                }
                await customPost(
                    'books/' + this.$route.params.id,
                    formData,
                    (response) => {
                        this.$router.push('/books');
                        alert.success(response.data.message);
                        this.loading = false;
                    },
                    (error) => {
                        this.loading = false;
                        alert.error(error.response.data.message);
                    }
                );
            } catch (error) {
                console.error(error);
            }
        }
    },
};
</script>

<style scoped>
.text-indigo-600 {
    color: #4F46E5;
}

.text-gray-600 {
    color: #6B7280;
}

.form-input {
    border: 1px solid #E5E7EB;
    padding: 0.5rem;
}
</style>
