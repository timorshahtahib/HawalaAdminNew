<script>
  import Layout from "../../../layouts/main.vue";
  import PageHeader from "../../../components/page-header.vue";
  import {
    revenueChart
  } from "../../contacts/data-profile";
  import profile from '../../../../images/profile-img.png';
  import avatar1 from '../../../../images/users/avatar-2.jpg';
  import Swal from 'sweetalert2'
  import DatePicker from '@alireza-ab/vue3-persian-datepicker';
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';
  import Loader from '../../loader/loader.vue'
  import api from '../../../services/api';




  /**
   * customer-Profile component
   */
  
  export default {
    components: {
      Layout,
      PageHeader,
      DatePicker,
      vSelect,
      Loader
    },
    data() {
      return {
        profile,
        avatar1,
        title: "پروفایل مشتری",
        items: [{
          text: "مشتری",
          href: "/"
        }, {
          text: "پروفایل",
          active: true
        }],
        isLoading: false,
        notFound: false,
        showModal: false,
        showEditUserModal: false,
        showEditPasswordModal: false,
        showModaltransaction: false,
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
        editbanks: [],
        edit_currencies: [],
        errors: {},
        currentPage: 1,
        totalPages: 1,
        limit: 10,
        // for getting customer balance
        customerbalances: [],
      };
    },
    mounted() {
      this.getTransactionbycid();
    },
    async created() {
      this.isLoading = true;
      try {
        const response = await api.get(`/customer/${this.$route.params.id}`);
        this.customer = response.data.customer;
        this.customerbalances = response.data.balances
        // console.log("cutomBalances",this.customerbalances);
      } catch (error) {
        console.error(error.message);
      } finally {
        this.isLoading = false;
      }
    },
    methods: {

      openEditModaltransaction() {
        this.showModaltransaction = true;
        this.getCurrency();
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
      openEditModal() {
        this.showModal = true;
      },
      showalert(title, text, icon) {
        Swal.fire({
          title: title,
          text: text,
          icon: icon,
          confirmButtonText: 'بستن'
        })
      },
      async getTransactionbycid(page = 1) {
        try {
          const response = await api.post(`/customerinfo`, {
            id: this.$route.params.id
          });
          this.transactionslist = response.data.transactions?.data;
          this.orderslist = response.data?.orders;
          this.rasid = response.data.rasid;
          this.bord = response.data.bord;
          this.totalAmount = response.data.total_amount;
          this.totalPages = response.data.customers?.last_page();
          this.currentPage = page;
          // console.log("Customers",this.transactionslist);
        } catch (error) {
          console.log(error.message);
        }
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.getTransactionbycid(this.currentPage - 1); // Update the page parameter
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.getTransactionbycid(this.currentPage + 1); // Update the page parameter
        }
      },
      async editCustomer(id) {
        try {
          const response = await api.get(`/customer/${id}`);
          this.editCust = response.data.customer;
          this.openEditModal(this.editCust);
          //    console.log("editCustomer",this.editCust);
          this.editname = this.editCust.name;
          this.editLastName = this.editCust.last_name;
          this.editPhone = this.editCust.phone;
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
          const responseUpdate = await api.post(`/updatecustomer`, {
            id: id,
            name: this.editname,
            phone: this.editPhone,
            image: this.ediPhoto,
            address: this.editAddress,
            desc: this.editDesc,
          });
          // console.log(this.responseUpdate);
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
          const response = await api.post(`/changeusername/${this.$route.params.id}`, {
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
              this.showEditUserModal = false;
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
          const response = await api.post(`/changepassword/${this.$route.params.id}`, {
            password: this.editPassword
          });
          // console.log(response);
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
              this.showEditPasswordModal = false;
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
          const response = await api.post(`/changepassword/${this.$route.params.id}`, {
            password: this.this.editPassword
          });
        } catch (error) {}
      },
      async searchData() {
        const response = await api.post('/searchtransactions', {
          query: this.searchQuery
        });
        this.transactions = response.data;
        this.notFound = this.transactions.length === 0
      },
      async editTransactionFunc(id) {
        const response = await api.get(`/transaction/${id}`);
        this.editTransaction = response.data;
        this.openEditModaltransaction();
        // console.log("this.editTransaction",this.editTransaction);
        this.edit_rasid_bord = this.editTransaction[0].rasid_bord
        this.editAmount = this.editTransaction[0].amount;
        this.editCurrency_rate = this.editTransaction[0].currency_rate;
        this.editEqual_amount = this.editTransaction[0].amount_equal;
        this.editDesc = this.editTransaction[0].desc;
        this.editDate = this.editTransaction[0].date;
        this.editCurrencyModel = this.editTransaction[0].tr_currency.id;
        this.editEqualcurrencyModel = this.editTransaction[0].eq_currency;
        this.getBanksForEdit(this.editCurrencyModel);
        // console.log("this.editEqualcurrencyModel",this.editEqualcurrencyModel);
      
        // this.getCustomerForEdit(this.editTransaction[0].ref_id);
        //  console.log("this.editTransaction", this.editTransaction);
      },
      async submitEditTransaction() {
        let id = this.editTransaction[0].id;
        const response = await api.post(`/updateTransaction`, {
          id: this.editTransaction[0].id,
          rasid_bord: this.editasid_bord,
          transaction_type: this.editasid_bord,
          ref_id: this.editSelectedCustomer.id,
          amount: this.editAmount,
          currency: this.editCurrencyModel,
          amount_equal: this.editEqual_amount,
          currency_equal: this.editEqualcurrencyModel,
          currency_rate: this.editCurrency_rate,
          bank_acount_id: this.editSelectedDakhl,
          date: this.editDate,
          desc: this.editDesc,
          user_id: 1,
        });
        if (response.data != null) {
          // console.log("in data!=null");
          if (response.data.status === false) {
            if (response.data.message != null) {
              this.showalert(response.data.message, "error", "error!");
            } else {
              this.errors = response.data.error;
            }
          } else {
            // console.log("else true");
            this.errors = {};
            this.transactions.push(response.data.new_data);
            this.showModal = false;
            this.showalert(response.data.message, "success", "success");
            // console.log(response.data);
          }
        }
        //  console.log("Successfully updated", this.editTransaction);
      },
      async deleteTransaction(id) {
        if (!window.confirm('آیا میخواهید که رسید برد حذف شود؟')) {
          return;
        } else {
          try {
            const response = await api.post(`/deleteonetransaction`, {
              id: id
            });
            if (response.status === 204) {
              // this.transactions.push(response.data.new_data)
              this.showalert(' با موفقیت حذف شد!', 'success', 'success');
              this.getTransactionbycid();
            }
          } catch (error) {
            this.showalert(' با موفقیت حذف نشد!', 'error', 'error');
          }
        }
      },
      async getCurrency() {
        try {
          await api.get('/currencies').then((response) => {
            this.edit_currencies = response.data.currencies.data;
            // console.log("this.edit_currencies", this.edit_currencies);
          }).catch((error) => {
            console.error('Error fetching currencies:', error);
          });
        } catch (error) {
          console.error('Error fetching data: ', error.message);
        }
      },
      editChange_currency() {
        this.getBanksForEdit(this.editCurrencyModel);
      },
      async getBanksForEdit(id) {
        try {
          const response = await api.get('/getbankbyid/' + id);
          this.editbanks = response.data.banks;
          // console.log("getNBanks", this.editbanks);
          this.editSelectedDakhl = this.editbanks[0].id;
          console.log("his.editSelectedDakhl",id);
         
        } catch (error) {
          console.log(error.message);
        }
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
                <div class="text-primary p-3"></div>
              </div>
              <div class="col-5 align-self-end">
                <img :src="profile" alt class="img-fluid" />
              </div>
            </div>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-md-12 col-sm-4">
                <div class="avatar-md profile-user-wid ">
                  <img :src="avatar1" alt class="img-thumbnail rounded-circle" />
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
                      <b-button type="button" variant="primary" class="btn btn-primary btn-sm btn-rounded text-bold">غیر فعال کردن</b-button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="">
                <div v-if="isLoading">
                  <!-- Loader or loading message here -->
                  <Loader />
                </div>
                <div class="card" style="margin-bottom:-60px !important">
                  <div class="card-body">
                    <h4 class="card-title mb-4">اطلاعات شخصی</h4>
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
                            <td>{{customer.address}}</td>
                            <!-- <td v-if="customer.address > 0">{{customer.address}}</td> -->
                            <!-- <td v-else>آدرس وجود ندارد</td> -->
                          </tr>
                          <tr>
                            <th scope="row">توضیحات :</th>
                            <p class="text-muted mb-4" v-if="customer!=null">{{customer.desc}}</p>
                            <p class="text-muted mb-4" v-else>توصیحاتی وجود ندارد</p>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end card -->
            </div>
          </div>
        </div>
        <!-- end card -->
        <div class="">
          <div v-if="isLoading">
            <!-- Loader or loading message here -->
            <Loader />          
          </div>
          <div class="card" v-else>
            <div class="card-body">
              <h4 class="card-titl badge  font-size-20 bg-primary ">بیلانس</h4>
              <div class="table-responsive mb-0">
                <div>
                  <table class="table table-centered table-nowrap">
                    <thead>
                      <tr>
                        <th>واحد</th>
                        <th>کل رسید </th>
                        <th>کل برداشتها</th>
                        <th>بیلانس</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(currency, key) in customerbalances" :key="key">
                        <td>{{ key }}</td>
                        <td>
                          <span class="badge  font-size-13" :class="currency.rasid > 0 ? 'bg-success' : 'bg-danger'">
                            {{ currency.rasid }}
                          </span>
                        </td>
                        <td>
                          <span class="badge  font-size-13" :class="currency.bord > 0 ? 'bg-success' : 'bg-danger'">{{ currency.bord }}</span>
                        </td>
                        <td>
                          <span class="badge  font-size-13" :class="currency.balance > 0 ? 'bg-success' : 'bg-danger'">{{ currency.balance }}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end card -->
      </div>
      <div class="col-xl-8">
        <div class="card h-100">
          <div class="card-body">
            <!-- <div class="table-responsive mb-0"> -->
            <div class="">
              <div class="col-xl-12 col-lg-12">
                <div class="card">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="search-box me-2 mb-2 d-inline-block">
                        <div class="position-relative">
                          <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
                          <i class="bx bx-search-alt search-icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="me-2 mb-2 d-inline-block">
                        <div class="position-relative">
                          <router-link class="btn btn-xs btn-primary" :to="`/dashboard/customer/${customer.id}/export`">خروجی</router-link>
                        </div>
                      </div>
                    </div>
                  </div>
                  <b-tabs content-class="p-4" class="pt-2" nav-wrapper-class="nav-item" nav-class="justify-content-center nav-tabs-custom">
                    <b-tab title="ترانزکشن" active>
                      <div>
                        <div class="row justify-content-center">
                          <div class="col-xl-12">
                            <div>
                              <hr class="mb-4" />
                              <div v-if="isLoading">
                                <!-- Loader or loading message here -->
                                <Loader />  
                              </div>
                              <div class="" v-else>
                                <div class="table-responsive" v-if="transactionslist?.length ">
                                  <div class="text-center font-size-20" v-if="notFound"> نتیجه مورد نظر یافت نشد! </div>
                                  <table class="table table-centered table-nowrap" v-else  ref="tableToExport">
                                    <thead>
                                      <tr>
                                        <th class="text-center">نمبر چک</th>
                                        <!-- <th class="text-center">نام مشتری</th> -->
                                        <th class="text-center">رسید برد</th>
                                        <th class="text-center">مقدار پول</th>
                                        <th class="text-center">مقدار معادل</th>
                                        <th class="text-center">تفصیلات</th>
                                        <th class="text-center">توسط</th>
                                        <th class="text-center">عملیه</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="transaction in transactionslist" :key="transaction?.id">
                                        <td>{{transaction.check_number}}</td>
                                        <td>
                                          <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                            {{transaction.rasid_bord}}
                                          </span>
                                        </td>
                                        <td>{{transaction.amount_equal}} {{transaction.eq_currency.name}} 
                                          {{transaction.rasid_bord ==='rasid'? 'به': 'از' }}
                                          <span v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</span>
                                          <span v-else>{{ transaction.finance_account.account_name}}</span>
                                        </td>

                                          <td>{{transaction.amount}} {{transaction.eq_currency.name}} 
                                          {{transaction.rasid_bord ==='rasid'? 'به': 'از' }}
                                          <span v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</span>
                                          <span v-else>{{ transaction.finance_account.account_name}}</span>
                                        </td>
                                        <td>{{transaction.desc}}</td>
                                        <td>{{transaction.user_id}}</td>
                                        <td>
                                          <button class="btn btn-xs">
                                            <i class="fas fa-pencil-alt text-success me-1" @click="editTransactionFunc(transaction.id)"></i>
                                          </button>
                                          <button class="btn btn-xs">
                                            <i class="fas fa-trash-alt text-danger me-1" @click="deleteTransaction(transaction.id)"></i>
                                          </button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <ul class="pagination pagination-rounded justify-content-center mb-2" style="text-center">
                                    <li class="page-item">
                                      <a class="page-link" href="javascript: void(0);" aria-label="Previous" @click="prevPage" :disabled="currentPage === 1">
                                        <i class="mdi mdi-chevron-left"></i>
                                      </a>
                                    </li>
                                    <li :class="['page-item', { 'active': pa === currentPage }]" v-for="(pa, index) in totalPages" :key="index">
                                      <a class="page-link" href="javascript: void(0);">{{ pa }}</a>
                                    </li>
                                    <li class="page-item">
                                      <a class="page-link" href="javascript: void(0);" aria-label="Next" @click="nextPage" :disabled="currentPage === totalPages">
                                        <i class="mdi mdi-chevron-right"></i>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <!-- <h3 class="text-center" v-else>این مشتری ترانزکشنی انجام نداده است</h3> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </b-tab>
                    <b-tab title="سفارشات">
                      <div>
                        <div class="row justify-content-center">
                          <div class="col-xl-12">
                            <!-- <h5>Archive</h5> -->
                            <div class="mt-5" v-if="orderslist?.length">
                              <hr class="mt-2" />
                              <div class="">
                                <table class="table table-centered table-nowrap" id="my-table">
                                  <thead>
                                    <tr>
                                      <th class="text-center">نمبر چک</th>
                                      <th class="text-center">نام مشتری</th>
                                      <th class="text-center">رسید برد</th>
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
                                      <td>{{transaction.check_number}}</td>
                                      <td v-if="transaction.customer!=null">{{ transaction.customer.name}}</td>
                                      <td v-else>{{ transaction.finance_account.account_name}}</td>
                                      <td>{{transaction.rasid_bord}}</td>
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
                      <div class="row flex" style="justify-content: center;">
                        <div class="row flex justify-between">
                          <div class="col-md-6 col-sm-12 col-lg-12">
                            <div class="mb-3">
                              <label for="editname">نام</label>
                              <input id="editname" v-model="editname" type="text" class="form-control" placeholder="نام خود را وارد کنید" />
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
                      <div class="row flex justify-between" style="justify-content: center;">
                        <div class="row flex justify-between">
                          <div class="col-md-6 col-sm-12 col-lg-12">
                            <div class="mb-3">
                              <label for="editUsername">نام کاربری</label>
                              <input id="editUsername" v-model="editUsername" type="text" class="form-control" placeholder="نام کاربری خود را وارد کنید" required />
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
                      <div class="row flex " style="justify-content: center;">
                          <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="mb-3">
                              <label for="editPassword">رمز عبور</label>
                              <input id="editPassword" v-model="editPassword" type="password" class="form-control" placeholder="رمز خود را وارد کنید" required />
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
              <!-- edit modal start edit transaction -->
              <div class="col-sm-8">
                <div class="text-sm-end">
                  <b-modal v-model="showModaltransaction" title="ویرایش ترانزکشن" title-class="text-black font-18" body-class="p-3" hide-footer>
                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
        }}</b-alert>
                    <form id="category_insert" class="form-horizontal form-label-left" @submit.prevent="submitEditTransaction">
                      <div class="form-group">
                        <div class="col-sm-12 col-xs-12">
                          <label for="supplier">نوعیت: </label>
                          <select class="form-control form-control-lg  required" v-model="edit_rasid_bord" required>
                            <option disabled value="">ابتدا نوعیت را انتخاب کنید.</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                          </select>
                          <span class="text-danger error-text currency_error"></span>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                          <label for="supplier">انتخاب شخص / حساب : </label>
                          <div>
                            <!-- <v-select v-model="editSelectedCustomer" :options="customer" label="name" placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer" /> -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4 col-xs-12">
                            <label for="supplier">واحد پول :</label>
                            <select class="form-control form-control-lg select2 required" @change="editChange_currency" v-model="editCurrencyModel" required>
                              <option disabled selected> واحد</option>
                              <option v-for="currency in edit_currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                            </select>
                            <span class="text-danger error-text currency_error"></span>
                          </div>
                          <div class="col-sm-8 col-xs-12">
                            <label for="name">مقدار پول :‌</label>
                            <input type="number" id="editAmount" v-model="editAmount" @input="editCalculateEqualAmount" class="form-control required">
                            <span class="text-danger error-text amount_error"></span>
                          </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                          <label for="supplier">انتخاب دخل : </label>
                          <select class="form-control form-control-lg select2 required" v-model="editSelectedDakhl">
                            <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                            <option v-for="editbank in editbanks" :key="editbank.id" :value="editbank.id">{{editbank.account_name}}</option>
                          </select>
                          <span class="text-danger error-text dakhl_error"></span>
                        </div>
                        <div class="row mb-2">
                          <div class="col-sm-4 col-xs-12">
                            <label for="name">نرخ ارز :‌</label>
                            <input type="number" id="editCurrency_rate" v-model="editCurrency_rate" @input="editCalculateEqualAmount" class="form-control required">
                            <span class="text-danger error-text currency_rate_error"></span>
                          </div>
                          <div class="col-sm-8 col-xs-12">
                            <label for="factore_date">تاریخ : </label>
                            <div class="input-group ">
                              <!-- @alireza-ab/vue3-persian-datepicker -->
                              <date-picker @select="editSelect" mode="single" type="date" locale="fa" :column="1"></date-picker>
                              <span class="">{{editDate}}</span>
                            </div>
                            <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4 col-xs-12">
                            <label for="supplier">واحد پول رسید:</label>
                            <select class="form-control form-control-lg select2 required" v-model="editEqualcurrencyModel">
                              <option disabled selected> واحد</option>
                              <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                            </select>
                            <span class="text-danger error-text currency_error"></span>
                          </div>
                          <div class="col-sm-8 col-xs-12">
                            <label for="name"> مقدار پول رسید:‌</label>
                            <input type="number" id="amount" v-model="editEqual_amount" class="form-control required">
                            <span class="text-danger error-text amount_error"></span>
                          </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                          <br>
                          <textarea id="disc" class="form-control" autocomplete="on" v-model="editDesc" rows="4" placeholder="توضیحات"></textarea>
                          <span class="text-danger error-text disc_error"></span>
                        </div>
                      </div>
                      <div class="text-end pt-5 mt-1 g-2">
                        <b-button variant="danger" @click="closeModal">بستن</b-button>
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