<template>
    <div class="flex justify-center items-center mt-52">
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-2xl rounded px-8 pt-6 pb-8 mb-4">
                <div class="identity-input mb-4">
                    <label
                        for="identity"
                        class="block text-gray-700 text-sm font-bold mb-2"
                    >
                        Email</label
                    >
                    <input
                        id="identity"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        type="text"
                        placeholder="Email"
                        aria-describedby="emailHelp"
                        v-model="email"
                        @blur="validateEmail"
                    />
                    <span class="text-xs text-red-700" id="emailHelp">{{ emailError }}</span>
                </div>

                <div class="password-input mb-6">
                    <label
                        for="identity"
                        class="block text-gray-700 text-sm font-bold mb-2"
                    >Password</label
                    >

                    <input
                        aria-describedby="passwordHelp"
                        v-model="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password"
                        type="password"
                        placeholder="*******"
                        @blur="validatePassword"
                    />
                    <span class="text-xs text-red-700" id="passwordHelp">{{ passwordError }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        @click="login"
                        class="bg-blue-600 hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                    >
                        Sign In
                    </button>
                </div>

                <div class="mt-5">
                    <a class="text-blue-500 text-left flex cursor-pointer" @click="$router.push('/register')">You don't have an account ? create one</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { customPost } from '@/services/axios';
import {alert} from "@/utils/alert";

export default {
    name: 'Login-Page',
    data() {
        return {
            email: '',
            password: '',
            emailError: '',
            passwordError: '',
        };
    },
    methods: {
        validateEmail() {
            if (!this.email) {
                this.emailError = 'Email is required.';
            } else if (!/\S+@\S+\.\S+/.test(this.email)) {
                this.emailError = 'Email is not valid.';
            } else {
                this.emailError = '';
            }
        },
        validatePassword() {
            if (!this.password) {
                this.passwordError = 'Password is required.';
            } else {
                this.passwordError = '';
            }
        },
        validateForm() {
            this.validateEmail();
            this.validatePassword();
            return !this.emailError && !this.passwordError;
        },
        login() {
            if (this.validateForm()) {
                const loginData = {
                    email: this.email,
                    password: this.password,
                };
                customPost('/login', loginData, this.handleSuccess, this.handleFailure);
            }
        },
        handleSuccess(response) {
            const token = response?.data.data.token;

            // Store the token in local storage
            localStorage.setItem('token', token);
            alert.success(response?.data.message);

            // Redirect the user to the desired route (e.g., dashboard)
            this.$router.push('/');
        },
        handleFailure(error) {
            alert.error(error.response?.data.message);
        },
    },
};
</script>
