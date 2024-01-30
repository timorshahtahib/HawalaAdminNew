<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import axios from 'axios';
import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Loader from '../../loader/loader.vue'
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
            isLoading:false,
            showModal: false,
            searchQuery: '',
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
            currency_rate: 1.00,
            equal_amount: 0,
         
            // for setting the current date
            transaction_date: null,
            errors: {},

            // Description
            desc: '',
            // show transaction in the table
            transactions: [],
            // Equals v-model
            // equalcurrencyModel: '',
            equalcurrencyModel: '',

            // for edit

            edit_rasid_bord: '',
            // edit amount
            editAmount: "",
            editCurrency_rate: 1.00,
            editEqual_amount: 0,
            editDesc: '',
            editDate: '',
            editDateString: '',
            editCurrencyModel: '',
            editSelectedDakhl: '',
            editbanks: [],
            editSelectedCustomer: '',
            editCustomers: [],
            editEqualcurrencyModel: '',

            newExpense: [],

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

    },

    methods: {

        //   this is for getting the jalali date value 
        select(date) {
            this.transaction_date = date.toString();

        },
        editSelect(date) {
            this.editDate = date.toString();
        },
        async getTransaction(page=1) {
            this.isLoading=true;
                try {
                    const response = await axios.get(`/api/transaction?page=${page}&limit=${this.limit}`);
                    this.transactions = response.data.transactions.data;
                    this.totalPages = response.data.transactions.last_page;
                    this.currentPage = page; 
                } catch (error) {
                    console.log(error.message);
                }finally{
                    this.isLoading=false;
                }

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

        async getCustomers() {
            try {
                const response = await axios.get('/api/customer');
                this.customers = response.data.customers.data;
            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        async getCurrency() {
            try {
                await axios.get('/api/currencies').then((response) => {
                        this.currencies = response.data.currencies.data;
                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        // for adding new Transaction  
        async storeTransaction() {
            try {
                const response = await axios.post('/api/transaction', {
                    rasid_bord: this.rasid_bord,
                    transaction_type: this.rasid_bord,
                    ref_id: this.selectedCustomer.id,
                    amount: this.amount,
                    currency: this.currencyModel,
                    amount_equal: this.equal_amount,
                    currency_equal: this.equalcurrencyModel,
                    currency_rate: this.currency_rate,
                    bank_acount_id: this.selectedDakhl,
                    date: this.transaction_date,
                    desc: this.desc,
                    // user id is static
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

                        this.transactions.unshift(response.data.new_data);

                        this.errors = {}
                        this.rasid_bord = ''
                        this.selectedCustomer = null,
                            this.currencyModel = ''
                        this.selectedDakhl = ''
                        this.amount = 0,
                            this.currency_rate = 1
                        this.equal_amount = 0
                        this.transaction_date =''
                        this.currencyModel = ''
                        this.desc = ''
                        this.equalcurrencyModel = ''
                        this.showalert(response.data.message, "success", "بستن");
                       
                    }

                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }

        },
        change_currency() {
            this.getBanks(this.currencyModel);
        },

        editChange_currency() {
            this.getBanksForEdit(this.editCurrencyModel);
        },

    
        async searchData() {
            const response = await axios.post('/api/searchtransactions', {
                query: this.searchQuery
            });
            this.transactions = response.data;
            
        },

        async editTransactionFunc(id) {
            const response = await axios.get(`/api/transaction/${id}`);
            this.editTransaction = response.data;
            this.openModaledit(this.editTransaction[0]);
            this.edit_rasid_bord = this.editTransaction[0].rasid_bord
            this.editAmount = this.editTransaction[0].amount;
            this.editCurrency_rate = this.editTransaction[0].currency_rate;
            this.editEqual_amount = this.editTransaction[0].amount_equal;
            this.editDesc = this.editTransaction[0].desc;
            this.editDate = this.editTransaction[0].date;
            this.editCurrencyModel = this.editTransaction[0].currency;
            this.editEqualcurrencyModel = this.editTransaction[0].currency_equal;
            this.getBanksForEdit(this.editCurrencyModel)
            this.getCustomerForEdit(this.editTransaction[0].ref_id);

            //  console.log("this.editTransaction", this.editTransaction);

        },
        async submitEditTransaction() {
            let id = this.editTransaction[0].id;
            const response = await axios.post(`/api/updateTransaction`, {
                id: this.editTransaction[0].id,
                rasid_bord: this.edit_rasid_bord,
                transaction_type: this.edit_rasid_bord,
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
                    this.showModal=false;
                    this.showalert(response.data.message, "success", "بستن");
                    this.getTransaction();

                    // console.log(response.data);
                }
            }
            //  console.log("Successfully updated", this.editTransaction);

        },

        async getBanksForEdit(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.editbanks = response.data.banks;
                // console.log("getNBanks",this.editbanks);
                this.editSelectedDakhl = this.editbanks[0].id;

            } catch (error) {
                console.log(error.message);
            }
        },
        async getCustomerForEdit(id) {
        
            try {
                const response = await axios.get('/api/customer');
                this.editCustomers = response.data.customers.data;
                this.editSelectedCustomer = this.editCustomers.length > 0 ? this.editCustomers.find(custom => custom.id === id) : '';
                
            } catch (error) {
                console.log(error.message);
            }
        },
        async deleteTransaction(id) {
            if (!window.confirm('آیا میخواهید که رسید برد حذف شود؟')) {
                return;
            } else {
                try {

                    const response = await axios.post(`/api/deleteonetransaction`,{id:id});

                    // const response = await axios.get(`/api/transactiondelete/${id}`);

                    // this.transactions = response.data;
                    if (response.status === 204) {
                        // this.transactions.push(response.data.new_data)
                        this.showalert(' با موفقیت حذف شد!', 'success', 'بستن');
                        this.getTransaction();

                    }

                } catch (error) {
                    this.showalert(' با موفقیت حذف نشد!', 'error', 'بستن');
                }
            }
        },
        async getBanks(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.banks = response.data.banks;
                this.selectedDakhl = this.banks[0].id;

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
            <div class="card">

                <!-- edit modal start -->
                <div class="col-sm-8">
                    <div class="text-sm-end">
                        <b-modal v-model="showModal" title="ویرایش مصرف" title-class="text-black font-18" body-class="p-3" hide-footer>
                            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
        }}</b-alert>

                            <form id="category_insert"  class="form-horizontal form-label-left" @submit.prevent="submitEditTransaction">

                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <label for="supplier">نوعیت:
                                        </label>
                                        <select class="form-control form-control-lg  required" v-model="edit_rasid_bord" required>
                                            <option disabled value="">ابتدا نوعیت را انتخاب کنید.</option>
                                            <option value="rasid">رسید</option>
                                            <option value="bord">برد</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <label for="supplier">انتخاب شخص / حساب :
                                        </label>

                                        <div>

                                            <div>
                                                <v-select v-model="editSelectedCustomer" :options="editCustomers" label="name" 
                                                placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer" required/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <label for="supplier">واحد پول :</label>
                                            <select class="form-control form-control-lg select2 required" @change="editChange_currency" v-model="editCurrencyModel" required>
                                                <option disabled selected> واحد</option>
                                                <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                            </select>
                                            <span class="text-danger error-text currency_error"></span>
                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <label for="name">مقدار پول :‌</label>
                                            <input type="number"  step="0.01" id="amount" v-model="editAmount" @input="editCalculateEqualAmount" class="form-control required">
                                            <span class="text-danger error-text amount_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">
                                        <label for="supplier">انتخاب دخل :
                                        </label>
                                        <select class="form-control form-control-lg select2 required" v-model="editSelectedDakhl">
                                            <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                            <option v-for="editbank in editbanks" :key="editbank.id" :value="editbank.id">{{editbank.account_name}}</option>
                                        </select>
                                        <span class="text-danger error-text dakhl_error"></span>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-xs-12">
                                            <label for="name">نرخ ارز :‌</label>
                                            <input type="number" step="0.01" id="editCurrency_rate" v-model="editCurrency_rate" @input="editCalculateEqualAmount" class="form-control required">
                                            <span class="text-danger error-text currency_rate_error"></span>

                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <label for="factore_date">تاریخ :
                                            </label>
                                            <div class="input-group ">
                                                <!-- @alireza-ab/vue3-persian-datepicker -->
                                                <date-picker @select="editSelect" mode="single" type="date" locale="fa" :column="1">
                                                </date-picker>
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

                <div class="card-body">
                    <h4 class="card-title mb-4">مصرف جدید :</h4>

                    <!-- <div class="table-responsive"> -->
                    <div>
                        <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="storeTransaction">

                            <div class="form-group">
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">نوعیت:
                                    </label>
                                    <select class="form-control form-control-lg  required" v-model="rasid_bord" required>
                                        <option disabled value="">ابتدا نوعیت را انتخاب کنید.</option>
                                        <option value="rasid">رسید</option>
                                        <option value="bord">برد</option>
                                    </select>
                                    <span class="text-danger error-text currency_error"></span>
                                </div>
                                <div class="col-sm-12 col-xs-12">

                                    <label for="supplier">انتخاب شخص / حساب :
                                    </label>

                                    <div class="bg-red me-auto">
                                        <v-select name="customerName" v-model="selectedCustomer" :options="customers" label="name" placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer" style="width:105%;margin:0 -10px;height:4rem;padding:10px" required/>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <label for="supplier">واحد پول :</label>
                                        <select class="form-control form-control-lg select2 required" @change="change_currency" v-model="currencyModel" style="width: 100%;" required>
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-12">
                                        <label for="name">مقدار پول :‌</label>
                                        <input type="number" id="amount"  v-model="amount" @input="calculateEqualAmount" class="form-control required">
                                        <span class="text-danger error-text amount_error"></span>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                    <label for="supplier">انتخاب دخل :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="selectedDakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>

                                </div>

                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <label for="name">نرخ ارز :‌</label>
                                        <input type="number" step="0.01" id="currency_rate" v-model="currency_rate" @input="calculateEqualAmount" class="form-control required">
                                        <span class="text-danger error-text currency_rate_error"></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-12">
                                        <label for="factore_date">تاریخ :
                                        </label>
                                        <div class="input-group ">
                                            <!-- @alireza-ab/vue3-persian-datepicker -->
                                            <date-picker @select="select" mode="single" type="date" locale="fa" :column="1" required>
                                            </date-picker>

                                        </div>
                                        <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <label>رسید به حساب مشتری :‌ </label> -->
                                    <div class="col-sm-4 col-xs-12">
                                        <label for="supplier">واحد پول رسید:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="equalcurrencyModel" style="width: 100%;" @change="getDefaultCurrency">
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-8 col-xs-12">
                                        <label for="name"> مقدار پول رسید:‌</label>
                                        <input type="number" id="amount" v-model="equal_amount" class="form-control required">
                                        <span class="text-danger error-text amount_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                    <br>

                                    <textarea id="disc" class="form-control" autocomplete="on" v-model="desc" rows="4" placeholder="توضیحات"></textarea>
                                    <span class="text-danger error-text disc_error"></span>

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="text-end pt-2 mt-1 g-2 mb-2">
                                    <b-button type="submit" variant="primary" class="ms-1 ml-2">ساختن</b-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-8">
            <div class="card">

                <div class="card-body">

                    <div class="col-sm-4">

                        <div class="search-box me-2 mb-2 d-inline-block">

                            <div class="position-relative">
                                <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
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
                            <div class="table-responsive" v-if="transactions?.length">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                        
                                            <th class="text-center">نمبر چک</th>
                                            <th class="text-center">نام مشتری</th>
                                            <!-- <th class="text-center">رسید برد</th> -->
                                            <th class="text-center">مقدار پول</th>
                                            <th class="text-center">تفصیلات</th>
                                            <th class="text-center">توسط</th>
                                            <th class="text-center">عملیه</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="transaction in transactions" :key="transaction?.id">
                                            <td>{{transaction.check_number}}</td>
                                            <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                                            <td v-else>{{ transaction.finance_account?.account_name}}</td>
                                            <!-- <td>
                                                <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                                {{transaction.rasid_bord}}
                                            </span>
                                        </td> -->
                                            
                                            <td>{{transaction.amount}} {{transaction.tr_currency.name}} به <span v-if="transaction.bank_account!=null">{{transaction.bank_account?.account_name}}</span>
                                                <span v-else>{{ transaction.finance_account?.account_name}}</span> </td>
                                            
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
