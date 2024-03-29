export const menuItems = [{
        id: 1,
        label: 'خانه',
        icon: 'bx-home-circle',
        subItems: [{
                id: 2,
                label: "menuitems.dashboards.list.default",
                link: "/home",
                parentId: 2
            },
            {
                id: 3,
                label: "مدیریت کاربران",
                link: "/dashboard/usermangement",
                parentId: 2
            },
            {

                id: 4,
                label: "مشتریان",
                icon: "bx-customer",
                link: "/dashboard/customer",

            },
            {
                id: 5,
                label: "فایننس اکانتها",
                icon: "bx-file",
                link: "/dashboard/finance_account"
            },
            {
                id: 6,
                label: "واحد پولی",
                link: "/dashboard/currency",
                parentId: 2
            },
        ]
    },
    {
        id: 7,
        label: "سفارشات",
        icon: "bx-dollar",
        subItems: [{
                id: 6,
                label: " تمام سفارشات",
                link: "/dashboard/order",
                parentId: 2

            },

            {
                id: 8,
                label: "سفارشات تائید شده",
                icon: "bx-file",
                link: "/dashboard/acceptorder",

            },
            {
                id: 9,
                label: "سفارشات در حالت تائید",
                icon: "bx-file",
                link: "/dashboard/pendingorder"
            },
            {
                id: 10,
                label: "سفارشات رد شده",
                icon: "bx-file",
                link: "/dashboard/rejectorder"
            },
        ]
    },

    {
        id: 11,
        label: "رسید و بردها",
        icon: "bx-dollar",
        subItems: [{
                id: 8,
                label: "ثبت مصرف جدید",
                icon: "bx-file",
                link: "/dashboard/expense",

            },
            {
                id: 12,
                label: "رسید برد",
                icon: "bx-file",
                link: "/dashboard/rasidbord"
            },
        ]
    },
    {
        id: 13,
        icon: 'bxs-report',
        label: "گزارشات",
        subItems: [{
                id: 1,
                label: "گزارش بانک ها",
                link: "/report/financereport",
                parentId: 2
            },
            {
                id: 2,
                label: "قرض ها و رسیدها",
                link: "/report/borrowpaid",
                parentId: 2,

            },
            {
                id: 3,
                label: "روزنامچه",
                link: "/report/rooznachah",
                parentId: 2,

            },
        ]
    },
    {
        id: 14,
        label: "تبادله",
        icon: "bx-dollar",
        subItems: [{
                id: 1,
                label: "خرید",
                link: "/exchange/buy",
                parentId: 2
            },
            {
                id: 2,
                label: "فروش",
                link: "/exchange/sale",
                parentId: 2,

            },
            {
                id: 3,
                label: "انتقال",
                link: "/exchange/transfer",
                parentId: 2,

            },





        ]
    },

];