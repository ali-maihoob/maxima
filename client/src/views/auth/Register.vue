<template>
    <div class="flex justify-center items-center mt-52">
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-2xl rounded px-8 pt-6 pb-8 mb-4">
                <div class="identity-input mb-4">
                    <label
                        for="name"
                        class="block text-gray-700 text-sm font-bold mb-2 text-left"
                    >
                        Name</label
                    >
                    <input
                        id="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        type="text"
                        placeholder="Name"
                        v-model="name"
                    />
                    <span v-if="errors.name" class="text-xs text-red-700">{{ errors.name }}</span>
                </div>

                <div class="identity-input mb-4">
                    <label
                        for="email"
                        class="block text-gray-700 text-sm font-bold mb-2 text-left"
                    >
                        Email</label
                    >
                    <input
                        id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        type="text"
                        placeholder="Email"
                        v-model="email"
                    />
                    <span v-if="errors.email" class="text-xs text-red-700">{{ errors.email }}</span>
                </div>

                <div class="password-input mb-4">
                    <label
                        for="password"
                        class="block text-gray-700 text-sm font-bold mb-2 text-left"
                    >Password</label
                    >

                    <input
                        id="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        type="password"
                        placeholder="*******"
                        v-model="password"
                    />
                    <span v-if="errors.password" class="text-xs text-red-700">{{ errors.password }}</span>
                </div>

                <div class="password-input mb-6">
                    <label
                        for="password_confirmation"
                        class="block text-gray-700 text-sm font-bold mb-2 text-left"
                    >Password Confirmation</label
                    >

                    <input
                        id="password_confirmation"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        type="password"
                        placeholder="*******"
                        v-model="password_confirmation"
                    />
                    <span v-if="errors.password_confirmation" class="text-xs text-red-700">{{ errors.password_confirmation }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        @click="register"
                        class="bg-blue-600 hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                    >
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { customPost } from '@/services/axios';
import { alert } from "@/utils/alert";

export default {
    name: 'RegisterPage',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        };
    },
    methods: {
        register() {
            this.validateForm();

            if (Object.values(this.errors).every(error => error === '')) {
                const registerData = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                };

                customPost('/register', registerData, this.handleSuccess, this.handleFailure);
            }
        },
        validateForm() {
            this.errors = {
                name: this.name ? '' : 'Name is required.',
                email: this.isValidEmail(this.email) ? '' : 'Invalid email format.',
                password: this.password ? '' : 'Password is required.',
                password_confirmation: this.password_confirmation ? (this.password === this.password_confirmation ? '' : 'Passwords do not match.') : 'Password confirmation is required.'
            };
        },
        isValidEmail(email) {
            // You can use a regular expression or other email validation logic here
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },
        handleSuccess(response) {
            alert.success(response.data.message);
            this.$router.push('/login');
        },
        handleFailure(error) {
            alert.error(error.response.data.message);
        },
    },
};
</script>
