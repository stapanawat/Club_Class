import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// ✅ ให้ axios ของฝั่ง Vue ยิงไปที่ /api/*
axios.defaults.baseURL = '/api';
axios.defaults.withCredentials = true;

// ✅ แชร์ axios ไว้บน window เผื่อใช้ที่อื่น
window.axios = axios;

// ✅ ดึง token จาก localStorage แล้วแปะ Authorization header
const TOKEN_KEY = 'auth_token';
const token = localStorage.getItem(TOKEN_KEY);
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const app = createApp(App);
app.use(router);

// เผื่ออยากเรียก this.$axios
app.config.globalProperties.$axios = axios;

app.mount('#app');
