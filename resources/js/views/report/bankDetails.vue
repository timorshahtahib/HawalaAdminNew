<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../../js/components/page-header.vue";

import axios from 'axios';
// import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import Loader from '../loader/loader.vue'
/**
 * Rasidbord component
 */
export default {
    components: {
        Layout,
        PageHeader,
        DatePicker,
        vSelect,
        Loader,

    },
    data() {
        return {
            title: "لیست رسید و برد ها",
            items: [{
                    text: "مصرف",
                    href: "/"
                },
                {
                    text: "لیست رسید و برد ها",
                    active: true
                }
            ],
            showModal: false,
            searchQuery: '',
            isLoading:false,
            start_date:'',
            end_date:'',
            rasid_bord_type:'',
            //  V-Select Customer
            customers: [],

            // for v-select should be null
            selectedCustomer: '',

            // V-Model of rasid_bord select input
            rasid_bord: '',

            // Currency V-Model and arrays
            currencies: [],
            currencyModel: '',

            // Dakhl V-Model and arrays
            selectedDakhl: '',
            banks: [],

            // does has an error
            amount: 0,
            currency_rate: 1,
            equal_amount: 0,

            // for setting the current date
            transaction_date: null,
            errors: {},

            // currencies object
            currencies: [],
            currencyModel: '',
            // Description
            desc: '',
            // show transaction in the table
            transactions: [],
            // Equals v-model
            equalcurrencyModel: '',

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
        this.rasid_bord_type='all'
    },

    methods: {
    
        //   this is for getting the jalali date value
        select_start_date(date) {
            this.start_date = date.toString();
        },

        select_end_date(date) {
            this.end_date =  date.toString();
        },

        async searchbankTransaction(){

            try {
                const response = await axios.post('/api/filterBankTransactions', {
                    tr_type: this.rasid_bord_type,
                    bank_acount_id: this.$route.params.id,
                    start_date: this.start_date,
                    end_date: this.end_date,
                });
                if (response.data != null) {
                        this.transactions=response.data.searchBank


                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }
        },
        updateSelectedCustomer(customer) {
            this.selectedCustomer = customer.name;
            // console.log("Customerseleted", this.selectedCustomer);
        },

        openModaledit() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        // showing data in the table

        // for calculating the Equal to input type
        calculateEqualAmount() {
            this.equal_amount = this.amount / this.currency_rate;
        },
        editCalculateEqualAmount() {
            this.editEqual_amount = this.editAmount / this.editCurrency_rate;
        },
        // for showing the showalert modal
        showalert(title, icon, confirmButtonText) {
            Swal.fire({
                title: title,
                icon: icon,
                confirmButtonText: confirmButtonText,
            });
        },

        async getCustomers(page =1) {
       
            try {
                const response = await axios.get(`/api/customer?page=${page}&limit=${this.limit}`);
                this.customers = response.data.customers.data;
              
                this.totalPages = response.data.customers.last_page;
                this.currentPage = page; // Update the current page
                // console.log(this.customers);

            } catch (error) {
                console.error('Error fetching customers:', error);
            }
        },
      
        async getCurrency() {
            try {
                await axios.get('/api/currencies').then((response) => {
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
        // for adding new Transaction

        change_currency() {
            this.getBanks(this.currencyModel);
        },

    
        async getTransaction(page = 1) {
            this.isLoading=true;
           try {
            let d= this.$route.params.id
            const response = await axios.get('/api/bankdetails/'+d);
            this.transactions = response.data.banksTransaction;
           } catch (error) {
            console.log(error.message);
           }finally{
            this.isLoading=false;
           }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getCustomers(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getCustomers(this.currentPage + 1); // Update the page parameter
            }
        },
        async searchData() {
            const response = await axios.post('/api/searchtransactions', {
                query: this.searchQuery
            });

            this.transactions = response.data;
            // console.log(this.transactions);
        },

    
        async deleteTransaction(id) {
            if (!window.confirm('آیا میخواهید که رسید برد حذف شود؟')) {
                return;
            } else {
                try {

                    // const response = await axios.post(`/api/deleteonetransaction`,{id:id});

                   
                    const response = await axios.post(`/api/deleteOneTransaction`,{id:id});

                    // this.transactions = response.data;
                    if (response.status === 204) {
                        console.log("response.status === 204");
                        // this.transactions.push(response.data.new_data)
                        this.showalert(' با موفقیت حذف شد!', 'success', 'success');
                        this.getTransaction();

                    }

                } catch (error) {
                    console.log("error");
                    this.showalert(' با موفقیت حذف نشد!', 'error', 'error');
                }
            }
        },
        async getBanks(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.banks = response.data.banks;
                this.selectedDakhl = this.banks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

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
        <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">جستوج معامله</h4>
                <form class="repeater" enctype="multipart/form-data">
                  <div>
                    <div  class="row">


                      <div class="mb-3 col-lg-2">
                        <label for="email">نوع  معامله</label>
                        <select class="form-control form-control-lg  required" v-model="rasid_bord_type">

                            <option value="all">همه</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                          
                        </select>
                      </div>
                      <div class="mb-3 col-lg-2">
                        <label for="email">تاریخ شروع</label>
                        <date-picker @select="select_start_date" mode="single" type="date" locale="fa" :column="1" required>
                        </date-picker>
                      </div>

                      <div class="mb-3 col-lg-2">
                        <label for="email">تاریخ ختم</label>
                        <date-picker @select="select_end_date" mode="single" type="date" locale="fa" :column="1" required>
                        </date-picker>
                      </div>



                      <div class="col-lg-2 align-self-center">
                         <div class="d-grid">
                        <input
                          type="button"
                          class="btn btn-primary btn-block"
                          value="جستجو"
                          @click="searchbankTransaction"
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
                                <div class="table-responsive" v-if="transactions.length">
                                    <table class="table table-centered table-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center">آیدی</th>
                                                <th class="text-center">تاریخ</th>
                                                <th class="text-center">نام مشتری</th>
                                                <th class="text-center">رسید برد</th>
                                                <th class="text-center">نمبر چک</th>
                                                <th class="text-center">مقدار پول</th>
                                                <th class="text-center">واحد</th>
                                                <th class="text-center">دخل</th>
                                                <th class="text-center">تفصیلات</th>
                                                <th class="text-center">توسط</th>
    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="transaction in transactions" :key="transaction?.id">
                                                <td>{{transaction?.id}}</td>
                                                <td>{{transaction?.date}}</td>
                                                <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                                                <td v-else>{{ transaction.finance_account?.account_name}}</td>
                                                <td>
                                                    <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                                    {{transaction.rasid_bord}}
                                                    </span>
                                                </td>
                                                <td>{{transaction.check_number}}</td>
                                                <td>{{transaction.amount}}</td>
                                                <td>{{transaction.tr_currency.name}}</td>
                                                <td v-if="transaction.bank_account!=null">{{transaction.bank_account?.account_name}}</td>

                                                <td v-else>{{ transaction.finance_account?.account_name}}</td>
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
