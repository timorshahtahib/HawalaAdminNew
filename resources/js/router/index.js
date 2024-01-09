import { createRouter, createWebHistory } from 'vue-router'

const routes = [{
        path: '/',
        name: 'dashboard',
        meta: {
            title: 'Dashboard',
            authRequired: true,
        },
        component: () =>
            import ('../views/home.vue'),
    },
    {
        path: '/dashboard/customer',
        meta: { title: 'Dashboard' },
        component: () =>
            import ('../views/dashboard/customer/customer.vue')
    },
    {
        path: '/dashboard/customer/:id',
        meta: { title: 'Dashboard' },
        component: () =>
            import ('../views/dashboard/customer/profile.vue')
    },
    {
        path: '/dashboard/finance_account',
        meta: { title: 'finance_account', authRequired: true, },
        component: () =>
            import ('../views/dashboard/financeAccount/financeAccount.vue'),
    },
    {
        path: '/dashboard/order',
        meta: { title: 'Order', authRequired: true, },
        component: () =>
            import ('../views/dashboard/order/order.vue'),
    },
    {
        path: '/dashboard/currency',
        meta: { title: 'Currency', authRequired: true, },
        component: () =>
            import ('../views/dashboard/currency/currency.vue'),
    },
    {
        path: '/dashboard/income_expense',
        meta: { authRequired: true, title: 'income_expense' },
        component: () =>
            import ('../views/dashboard/incomExpense/incomeExpense.vue'),
    },
    {
        path: '/dashboard/expense',
        meta: { authRequired: true, title: 'expense' },
        component: () =>
            import ('../views/dashboard/expense/expense.vue'),
    },

    {
        path: '/dashboard/rasidbord',
        meta: { title: 'رسید برد' },
        component: () =>
            import ('../views/dashboard/rasidBord/rasidBord.vue')
    },
    {
        path: '/report/financereport',
        meta: { title: 'گزارش بانک ها' },
        component: () =>
            import ('../views/report/FinanceReport.vue')
    },
    {
        path: '/charts/chartjs',
        meta: { authRequired: true, title: 'Chartjs' },
        component: () =>
            import ('../views/charts/chartjs/index.vue')
    },
    {
        path: '/report/financereport/bankDetails/:id',
        name: 'bankDetails',
        meta: { authRequired: true, title: 'Bank details' },
        component: () =>
            import ('../views/report/bankDetails.vue')
    },
    {
        path: '/exchange/buy',
        name: 'buy',
        meta: { authRequired: true, title: 'Buy' },
        component: () =>
            import ('../views/dashboard/exchange/buy.vue')
    },
    {
        path: '/exchange/sale',
        name: 'sale',
        meta: { authRequired: true, title: 'Sale' },
        component: () =>
            import ('../views/dashboard/exchange/sale.vue')
    },

    {
        path: '/auth/login-1',
        meta: { authRequired: true, title: 'Login' },
        component: () =>
            import ('../views/sample-pages/login-sample.vue')
    },
    {
        path: '/login',
        name: 'login',
        meta: { title: 'Login' },
        component: () =>
            import ('../views/account/login.vue')
    },
    {
        path: '/auth/register',
        name: 'register',
        meta: { title: 'Register' },
        component: () =>
            import ('../views/account/register.vue')
    },
    {
        path: '/auth/login-2',
        meta: { authRequired: true, title: 'Login' },
        component: () =>
            import ('../views/sample-pages/login-2.vue')
    },
    {
        path: '/auth/register-1',
        meta: { title: 'Register' },
        component: () =>
            import ('../views/account/register.vue')
    },
    {
        path: '/forget-password',
        meta: { title: 'Forget Password' },
        component: () =>
            import ('../views/account/forgot-password.vue')
    },
    {
        path: '/reset-password/:token',
        meta: { title: 'Reset Password' },
        component: () =>
            import ('../views/account/reset-password.vue')
    },
    {
        path: '/auth/register-2',
        meta: { authRequired: true, title: 'Register' },
        component: () =>
            import ('../views/sample-pages/register-2.vue')
    },
    {
        path: '/auth/recoverpw',
        meta: { authRequired: true, title: 'Reset Password' },
        component: () =>
            import ('../views/sample-pages/recoverpw-sample.vue')
    },
    {
        path: '/auth/recoverpwd-2',
        meta: { authRequired: true, title: 'Reset Password' },
        component: () =>
            import ('../views/sample-pages/recoverpwd-2.vue')
    },


    {
        path: '/auth/confirm-mail',
        meta: { authRequired: true, title: 'Confirm Mail' },
        component: () =>
            import ('../views/sample-pages/confirm-mail.vue')
    },
    {
        path: '/auth/confirm-mail-2',
        meta: { authRequired: true, title: 'Confirm Mail' },
        component: () =>
            import ('../views/sample-pages/confirm-mail-2.vue')
    },
    {
        path: '/auth/email-verification',
        meta: { authRequired: true, title: 'Email Verification' },
        component: () =>
            import ('../views/sample-pages/email-verification.vue')
    },
    {
        path: '/auth/email-verification-2',
        meta: { authRequired: true, title: 'Email Verification' },
        component: () =>
            import ('../views/sample-pages/email-verification-2.vue')
    },
    {
        path: '/auth/two-step-verification',
        meta: { authRequired: true, title: 'Two Step Verification' },
        component: () =>
            import ('../views/sample-pages/two-step-verification.vue')
    },
    {
        path: '/auth/two-step-verification-2',
        meta: { authRequired: true, title: 'Two Step Verification' },
        component: () =>
            import ('../views/sample-pages/two-step-verification-2.vue')
    },




]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Before each route evaluates...
router.beforeEach(async(routeTo, routeFrom, next) => {
    // set title name
    if (routeTo.meta.title != undefined) {
        document.title = routeTo.meta.title + " | Asia Telecom Admin Panel";
    }

    const authRequired = routeTo.matched.some((route) => route.meta.authRequired);
    if (!authRequired) return next();

    if (localStorage.getItem('user')) {
        next();
    } else {
        next({ name: 'login', query: { redirectFrom: routeTo.fullPath } });
    }

});

export default router;