<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import {
    revenueChart
} from "../../contacts/data-profile";

import profile from '../../../../images/profile-img.png';
import avatar1 from '../../../../images/users/avatar-1.jpg';
import axios from "axios";
import Swal from 'sweetalert2'

import {
    ref
} from 'vue';
/**
 * customer-Profile component
 */
export default {
    components: {
        Layout,
        PageHeader
    },
    data() {
        return {
            profile,
            avatar1,
            revenueChart: revenueChart,
            title: "پروفایل مشتری",
            items: [{
                    text: "مشتری",
                    href: "/"
                },
                {
                    text: "پروفایل",
                    active: true
                }
            ],
            showModal: false,
            showEditUserModal: false,
            showEditPasswordModal: false,
            searchQuery: '',
            customer: [],
            transactionslist: [],
            orderslist: [],
            customerAmount: 0,
            rasid: 0,
            bord: 0,
            totalAmount: 0,
            // edit modal
            editname: '',
            editLastName: '',
            editUsername: '',
            editPassword: '',
            editPhone: '',
            editImage: null,
            editAddress: '',
            editDesc: '',
            errors: {},

        };
    },

    mounted() {
        this.getTransactionbycid();

    },
    async created() {
        try {
            const response = await axios.get(`/api/customer/${this.$route.params.id}`);
            this.customer = response.data;
        } catch (error) {
            console.error(error.message);
        }
    },
    methods: {

        openEditModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        openEditUsernameModal() {
            this.showEditUserModal = true;
            // console.log("object");
        },

        openEditPasswordModal() {
            this.showEditPasswordModal = true;
           
        },

        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },

        async getTransactionbycid() {

            try {
                const response = await axios.get(`/api/customerinfo/${this.$route.params.id}`);
                this.transactionslist = response.data.transactions;
                this.orderslist = response.data.orders;
                this.rasid = response.data.rasid;
                this.bord = response.data.bord;
                this.totalAmount = response.data.total_amount;
            } catch (error) {
                console.log(error.message);
            }

        },

        async editCustomer(id) {
            try {
                const response = await axios.get(`/api/customer/${id}`);
                this.editCust = response.data;
                this.openEditModal(this.editCust);
                //    console.log("editCustomer",this.editCust);
                this.editname = this.editCust.name;
                this.editLastName = this.editCust.last_name;
                this.editPhone = this.editCust.phone;
                // this.editUsername = this.editCust.username;
                // this.editPassword = this.editCust.password;
                this.ediPhoto = this.editCust.image;
                this.editAddress = this.editCust.address;
                this.editDesc = this.editCust.desc;
            } catch (error) {
                console.log(error.message);
            }

            //    console.log("inside editcustomer ", this.editDesc);
        },
        async editCustomerSubmitForm(id) {
            try {
                const responseUpdate = await axios.put(`/api/customer/${id}`, {
                    name: this.editname,
                    last_name: this.editLastName,
                    phone: this.editPhone,
                    // username: this.editUsername,
                    // password: this.editPassword,
                    image: this.ediPhoto,
                    address: this.editAddress,
                    desc: this.editDesc,
                });
                console.log(this.responseUpdate);
                if (responseUpdate.data != null) {
                    if (responseUpdate.data.status === false) {
                        if (responseUpdate.data.message != null) {
                            this.showalert(responseUpdate.data.message, "error", "error");
                        } else {
                            this.errors = responseUpdate.data.error;

                        }
                    } else {
                        this.errors = {};
                        this.name = null;
                        this.last_name = null;
                        this.phone = null;
                        this.username = null;
                        this.password = null;
                        this.image = null;
                        this.address = null;
                        this.desc = null;
                        this.showModal = false;
                        // console.log(response.code);
                        this.showalert("مشتری با موفقیت ویرایش شد!", 'success', 'success');
                    }
                    // console.log("Customer updated successfully");   
                } else {
                    this.errors = {};
                    this.closeModal();
                    this.showalert(responseUpdate.data.message, "success", "success");
                }

                this.showModal = false;
                // this.getCustomer();

            } catch (error) {
                console.log(error.message);
            }
        },
        async changeUsernameFunc() {
            try {
                const response = await axios.post(`/api/changeusername/${this.$route.params.id}`, {
                    username: this.editUsername
                });
                // console.log(this.responseUpdate);
                if (response.data != null) {
                    if (response.data.status === false) {
                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error");
                        } else {
                            this.errors = response.data.error;

                        }
                    } else {
                        this.errors = {};
                        this.username = null;
                        this.showEditUserModal=false;
                        this.showalert("نام کاربری با موفقیت ویرایش شد!", 'success', 'success');
                    }

                } else {
                    this.errors = {};
                    this.showModal = false;
                    this.showalert(responseUpdate.data.message, "success", "success");
                }

            } catch (error) {
                console.log(error.message);
            }

        },

        async changePasswordfunc() {

          try {
                const response = await axios.post(`/api/changepassword/${this.$route.params.id}`, {
                    password: this.editPassword
                });
                console.log(response);
                if (response.data != null) {
                  console.log("response.data != null");
                    if (response.data.status === false) {
                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error");
                        } else {
                            this.errors = response.data.error;

                        }
                    } else {
                        this.errors = {};
                        this.username = null;
                        this.showEditPasswordModal=false;
                        this.showalert("رمز عبور با موفقیت ویرایش شد!", 'success', 'success');
                    }

                } else {
                    this.errors = {};
                    this.showModal = false;
                    this.showalert(responseUpdate.data.message, "success", "success");
                }

            } catch (error) {
                console.log(error.message);
            }



            try {
              const response = await axios.post(`/api/changepassword/${this.$route.params.id}`, {
                    password: this.this.editPassword
                });

            } catch (error) {
              
            }
        },
        async searchData() {
            const response = await axios.post(`/api/searchtransaction/${this.$route.params.id}`, {
                query: this.searchQuery
            });
            this.transactionslist = response.data;
        },
    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-soft bg-primary">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">سلام خوش آمدید !</h5>
                                <p>ساده به نظر می رسد</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img :src="profile" alt class="img-fluid" />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img :src="avatar1" alt class="img-thumbnail rounded-circle" />
                            </div>
                            <h5 class="font-size-15 text-truncate font-size-20">{{customer.name}}</h5>
                            <p class="text-muted mb-0 text-truncate font-size-20" v-if="customer.type !=null">مشتری</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">125</h5>
                                        <p class="text-muted mb-0">Projects</p>
                                    </div>
                                    <div class="col-6">

                                        <h5 class="font-size-15">${{customerAmount}}</h5>
                                        <p class="text-muted mb-0">Revenue</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="contact-links d-flex font-size-18 gap-0.5">
                            <div class="flex-fill">
                                <b-button type="button" variant="primary" class="btn btn-primary btn-sm btn-rounded" @click="editCustomer(this.$route.params.id)">ویرایش پروفایل</b-button>
                            </div>
                            <div class="flex-fill">
                                <b-button type="button" variant="primary" class="btn btn-primary btn-sm btn-rounded text-bold" @click="openEditUsernameModal">تغیر نام کاربری</b-button>
                            </div>
                            <div class="flex-fill">
                                <b-button type="button" variant="primary" class="btn btn-primary btn-sm btn-rounded text-bold" @click="openEditPasswordModal">تغیر رمز عبور</b-button>
                            </div>
                            <div class="flex-fill">
                                <b-button type="button" variant="primary" class="btn btn-primary btn-sm btn-rounded text-bold" @click="openEditPasswordModal">غیر فعال کردن</b-button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">بلانس</h4>
                    <div class="table-responsive mb-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">رسید:</th>
                                    <td>{{rasid}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">برد :</th>
                                    <td>{{bord}}</td>
                                </tr>

                                <tr>
                                    <th scope="row">جمع کل :</th>
                                    <td>{{totalAmount}}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">اطلاعات شخصی</h4>

                    <p class="text-muted mb-4" v-if="customer!=null">{{customer.desc}}</p>
                    <p class="text-muted mb-4" v-else>توصیحاتی وجود ندارد</p>
                    <div class="table-responsive mb-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">نام کامل :</th>
                                    <td>{{customer.name}} {{customer.last_name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">شماره تماس :</th>
                                    <td>{{customer.phone}}</td>
                                </tr>

                                <tr>
                                    <th scope="row">آدرس :</th>
                                    <td v-if="customer.address > 0">{{customer.address}}</td>
                                    <td v-else>آدرس وجود ندارد</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

        </div>

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-body">

                    <div class="table-responsive mb-0">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="col-sm-4">
                                    <div class="search-box me-2 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <b-tabs content-class="p-4" class="pt-2" nav-wrapper-class="nav-item" nav-class="justify-content-center nav-tabs-custom">
                                    <b-tab title="ترانزکشن" active>
                                        <div>
                                            <div class="row justify-content-center">
                                                <div class="col-xl-12">
                                                    <div v-if="transactionslist.length > 0">
                                                        <hr class="mb-4" />
                                                        <div class="table-responsive">
                                                            <table class="table table-centered table-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th class="text-center">آیدی</th>
                                                                        <th class="text-center">نام مشتری</th>
                                                                        <th class="text-center">رسید برد</th>
                                                                        <th class="text-center">نمبر چک</th>
                                                                        <th class="text-center">مقدار پول</th>
                                                                        <th class="text-center">واحد</th>
                                                                        <th class="text-center">دخل</th>
                                                                        <th class="text-center">تفصیلات</th>
                                                                        <th class="text-center">توسط</th>
                                                                        <th class="text-center">عملیه</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="transaction in transactionslist" :key="transaction?.id">
                                                                        <td>
                                                                            <div class="form-check font-size-16">
                                                                                <input :id="`customCheck${transaction.id}`" type="checkbox" class="form-check-input" />
                                                                                <label class="form-check-label" :for="`customCheck${transaction.id}`">&nbsp;</label>
                                                                            </div>
                                                                        </td>

                                                                        <td>{{transaction.id}}</td>
                                                                        <td v-if="transaction.customer!=null">{{ transaction.customer.name}}</td>
                                                                        <td v-else>{{ transaction.finance_account.account_name}}</td>
                                                                        <td>{{transaction.rasid_bord}}</td>
                                                                        <td>{{transaction.check_number}}</td>
                                                                        <td>{{transaction.amount}}</td>
                                                                        <td>{{transaction.tr_currency.name}}</td>
                                                                        <td v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</td>

                                                                        <td v-else>{{ transaction.finance_account.account_name}}</td>

                                                                        <td>{{transaction.desc}}</td>
                                                                        <td>{{transaction.user_id}}</td>

                                                                        <td>
                                                                            <b-dropdown class="card-drop" variant="white" right toggle-class="p-0" menu-class="dropdown-menu-end">
                                                                                <template v-slot:button-content>
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </template>

                                                                                <b-dropdown-item>
                                                                                    <i class="fas fa-pencil-alt text-success me-1" @click="editTransactionFunc(transaction.id)"></i> Edit
                                                                                </b-dropdown-item>

                                                                                <b-dropdown-item>
                                                                                    <i class="fas fa-trash-alt text-danger me-1" @click="deleteTransaction(transaction.id)"></i> Delete
                                                                                </b-dropdown-item>
                                                                            </b-dropdown>
                                                                        </td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                        </div>

                                                        <div class="text-center">
                                                            <ul class="pagination justify-content-center pagination-rounded">
                                                                <li class="page-item disabled">
                                                                    <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a href="#" class="page-link">1</a>
                                                                </li>
                                                                <li class="page-item active">
                                                                    <a href="#" class="page-link">2</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a href="#" class="page-link">3</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a href="#" class="page-link">...</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a href="#" class="page-link">10</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h3 class="text-center" v-else>این مشتری ترانزکشنی انجام نداده است</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="سفارشات">
                                        <div>
                                            <div class="row justify-content-center">
                                                <div class="col-xl-12">
                                                    <!-- <h5>Archive</h5> -->

                                                    <div class="mt-5" v-if="orderslist.length > 0">
                                                        <hr class="mt-2" />
                                                        <div class="table-responsive">
                                                            <table class="table table-centered table-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th class="text-center">آیدی</th>
                                                                        <th class="text-center">نام مشتری</th>
                                                                        <th class="text-center">رسید برد</th>
                                                                        <th class="text-center">نمبر چک</th>
                                                                        <th class="text-center">مقدار پول</th>
                                                                        <th class="text-center">واحد</th>
                                                                        <th class="text-center">دخل</th>
                                                                        <th class="text-center">تفصیلات</th>
                                                                        <th class="text-center">توسط</th>
                                                                        <th class="text-center">عملیه</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="transaction in orderslist" :key="transaction?.id">
                                                                        <td>
                                                                            <div class="form-check font-size-16">
                                                                                <input :id="`customCheck${transaction.id}`" type="checkbox" class="form-check-input" />
                                                                                <label class="form-check-label" :for="`customCheck${transaction.id}`">&nbsp;</label>
                                                                            </div>
                                                                        </td>

                                                                        <td>{{transaction.id}}</td>
                                                                        <td v-if="transaction.customer!=null">{{ transaction.customer.name}}</td>
                                                                        <td v-else>{{ transaction.finance_account.account_name}}</td>
                                                                        <td>{{transaction.rasid_bord}}</td>
                                                                        <td>{{transaction.check_number}}</td>
                                                                        <td>{{transaction.amount}}</td>
                                                                        <td>{{transaction.tr_currency.name}}</td>
                                                                        <td v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</td>

                                                                        <td v-else>{{ transaction.finance_account.account_name}}</td>

                                                                        <td>{{transaction.desc}}</td>
                                                                        <td>{{transaction.user_id}}</td>

                                                                        <td>
                                                                            <b-dropdown class="card-drop" variant="white" right toggle-class="p-0" menu-class="dropdown-menu-end">
                                                                                <template v-slot:button-content>
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </template>

                                                                                <b-dropdown-item>
                                                                                    <i class="fas fa-pencil-alt text-success me-1" @click="editTransactionFunc(transaction.id)"></i> Edit
                                                                                </b-dropdown-item>

                                                                                <b-dropdown-item>
                                                                                    <i class="fas fa-trash-alt text-danger me-1" @click="deleteTransaction(transaction.id)"></i> Delete
                                                                                </b-dropdown-item>
                                                                            </b-dropdown>
                                                                        </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <h3 class="text-center" v-else>ترانزکشنی از نوع سفارش وجود ندارد</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                </b-tabs>
                                <!-- Nav tabs -->
                            </div>
                        </div>

                        <!-- edit modal start -->
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <b-modal v-model="showModal" title="ویرایش مشتری" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
          }}</b-alert>
                                    <form @submit.prevent="editCustomerSubmitForm(editCust.id)" enctype="multipart/form-data">
                                        <div class="row flex justify-between">
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">

                                                    <div class="mb-3">
                                                        <label for="editname">نام</label>
                                                        <input id="editname" v-model="editname" type="text" class="form-control" placeholder="نام خود را وارد کنید" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editLastName">نام خانواگی</label>
                                                        <input id="editLastName" v-model="editLastName" type="text" class="form-control" placeholder="نام خانوادگی خود را وارکنید" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editImage">عکس</label>
                                                        <input type="file" ref="editImage" class="form-control" @change="editHandleFileChange" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editPhone">شماره تماس</label>
                                                        <input type="text" v-model="editPhone" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="editAddress">آدرس</label>
                                                    <textarea v-model="editAddress" id="editAddress" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label for="editDesc">توضیحات</label>
                                                    <textarea v-model="editDesc" id="editDesc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end pt-5 mt-1 g-2">
                                            <b-button variant="danger" @click="showModal = false">بستن</b-button>
                                            <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                                        </div>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <!-- edit modal end -->

                        <!-- edit username modal start -->
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <b-modal v-model="showEditUserModal" title="ویرایش نام کاربری" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                }}</b-alert>
                                    <form @submit.prevent="changeUsernameFunc">
                                        <div class="row flex justify-between">

                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editUsername">نام کاربری</label>
                                                        <input id="editUsername" v-model="editUsername" type="text" class="form-control" placeholder="نام کاربری خود را وارد کنید" required/>
                                                        <span class="text-danger error-text afrad_error" v-if="errors.username">{{errors.username[0]}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end pt-5 mt-1 g-2">
                                            <b-button variant="danger" @click="showEditUserModal = false">بستن</b-button>
                                            <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                                        </div>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <!-- edit modal end -->

                        <!-- edit password modal start -->
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <b-modal v-model="showEditPasswordModal" title="ویرایش رمز" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                      }}</b-alert>
                                    <form @submit.prevent="changePasswordfunc" enctype="multipart/form-data">
                                        <div class="row flex justify-between">

                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editPassword">رمز عبور</label>
                                                        <input id="editPassword" v-model="editPassword" type="password" class="form-control" placeholder="رمز خود را وارد کنید" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end pt-5 mt-1 g-2">
                                            <b-button variant="danger" @click="showEditPasswordModal = false">بستن</b-button>
                                            <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                                        </div>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <!-- edit modal end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
