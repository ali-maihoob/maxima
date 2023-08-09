import { createApp } from 'vue'
import App from './App.vue'
import router from './router'; // Import the router instance
import "@/assets/css/style.css";
import AppSkeleton from "@/components/general/skeleton.vue";
import VueAwesomePaginate from "vue-awesome-paginate";

import "vue-awesome-paginate/dist/style.css";
const app = createApp(App);
app.component("app-skeleton", AppSkeleton);
app.use(router)
app.use(VueAwesomePaginate);
app.mount('#app')
