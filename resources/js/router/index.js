import { createRouter, createWebHistory } from 'vue-router'

const routes = [{
        path: '/',
        name: 'dashboard',
        meta: {
            authRequired: true,
            title: 'Dashboard',
        },
        component: () =>
            import ('../views/home.vue'),
    },
    {
        path: '/dashboard/usermangement',
        meta: { authRequired: true, title: 'Dashboard' },
        component: () =>
            import ('../views/user/usermangement.vue')
    },
    {
        path: '/dashboard/customer',
        meta: { authRequired: true, title: 'Dashboard' },
        component: () =>
            import ('../views/dashboard/customer/customer.vue')
    },
    {
        path: '/dashboard/customer/:id',
        meta: { authRequired: true, title: 'Dashboard' },
        component: () =>
            import ('../views/dashboard/customer/profile.vue')
    },
    {
        path: '/dashboard/customer/:id/export',
        meta: { authRequired: true, title: 'Dashboard' },
        component: () =>
            import ('../views/dashboard/customer/exportCustomer.vue'),
    },
    {
        path: '/dashboard/finance_account',
        meta: { authRequired: true, title: 'finance_account' },
        component: () =>
            import ('../views/dashboard/financeAccount/financeAccount.vue'),
    },
    {
        path: '/dashboard/order',
        meta: { authRequired: true, title: 'Order', },
        component: () =>
            import ('../views/dashboard/order/order.vue'),
    },
    {
        path: '/dashboard/acceptorder',
        meta: { authRequired: true, title: 'Order', },
        component: () =>
            import ('../views/dashboard/order/acceptOrder.vue'),
    },
    {
        path: '/dashboard/pendingorder',
        meta: { authRequired: true, title: 'Order', },
        component: () =>
            import ('../views/dashboard/order/pendingOder.vue'),
    },
    {
        path: '/dashboard/rejectorder',
        meta: { authRequired: true, title: 'Order', },
        component: () =>
            import ('../views/dashboard/order/rejectOrder.vue'),
    },
    {
        path: '/dashboard/currency',
        meta: { authRequired: true, title: 'Currency', },
        component: () =>
            import ('../views/dashboard/currency/currency.vue'),
    },
    {
        path: '/dashboard/expense',
        meta: { authRequired: true, title: 'expense' },
        component: () =>
            import ('../views/dashboard/expense/expense.vue'),
    },
    {
        path: '/dashboard/rasidbord',
        meta: { authRequired: true, title: 'رسید برد' },
        component: () =>
            import ('../views/dashboard/rasidBord/rasidBord.vue')
    },
    {
        path: '/report/financereport',
        meta: { authRequired: true, title: 'گزارش بانک ها' },
        component: () =>
            import ('../views/report/FinanceReport.vue')
    },
    {
        path: '/report/borrowpaid',
        meta: { authRequired: true, title: 'Borrow and Paid' },
        component: () =>
            import ('../views/report/BorrowPaid.vue')
    },
    {
        path: '/report/financereport/bankDetails/:id',
        name: 'bankDetails',
        meta: { authRequired: true, title: 'Bank details' },
        component: () =>
            import ('../views/report/bankDetails.vue')
    },
    {
        path: '/report/rooznamchah',
        meta: { authRequired: true, title: 'روزنامچه' },
        component: () =>
            import ('../views/report/rooznamchah.vue')
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
        path: '/exchange/transfer',
        name: 'transfer',
        meta: { authRequired: true, title: 'Transfer' },
        component: () =>
            import ('../views/dashboard/exchange/transfer.vue')
    },

    {
        path: '/login',
        name: 'login',
        meta: { title: 'Login' },
        component: () =>
            import ('../views/account/login.vue')
    },
    {
        path: '/register',
        name: 'register',
        meta: { title: 'Register' },
        component: () =>
            import ('../views/account/register.vue')
    },
    // {
    //     path: '/forget-password',
    //     meta: { title: 'Forget Password' },
    //     component: () =>
    //         import ('../views/account/forgot-password.vue')
    // },
    // {
    //     path: '/reset-password/:token',
    //     meta: { title: 'Reset Password' },
    //     component: () =>
    //         import ('../views/account/reset-password.vue')
    // },
    // {
    //     path: '/auth/recoverpw',
    //     meta: { authRequired: true, title: 'Reset Password' },
    //     component: () =>
    //         import ('../views/sample-pages/recoverpw-sample.vue')
    // },
    // {
    //     path: '/auth/recoverpwd-2',
    //     meta: { authRequired: true, title: 'Reset Password' },
    //     component: () =>
    //         import ('../views/sample-pages/recoverpwd-2.vue')
    // },
    // {
    //     path: '/auth/confirm-mail',
    //     meta: { authRequired: true, title: 'Confirm Mail' },
    //     component: () =>
    //         import ('../views/sample-pages/confirm-mail.vue')
    // },
    // {
    //     path: '/auth/email-verification',
    //     meta: { authRequired: true, title: 'Email Verification' },
    //     component: () =>
    //         import ('../views/sample-pages/email-verification.vue')
    // },




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