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
                id: 3,
                label: "menuitems.dashboards.list.default",
                link: "/",
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
        subItems: [{
                id: 6,
                label: "سفارش",
                link: "/dashboard/order",
                parentId: 2
            },

            {
                id: 8,
                label: "ثبت مصرف جدید",
                icon: "bx-file",
                link: "/dashboard/expense",
                // badge: {
                //     variant: "success",
                //     text: "menuitems.dashboards.list.jobs.badge"
                // },
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