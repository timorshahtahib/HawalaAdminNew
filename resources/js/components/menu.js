export const menuItems = [{
        id: 1,
        label: "menuitems.menu.text",
        isTitle: true
    },
    {
        id: 2,
        label: "menuitems.dashboards.text",
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
        id: 6,
        isLayout: true
    },

    {
        id: 19,
        label: "menuitems.crypto.text",
        icon: "bx-bitcoin",
        subItems: [{
                id: 6,
                label: "سفارش",
                link: "/dashboard/order",
                parentId: 2
            },
            {
                id: 7,
                label: "خرج ومخارج",
                link: "/dashboard/income_expense",
                parentId: 2,

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
        icon: 'menuitems.report.text',
        label: "گزارشات",
        icon: "bx-dollar",
        subItems: [{
                id: 6,
                label: "گزارش بانک ها",
                link: "/report/financereport",
                parentId: 2
            },
            {
                id: 7,
                label: "گزارشات 2",
                link: "/dashboard/income_expense",
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

    // {
    //     id: 27,
    //     label: "menuitems.email.text",
    //     icon: "bx-envelope",
    //     subItems: [{
    //             id: 28,
    //             label: "menuitems.email.list.inbox",
    //             link: "/email/inbox",
    //             parentId: 27
    //         },
    //         {
    //             id: 29,
    //             label: "menuitems.email.list.reademail",
    //             link: "/email/reademail/1",
    //             parentId: 27
    //         },
    //         {
    //             id: 32,
    //             label: "menuitems.email.list.template.text",
    //             parentId: 29,
    //             subItems: [{
    //                     id: 33,
    //                     label: 'menuitems.email.list.template.list.basic',
    //                     link: '/email/templates/basic',
    //                     parentId: 32
    //                 },
    //                 {
    //                     label: 'menuitems.email.list.template.list.alert',
    //                     link: '/email/templates/alert',
    //                     parentId: 32
    //                 },
    //                 {
    //                     label: 'menuitems.email.list.template.list.billing',
    //                     link: '/email/templates/billing',
    //                     parentId: 32
    //                 }
    //             ]
    //         }
    //     ]
    // },
    // {
    //     id: 30,
    //     label: "menuitems.invoices.text",
    //     icon: "bx-receipt",
    //     subItems: [{
    //             id: 31,
    //             label: "menuitems.invoices.list.invoicelist",
    //             link: "/invoices/list",
    //             parentId: 30
    //         },
    //         {
    //             id: 32,
    //             label: "menuitems.invoices.list.invoicedetail",
    //             link: "/invoices/detail",
    //             parentId: 30
    //         }
    //     ]
    // },
    // {
    //     id: 33,
    //     label: "menuitems.projects.text",
    //     icon: "bx-briefcase-alt-2",
    //     subItems: [{
    //             id: 34,
    //             label: "menuitems.projects.list.grid",
    //             link: "/projects/grid",
    //             parentId: 33
    //         },
    //         {
    //             id: 35,
    //             label: "menuitems.projects.list.projectlist",
    //             link: "/projects/list",
    //             parentId: 33
    //         },
    //         {
    //             id: 36,
    //             label: "menuitems.projects.list.overview",
    //             link: "/projects/overview",
    //             parentId: 33
    //         },
    //         {
    //             id: 37,
    //             label: "menuitems.projects.list.create",
    //             link: "/projects/create",
    //             parentId: 33
    //         }
    //     ]
    // },
    // {
    //     id: 38,
    //     label: "menuitems.tasks.text",
    //     icon: "bx-task",
    //     subItems: [{
    //             id: 39,
    //             label: "menuitems.tasks.list.tasklist",
    //             link: "/tasks/list",
    //             parentId: 38
    //         },
    //         {
    //             id: 40,
    //             label: "menuitems.tasks.list.kanban",
    //             link: "/tasks/kanban",
    //             parentId: 38
    //         },
    //         {
    //             id: 41,
    //             label: "menuitems.tasks.list.createtask",
    //             link: "/tasks/create",
    //             parentId: 38
    //         }
    //     ]
    // },
    // {
    //     id: 42,
    //     label: "menuitems.contacts.text",
    //     icon: "bxs-user-detail",
    //     subItems: [{
    //             id: 43,
    //             label: "menuitems.contacts.list.usergrid",
    //             link: "/contacts/grid",
    //             parentId: 42
    //         },
    //         {
    //             id: 44,
    //             label: "menuitems.contacts.list.userlist",
    //             link: "/contacts/list",
    //             parentId: 42
    //         },
    //         {
    //             id: 45,
    //             label: "menuitems.contacts.list.profile",
    //             link: "/contacts/profile",
    //             parentId: 42
    //         }
    //     ]
    // },
    // {
    //     id: 50,
    //     label: "menuitems.blog.text",
    //     icon: "bx-detail",
    //     subItems: [{
    //             id: 51,
    //             label: 'menuitems.blog.list.bloglist',
    //             link: '/blog/list',
    //             parentId: 50
    //         },
    //         {
    //             id: 52,
    //             label: 'menuitems.blog.list.grid',
    //             link: '/blog/grid',
    //             parentId: 50
    //         },
    //         {
    //             id: 53,
    //             label: 'menuitems.blog.list.detail',
    //             link: '/blog/detail',
    //             parentId: 50
    //         }
    //     ]
    // },
    // {
    //     id: 111,
    //     label: "menuitems.jobs.text",
    //     icon: "bx-briefcase-alt",
    //     badge: {
    //         variant: "success",
    //         text: "menuitems.jobs.badge"
    //     },
    //     subItems: [{
    //             id: 112,
    //             label: 'menuitems.jobs.list.job-list',
    //             link: '/jobs/list',
    //             parentId: 111
    //         },
    //         {
    //             id: 113,
    //             label: 'menuitems.jobs.list.job-grid',
    //             link: '/jobs/grid',
    //             parentId: 111
    //         },
    //         {
    //             id: 114,
    //             label: 'menuitems.jobs.list.job-apply',
    //             link: '/jobs/apply',
    //             parentId: 111
    //         },
    //         {
    //             id: 115,
    //             label: 'menuitems.jobs.list.job-details',
    //             link: '/jobs/details',
    //             parentId: 111
    //         },
    //         {
    //             id: 115,
    //             label: 'menuitems.jobs.list.job-categories',
    //             link: '/jobs/categories',
    //             parentId: 111,
    //         },
    //         {
    //             id: 116,
    //             label: 'menuitems.jobs.list.candidate.text',
    //             parentId: 111,
    //             subItems: [{
    //                     id: 117,
    //                     label: 'menuitems.jobs.list.candidate.list',
    //                     link: '/jobs/candidate/list',
    //                     parentId: 116
    //                 },
    //                 {
    //                     id: 118,
    //                     label: 'menuitems.jobs.list.candidate.overview',
    //                     link: '/jobs/candidate/overview',
    //                     parentId: 116
    //                 },
    //             ]
    //         },
    //     ]
    // },
    // {
    //     id: 46,
    //     label: "menuitems.pages.text",
    //     isTitle: true
    // },
    // {
    //     id: 47,
    //     label: "menuitems.authentication.text",
    //     icon: "bx-user-circle",
    //     subItems: [{
    //             id: 56,
    //             label: "menuitems.authentication.list.login",
    //             link: "/auth/login-1",
    //             parentId: 55
    //         },
    //         {
    //             id: 57,
    //             label: "menuitems.authentication.list.login-2",
    //             link: "/auth/login-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 58,
    //             label: "menuitems.authentication.list.register",
    //             link: "/auth/register-1",
    //             parentId: 55
    //         },
    //         {
    //             id: 59,
    //             label: "menuitems.authentication.list.register-2",
    //             link: "/auth/register-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 60,
    //             label: "menuitems.authentication.list.recoverpwd",
    //             link: "/auth/recoverpw",
    //             parentId: 55
    //         },
    //         {
    //             id: 61,
    //             label: "menuitems.authentication.list.recoverpwd-2",
    //             link: "/auth/recoverpwd-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 62,
    //             label: "menuitems.authentication.list.lockscreen",
    //             link: "/auth/lock-screen",
    //             parentId: 55
    //         },
    //         {
    //             id: 63,
    //             label: "menuitems.authentication.list.lockscreen-2",
    //             link: "/auth/lock-screen-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 64,
    //             label: "menuitems.authentication.list.confirm-mail",
    //             link: "/auth/confirm-mail",
    //             parentId: 55
    //         },
    //         {
    //             id: 65,
    //             label: "menuitems.authentication.list.confirm-mail-2",
    //             link: "/auth/confirm-mail-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 66,
    //             label: "menuitems.authentication.list.verification",
    //             link: "/auth/email-verification",
    //             parentId: 55
    //         },
    //         {
    //             id: 67,
    //             label: "menuitems.authentication.list.verification-2",
    //             link: "/auth/email-verification-2",
    //             parentId: 55
    //         },
    //         {
    //             id: 68,
    //             label: "menuitems.authentication.list.verification-step",
    //             link: "/auth/two-step-verification",
    //             parentId: 55
    //         },
    //         {
    //             id: 69,
    //             label: "menuitems.authentication.list.verification-step-2",
    //             link: "/auth/two-step-verification-2",
    //             parentId: 55
    //         }
    //     ]
    // },
    // {
    //     id: 52,
    //     label: "menuitems.utility.text",
    //     icon: "bx-file",
    //     subItems: [{
    //             id: 53,
    //             label: "menuitems.utility.list.starter",
    //             link: "/pages/starter",
    //             parentId: 52
    //         },
    //         {
    //             id: 54,
    //             label: "menuitems.utility.list.maintenance",
    //             link: "/pages/maintenance",
    //             parentId: 52
    //         },
    //         {
    //             id: 54,
    //             label: "menuitems.utility.list.comingsoon",
    //             link: "/pages/coming-soon",
    //             parentId: 52
    //         },
    //         {
    //             id: 55,
    //             label: "menuitems.utility.list.timeline",
    //             link: "/pages/timeline",
    //             parentId: 52
    //         },
    //         {
    //             id: 56,
    //             label: "menuitems.utility.list.faqs",
    //             link: "/pages/faqs",
    //             parentId: 52
    //         },
    //         {
    //             id: 57,
    //             label: "menuitems.utility.list.pricing",
    //             link: "/pages/pricing",
    //             parentId: 52
    //         },
    //         {
    //             id: 58,
    //             label: "menuitems.utility.list.error404",
    //             link: "/pages/404",
    //             parentId: 52
    //         },
    //         {
    //             id: 59,
    //             label: "menuitems.utility.list.error500",
    //             link: "/pages/500",
    //             parentId: 52
    //         }
    //     ]
    // },
    // {
    //     id: 60,
    //     label: "menuitems.components.text",
    //     isTitle: true
    // },
    // {
    //     id: 61,
    //     label: "menuitems.uielements.text",
    //     icon: "bx-tone",
    //     subItems: [{
    //             id: 62,
    //             label: "menuitems.uielements.list.alerts",
    //             link: "/ui/alerts",
    //             parentId: 61
    //         },
    //         {
    //             id: 63,
    //             label: "menuitems.uielements.list.buttons",
    //             link: "/ui/buttons",
    //             parentId: 61
    //         },
    //         {
    //             id: 64,
    //             label: "menuitems.uielements.list.cards",
    //             link: "/ui/cards",
    //             parentId: 61
    //         },
    //         {
    //             id: 65,
    //             label: "menuitems.uielements.list.carousel",
    //             link: "/ui/carousel",
    //             parentId: 61
    //         },
    //         {
    //             id: 66,
    //             label: "menuitems.uielements.list.dropdowns",
    //             link: "/ui/dropdowns",
    //             parentId: 61
    //         },
    //         {
    //             id: 67,
    //             label: "menuitems.uielements.list.grid",
    //             link: "/ui/grid",
    //             parentId: 61
    //         },
    //         {
    //             id: 68,
    //             label: "menuitems.uielements.list.images",
    //             link: "/ui/images",
    //             parentId: 61
    //         },
    //         {
    //             id: 69,
    //             label: "menuitems.uielements.list.modals",
    //             link: "/ui/modals",
    //             parentId: 61
    //         },
    //         {
    //             id: 69,
    //             label: "menuitems.uielements.list.offcanvas",
    //             link: "/ui/offcanvas",
    //             parentId: 61
    //         },
    //         {
    //             id: 70,
    //             label: "menuitems.uielements.list.rangeslider",
    //             link: "/ui/rangeslider",
    //             parentId: 61
    //         },
    //         {
    //             id: 71,
    //             label: "menuitems.uielements.list.progressbar",
    //             link: "/ui/progressbars",
    //             parentId: 61
    //         },
    //         {
    //             id: 71,
    //             label: "menuitems.uielements.list.placeholder",
    //             link: "/ui/placeholder",
    //             parentId: 61
    //         },
    //         {
    //             id: 72,
    //             label: "menuitems.uielements.list.sweetalert",
    //             link: "/ui/sweet-alert",
    //             parentId: 61
    //         },
    //         {
    //             id: 73,
    //             label: "menuitems.uielements.list.tabs",
    //             link: "/ui/tabs-accordions",
    //             parentId: 61
    //         },
    //         {
    //             id: 74,
    //             label: "menuitems.uielements.list.typography",
    //             link: "/ui/typography",
    //             parentId: 61
    //         },
    //         {
    //             id: 75,
    //             label: "menuitems.uielements.list.video",
    //             link: "/ui/video",
    //             parentId: 61
    //         },
    //         {
    //             id: 76,
    //             label: "menuitems.uielements.list.general",
    //             link: "/ui/general",
    //             parentId: 61
    //         },
    //         {
    //             id: 77,
    //             label: "menuitems.uielements.list.colors",
    //             link: "/ui/colors",
    //             parentId: 61
    //         },
    //         {
    //             id: 78,
    //             label: "menuitems.uielements.list.lightbox",
    //             link: "/ui/lightbox",
    //             parentId: 61
    //         },
    //         {
    //             id: 79,
    //             label: "menuitems.uielements.list.cropper",
    //             link: "/ui/image-cropper",
    //             parentId: 61
    //         },
    //         {
    //             id: 80,
    //             label: "menuitems.uielements.list.utilities.text",
    //             link: "/ui/utilities",
    //             parentId: 61,
    //             badge: {
    //                 variant: "success",
    //                 text: "menuitems.uielements.list.utilities.badge"
    //             },
    //         }
    //     ]
    // },
    // {
    //     id: 79,
    //     label: "menuitems.forms.text",
    //     icon: "bxs-eraser",
    //     badge: {
    //         variant: "danger",
    //         text: "menuitems.forms.badge"
    //     },
    //     subItems: [{
    //             id: 80,
    //             label: "menuitems.forms.list.elements",
    //             link: "/form/elements",
    //             parentId: 79
    //         },
    //         {
    //             id: 81,
    //             label: "menuitems.forms.list.layouts",
    //             link: "/form/layouts",
    //             parentId: 79
    //         },
    //         {
    //             id: 82,
    //             label: "menuitems.forms.list.advanced",
    //             link: "/form/advanced",
    //             parentId: 79
    //         },
    //         {
    //             id: 83,
    //             label: "menuitems.forms.list.editor",
    //             link: "/form/editor",
    //             parentId: 79
    //         },
    //         {
    //             id: 84,
    //             label: "menuitems.forms.list.fileupload",
    //             link: "/form/uploads",
    //             parentId: 79
    //         },
    //         {
    //             id: 85,
    //             label: "menuitems.forms.list.repeater",
    //             link: "/form/repeater",
    //             parentId: 79
    //         },
    //         {
    //             id: 86,
    //             label: "menuitems.forms.list.wizard",
    //             link: "/form/wizard",
    //             parentId: 79
    //         },
    //         {
    //             id: 87,
    //             label: "menuitems.forms.list.mask",
    //             link: "/form/mask",
    //             parentId: 79
    //         }
    //     ]
    // },
    // {
    //     id: 88,
    //     icon: "bx-list-ul",
    //     label: "menuitems.tables.text",
    //     subItems: [{
    //         id: 89,
    //         label: "menuitems.tables.list.basic",
    //         link: "/tables/basic",
    //         parentId: 88
    //     }, ]
    // },
    // {
    //     id: 91,
    //     icon: "bxs-bar-chart-alt-2",
    //     label: "menuitems.charts.text",
    //     subItems: [{
    //             id: 92,
    //             label: "menuitems.charts.list.apex",
    //             link: "/charts/apex",
    //             parentId: 91
    //         },
    //         {
    //             id: 93,
    //             label: "menuitems.charts.list.chartjs",
    //             link: "/charts/chartjs",
    //             parentId: 91
    //         },
    //     ]
    // },
    // {
    //     id: 96,
    //     label: "menuitems.icons.text",
    //     icon: "bx-aperture",
    //     subItems: [{
    //             id: 97,
    //             label: "menuitems.icons.list.boxicons",
    //             link: "/icons/boxicons",
    //             parentId: 96
    //         },
    //         {
    //             id: 98,
    //             label: "menuitems.icons.list.materialdesign",
    //             link: "/icons/materialdesign",
    //             parentId: 96
    //         },
    //         {
    //             id: 99,
    //             label: "menuitems.icons.list.dripicons",
    //             link: "/icons/dripicons",
    //             parentId: 96
    //         },
    //         {
    //             id: 100,
    //             label: "menuitems.icons.list.fontawesome",
    //             link: "/icons/fontawesome",
    //             parentId: 96
    //         }
    //     ]
    // },
    // {
    //     id: 101,
    //     label: "menuitems.maps.text",
    //     icon: "bx-map",
    //     subItems: [{
    //             id: 102,
    //             label: "menuitems.maps.list.googlemap",
    //             link: "/maps/google",
    //             parentId: 101
    //         },
    //         {
    //             id: 103,
    //             label: "menuitems.maps.list.leafletmap",
    //             link: "/maps/leaflet",
    //             parentId: 101
    //         }
    //     ]
    // },
    // {
    //     id: 104,
    //     label: "menuitems.multilevel.text",
    //     icon: "bx-share-alt",
    //     subItems: [{
    //             id: 105,
    //             label: "menuitems.multilevel.list.level1.1",
    //             link: "#",
    //             parentId: 104
    //         },
    //         {
    //             id: 106,
    //             label: "menuitems.multilevel.list.level1.2",
    //             parentId: 104,
    //             subItems: [{
    //                     id: 107,
    //                     label: "menuitems.multilevel.list.level1.level2.1",
    //                     link: "#",
    //                     parentId: 106
    //                 },
    //                 {
    //                     id: 108,
    //                     label: "menuitems.multilevel.list.level1.level2.2",
    //                     link: "#",
    //                     parentId: 106
    //                 }
    //             ]
    //         }
    //     ]
    // }
];