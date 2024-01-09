<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import axios from 'axios';
import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

/**
 * Rasidbord component
 */
export default {
    components: {
        Layout,
        PageHeader,
        DatePicker,
        vSelect,
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

            // for edit

            edit_rasid_bord: '',
            // edit amount
            editAmount: "",
            editCurrency_rate: '',
            editEqual_amount: '',
            editDesc: '',
            editDate: '',
            editDateString: '',
            editCurrencyModel: '',
            editSelectedDakhl: '',
            editbanks: [],
            editSelectedCustomer: null,
            editCustomer: [],
            editEqualcurrencyModel: '',

            newExpense: [],

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

        async getCustomers() {
            try {
                const response = await axios.get('/api/customer');
                this.customers = response.data.customers;

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        async getCurrency() {
            try {
                await axios.get('/api/currencies').then((response) => {
                        this.currencies = response.data.currencies;
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

                        this.transactions.push(response.data.new_data);

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
                        this.showalert(response.data.message, "success", "success");
                       
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

        async getTransaction() {
            const response = await axios.get('/api/transaction');
            this.transactions = response.data;

        },
        async searchData() {
            const response = await axios.post('/api/searchtransaction', {
                query: this.searchQuery
            });

            this.transactions = response.data;
            console.log(this.transactions);
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


        },
        async submitEditTransaction() {
            // console.log("Submit edit transaction", this.editSelectedCustomer.id);
            const response = await axios.post(`/api/updateTransaction/${id}`, {
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
                    this.showModal=false;
                    this.showalert(response.data.message, "success", "success");

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
            // console.log("getCustomerForEdit",id);
            try {
                const response = await axios.get('/api/customer');
                this.editCustomer = response.data.customers;
                this.editSelectedCustomer = this.editCustomer.length > 0 ? this.editCustomer.find(custom => custom.id === id) : '';
                // console.log(this.editCustomer.length > 0 ? this.editCustomer.find(custom => custom.id === id).name : '');

            } catch (error) {
                console.log(error.message);
            }
        },
        async deleteTransaction(id) {
            if (!window.confirm('آیا میخواهید که رسید برد حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await axios.delete(`/api/transaction/${id}`);
                    // this.transactions = response.data;
                    if (response.status === 204) {
                        // this.transactions.push(response.data.new_data)
                        this.showalert(' با موفقیت حذف شد!', 'success', 'success');
                        this.getTransaction();

                    }

                } catch (error) {
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
        <div class="col-xl-4">
            <div class="card">

                <!-- edit modal start -->
                <div class="col-sm-8">
                    <div class="text-sm-end">
                        <b-modal v-model="showModal" title="ویرایش مصرف" title-class="text-black font-18" body-class="p-3" hide-footer>
                            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
        }}</b-alert>

                            <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="storeTransaction">

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
                                                <v-select v-model="editSelectedCustomer" :options="editCustomer" label="name" placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer" />
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
                                            <input type="number" id="amount" v-model="editAmount" @input="editCalculateEqualAmount" class="form-control required">
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
                                            <input type="number" id="editCurrency_rate" v-model="editCurrency_rate" @input="editCalculateEqualAmount" class="form-control required">
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
                                    <!-- <label>رسید به حساب مشتری :‌ </label> -->
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
                                    <b-button type="submit" variant="success" class="ms-1 ml-2">ساختن</b-button>
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
                                        <v-select name="customerName" v-model="selectedCustomer" :options="customers" label="name" placeholder="مشتری مورد نظر خود را سرچ کنید" class="searchCustomer" style="width:105%;margin:0 -10px;height:4rem;padding:10px" />

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
                                        <input type="number" id="amount" v-model="amount" @input="calculateEqualAmount" class="form-control required">
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
                                        <input type="number" id="currency_rate" v-model="currency_rate" @input="calculateEqualAmount" class="form-control required">
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
                                        <select class="form-control form-control-lg select2 required" v-model="equalcurrencyModel" style="width: 100%;">
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
                                <input type="text" class="form-control" placeholder="جستجوی مشتری..." @input="searchData" />
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">

                            <div class="table-responsive" v-if="transactions.length > 0">
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
                                        <tr v-for="transaction in transactions" :key="transaction?.id">
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input :id="`customCheck${transaction?.id}`" type="checkbox" class="form-check-input" />
                                                    <label class="form-check-label" :for="`customCheck${transaction?.id}`">&nbsp;</label>
                                                </div>
                                            </td>

                                            <td>{{transaction?.id}}</td>
                                            <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                                            <td v-else>{{ transaction.finance_account?.account_name}}</td>
                                            <td>{{transaction.rasid_bord}}</td>
                                            <td>{{transaction.check_number}}</td>
                                            <td>{{transaction.amount}}</td>
                                            <td>{{transaction.tr_currency.name}}</td>
                                            <td v-if="transaction.bank_account!=null">{{transaction.bank_account?.account_name}}</td>

                                           
                                            <td v-else>{{ transaction.finance_account?.account_name}}</td> 

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

                                <ul class="pagination pagination-rounded justify-content-end mb-2">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                            <i class="mdi mdi-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="javascript: void(0);">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript: void(0);" aria-label="Next">
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
        <!-- end col -->
    </div>
    <!-- end row -->

</Layout>
</template>
