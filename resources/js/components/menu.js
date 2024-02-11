// export const menuItems = [{
//         id: 1,
//         label: "menuitems.menu.text",
//         isTitle: true
//     },
//     {
//         id: 2,
//         label: "home",
//         icon: "bx-home-circle",
//         subItems: [{
//                 id: 3,
//                 label: "menuitems.dashboards.list.default",
//                 link: "/",
//                 parentId: 2
//             },
//             {
//                 id: 4,
//                 label: "customer",
//                 icon: "bx-file",
//                 link: "/dashboard/customer",
//             },
//             {
//                 id: 5,
//                 label: "Finance Accounts",
//                 icon: "bx-file",
//                 link: "/dashboard/finance_account"
//             },
//             {
//                 id: 7,
//                 label: "Currency",
//                 link: "/dashboard/currency",
//                 parentId: 2
//             },
//         ]
//     },

//     {
//         id: 19,
//         label: "Credit & Debit",
//         icon: "bx-dollar",
//         subItems: [{
//                 id: 8,
//                 label: "New expense",
//                 icon: "bx-file",
//                 link: "/dashboard/expense",

//             },
//             {
//                 id: 9,
//                 label: "Receipt",
//                 icon: "bx-file",
//                 link: "/dashboard/rasidbord"
//             },
//         ]
//     },
//     {
//         id: 19,
//         label: "Orders",
//         icon: "bx-dollar",
//         subItems: [{
//                 id: 10,
//                 label: "All Orders",
//                 link: "/dashboard/order",
//                 parentId: 2
//             },
//             {
//                 id: 11,
//                 label: "Accepted orders",
//                 icon: "bx-file",
//                 link: "/dashboard/acceptorder",

//             },
//             {
//                 id: 12,
//                 label: "Pending ordersPending orders",
//                 icon: "bx-file",
//                 link: "/dashboard/pendingorder"
//             },
//             {
//                 id: 13,
//                 label: "Rejected orders",
//                 icon: "bx-file",
//                 link: "/dashboard/rejectorder"
//             },
//         ]
//     },
//     {
//         id: 19,
//         icon: 'bxs-report',
//         label: "Reports",
//         subItems: [{
//                 id: 6,
//                 label: "Banks Report",
//                 link: "/report/financereport",
//                 parentId: 2
//             },
//             {
//                 id: 7,
//                 label: "Loan & Credit",
//                 link: "/report/borrowpaid",
//                 parentId: 2,

//             },
//             {
//                 id: 8,
//                 label: "Rooz Namchah",
//                 link: "/report/rooznachah",
//                 parentId: 2,

//             },
//         ]
//     },
//     {
//         id: 19,
//         label: "Exchange",
//         icon: "bx-dollar",
//         subItems: [{
//                 id: 6,
//                 label: "Buy",
//                 link: "/exchange/buy",
//                 parentId: 2
//             },
//             {
//                 id: 7,
//                 label: "Sale",
//                 link: "/exchange/sale",
//                 parentId: 2,

//             },
//             {
//                 id: 8,
//                 label: "Transfer",
//                 link: "/exchange/transfer",
//                 parentId: 2,

//             },





//         ]
//     },


// ];


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
        subItems: [
            // {
            //     id: 6,
            //     label: "سفارش",
            //     link: "/dashboard/order",
            //     parentId: 2
            // },

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
                link: "/report/rooznachah",
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