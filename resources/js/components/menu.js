export const menuItems = [{
        id: 1,
        label: "menuitems.menu.text",
        isTitle: true
    },
    {
        id: 2,
        label: "خانه",
        icon: "bx-home-circle",
        subItems: [{
                id: 2,
                label: "صفحه اصلی",
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
                icon: "bx-file",
                link: "/dashboard/customer",

            },
            {
                id: 5,
                label: "فایننس اکانت",
                icon: "bx-file",
                link: "/dashboard/finance_account"
            },
            {
                id: 7,
                label: "واحد پولی",
                link: "/dashboard/currency",
                parentId: 2
            },



        ]
    },

    {
        id: 19,
        label: "رسید و بردها",
        icon: "bx-dollar",
        subItems: [

            {
                id: 8,
                label: "ثبت مصرف جدید",
                icon: "bx-file",
                link: "/dashboard/expense",
            },
            {
                id: 9,
                label: "رسید برد",
                icon: "bx-file",
                link: "/dashboard/rasidbord"
            },
        ]
    },
    {
        id: 19,
        label: "سفارشات",
        icon: "bx-dollar",
        subItems: [{
                id: 10,
                label: "همه سفارشات",
                link: "/dashboard/order",
                parentId: 2
            },

            {
                id: 11,
                label: "سفارشات های تائید شده",
                icon: "bx-file",
                link: "/dashboard/acceptorder",

            },
            {
                id: 12,
                label: "سفارشات در حال تائید",
                icon: "bx-file",
                link: "/dashboard/pendingorder"
            },
            {
                id: 13,
                label: "سفارشات رد شده",
                icon: "bx-file",
                link: "/dashboard/rejectorder"
            },
        ]
    },
    {
        id: 19,
        icon: 'bxs-report',
        label: "گزارشات",
        subItems: [{
                id: 6,
                label: "گزارش بانک ها",
                link: "/report/financereport",
                parentId: 2
            },
            {
                id: 7,
                label: "قرض ها و رسیدها",
                link: "/report/borrowpaid",
                parentId: 2,

            },
            {
                id: 8,
                label: "روزنامچه",
                link: "/report/rooznamchah",
                parentId: 2,

            },
        ]
    },
    {
        id: 19,
        label: "تبادله",
        icon: "bx-dollar",
        subItems: [{
                id: 6,
                label: "خرید",
                link: "/exchange/buy",
                parentId: 2
            },
            {
                id: 7,
                label: "فروش",
                link: "/exchange/sale",
                parentId: 2,

            },
            {
                id: 8,
                label: "انتقال",
                link: "/exchange/transfer",
                parentId: 2,

            },





        ]
    },


];