import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../pages/LandingPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import RegisterPage from '../pages/RegisterPage.vue';
import DashboardPage from '../pages/DashboardPage.vue';
import ContentsPage from '../pages/ContentsPage.vue';
import ContentDetailPage from '../pages/ContentDetailPage.vue';
import SubscriptionPage from '../pages/SubscriptionPage.vue';
import SocialCallbackPage from '../pages/SocialCallbackPage.vue';
import VerifySuccessPage from '../pages/VerifySuccessPage.vue';

const routes = [
  { path: '/', name: 'landing', component: LandingPage },
  { path: '/login', name: 'login', component: LoginPage },
  { path: '/register', name: 'register', component: RegisterPage },
  { path: '/dashboard', name: 'dashboard', component: DashboardPage },
  { path: '/contents', name: 'contents', component: ContentsPage },
  { path: '/contents/:slug', name: 'content.detail', component: ContentDetailPage, props: true },
  { path: '/subscription', name: 'subscription', component: SubscriptionPage },
  { path: '/login/social-success', component: SocialCallbackPage, name: 'social.callback' },
  { path: '/verify-success', name: 'verify.success', component: VerifySuccessPage },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
