<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../../js/components/page-header.vue";

import axios from 'axios';
// import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import Loader from "../loader/loader.vue";
import api from '../../services/api'
/**
 * Rasidbord component
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
            title: "لیست  تمام ترانزکشن ها",
            items: [{
                    text: "جستجوی ترانزکشن ها",
                    href: "/"
                },
                {
                    text: "لیست تمام ترانزکشن ها",
                    active: true
                }
            ],
            showModal: false,
            searchQuery: '',
            isLoading:false,
            transactions: [],
            banks:[],
            transaction_type:'',
            rasid_bord:'',
            selectedCustomer:'',
            currencyModel:'',
            SelectedDakhl:'',
            select_start_date:'',
            select_end_date:'',
            select_end_date:'',
            customers:[],
            // Currency V-Model and arrays
            currencies: [],
          
    
        
            // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,

        };
    },
    mounted() {
        this.getCurrency();
        this.getTransaction();
        this.getCustomers();
        this.getFinanceAccount()
        this.transaction_type='all'
        this.rasid_bord='all'
    },

    methods: {
     
        //   this is for getting the jalali date value
        select_start_date(date) {
            this.start_date = date.toString();

        },

        select_end_date(date) {
            this.end_date =  date.toString();
        },

        async getCustomers() {
            try {
                const response = await api.get('/customer');
                this.customers = response.data.customers.data;
                // console.log(this.customers);

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        async getCurrency() {
            try {
                await api.get('/currencies').then((response) => {
                        this.currencies = response.data.currencies.data;
                        // console.log(this.currencies);

                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
  
        async getFinanceAccount(page = 1) {
            this.isLoading=true;
            try {
                const response = await api.get(`/finance_account?page=${page}&limit=${this.limit}`);
                this.banks = response.data.financeAccounts.data;
                this.totalPages = response.data.financeAccounts.last_page;
                this.currentPage = page; // Update the current page
                // console.log(this.financeAccounts);
            } catch (error) {
                console.error('Error fetching finance Account:', error);
            }finally{
                this.isLoading=false;
            }
        },
   



        async getTransaction(page=1) {
            const response = await api.get(`/transaction?page=${page}&limit=${this.limit}`);
            this.transactions = response.data.transactions.data;
            this.totalPages = response.data.transactions.last_page;
            this.currentPage = page; // Update the current page

        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getTransaction(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getTransaction(this.currentPage + 1); // Update the page parameter
            }
        },
        async searchData() {
            const response = await api.post('/searchtransactions', {
                query: this.searchQuery
            });

            this.transactions = response.data;
        },

        async filterAlltransaction() {
            const response = await api.post('/filteralltransaction', {
                transaction_type:this.transaction_type,
                rasid_bord:this.rasid_bord,
                customer_id:this.selectedCustomer,
                currency:this.currencyModel,
                dakhl:this.SelectedDakhl,
                start_date:this.start_date,
                end_date:this.end_date,
            });

            this.transactions = response.data.transactions;
            // console.log("filterAlltransaction",this.transactions);
        },
   
    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">جستجوی معامله</h4>
                <form class="repeater" enctype="multipart/form-data">
                  <div>
                    <div  class="row">
                      <div class="mb-3 col-md-2">
                        <label for="email">نوع  معامله</label>
                        <select class="form-control form-control-lg  required" v-model="transaction_type">
                            <option value="all">همه</option>
                            <option value="rasid_bord">رسید و بردها</option>
                            <option value="exchange">تبادلات</option>
                            <option value="transfer">انتقلات</option>
                            <option value="expense">مصارف</option>
                            <option value="icome">درآمدها</option>
                        </select>
                      </div>
                      <div class="mb-3 col-md-2">
                        <label for="email">نوع رسید وبرد</label>
                        <select class="form-control form-control-lg  required" v-model="rasid_bord">
                            <option value="all">همه</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                        </select>
                      </div>
                      <div class="mb-3 col-md-4 mt-4 p-2" >
                        
                          <v-select name="customerName" v-model="selectedCustomer" :options="customers" label="name" placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer"/>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <label for="supplier">واحد پول :</label>
                            <select class="form-control form-control-lg select2 required" @change="change_currency" v-model="currencyModel" >
                                <option disabled selected> واحد</option>
                                <option v-for="currency in currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                            </select>
                            <span class="text-danger error-text currency_error"></span>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <label for="supplier">انتخاب دخل :
                            </label>
                            <select class="form-control form-control-lg select2 required" v-model="SelectedDakhl">
                                <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>
                            </select>
                            <span class="text-danger error-text dakhl_error"></span>
                        </div>
                     
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-2">
                            <label for="email">تاریخ شروع</label>
                            <date-picker @select="select_start_date" mode="single" type="date" locale="fa" :column="1" clearable>
                            </date-picker>
                          </div>
    
                          <div class="mb-3 col-lg-2">
                            <label for="email">تاریخ ختم</label>
                            <date-picker @select="select_end_date" mode="single" type="date" locale="fa" :column="1" clearable>
                            </date-picker>
                          </div>
    
                    
                          <div class="col-lg-1 align-self-center">
                             <div class="d-grid">
                            <input
                              type="button"
                              class="btn btn-primary btn-block"
                              value="جستجو"
                              @click="filterAlltransaction"
                            />
                             </div>
                          </div>
                    </div>
                  </div>

                </form>
              </div>
              <!-- end card-body -->
            </div>
            <!-- end card -->
          </div>
        <div class="col-xl-4">
            <div class="card">

            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">

                    <div class="col-sm-4">

                        <div class="search-box me-2 mb-2 d-inline-block">

                            <div class="position-relative">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="جستجوی مشتری..." @input="searchData" />
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div v-if="isLoading">
                                <Loader />
                              </div>
                          <div v-else>
                            <div class="table-responsive " v-if="transactions?.length">
                                <table class="table table-centered table-nowrap text-start">
                                    <thead>
                                        <tr>
                                            <th class="text-center">نمبر چک</th>
                                            <th class="text-center">تاریخ</th>
                                            <th class="text-center">نام مشتری</th>
                                            <th class="text-center">رسید برد</th>
                                            <th class="text-center">مقدار پول</th>
                                            <th class="text-center">تفصیلات</th>
                                            <th class="text-center">توسط</th>                                      
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="transaction in transactions" :key="transaction?.id">
                                      
                                            <td>{{transaction.check_number}}</td>
                                            <td>{{transaction?.date}}</td>
                                            <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                                            <td v-else>{{ transaction.finance_account?.account_name}}</td>
                                            <td>
                                                <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                                {{transaction.rasid_bord}}
                                                </span>
                                            </td>
                                           
                                            <td>{{transaction.amount}} {{transaction.tr_currency?.name}}
                                                به
                                                <span v-if="transaction?.bank_account!=null">{{transaction.bank_account?.account_name}}</span>
                                                <span v-else>{{ transaction.finance_account?.account_name}}</span>
                                            </td>
                                           <td>{{transaction.desc}}</td>
                                            <td>{{transaction.user_id}}</td>


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
                            <div v-else class="text-center font-size-20">
                                نتیجه مورد نظر یافت نشد!
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

</Layout>
</template>
