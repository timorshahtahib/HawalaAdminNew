<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import Loader from '../../loader/loader.vue'
import api from '../../../services/api';

/**
 * Rasidbord component
 */
export default {
    components: {
        Layout,
        PageHeader,
        DatePicker,
        Loader,
    },
    data() {
        return {
            title: "لیست فروشات",
            items: [{
                    text: "فروش",
                    href: "/"
                },
                {
                    text: "لیست فروش",
                    active: true
                }
            ],
            showModal: false,
            searchQuery: '',
            isLoading:false,
            sale_amount: 0,
            sale_currency_model: '',
            rasid_amount: '',
            currency_rate: 0.00,
            rasid_currency_Model: '',
            rasid_selectedDakhl: '',
            sale_date: null,
            rasid_desc: '',
            // Dakhl V-Model and arrays
            banks: [],
            currencies: [],
            // show transaction in the table
            transactions: [],
            bord_selectedDakhl: '',
            bordbanks: [],

            // edit buy
            edit_sale_amount: 0,
            edit_sale_currency_model: '',
            edit_rasid_amount: '',
            edit_currency_rate: 0.00,
            edit_rasid_currency_Model: '',
            edit_rasid_selectedDakhl: '',
            edit_sale_date: null,
            edit_rasid_desc: '',
            // Dakhl V-Model and arrays
            edit_banks: [],
            edit_currencies: [],
            edit_bord_selectedDakhl: '',
            edit_bordbanks: [],

            rasid_id :0,
            bord_id: 0,
            // Currency V-Model and arrays
                

            // for setting the current date
            errors: {},

             // pagination
             currentPage: 1,
            totalPages: 1,
            limit: 10,
        };
    },
    mounted() {
        this.getTransaction();

    },

    methods: {

        //   this is for getting the jalali date value 
        select(date) {
            this.sale_date = date.toString();

        },
        edit_select(date) {
            this.edit_sale_date = date.toString();
        },

        openModaledit() {
            this.showModal = true;
            this.get_edite_Currency();
        },
        closeModal() {
            this.showModal = false;
        },

        // for showing the showalert modal
        showalert(title, icon, confirmButtonText) {
            Swal.fire({
                title: title,
                icon: icon,
                confirmButtonText: confirmButtonText,
            });
        },
        async getTransaction(page=1) {
           try {
            this.isLoading=true;
            const response = await api.get(`/getsaletransaction?page=${page}&limit=${this.limit}`);
            this.transactions = response.data.transactions.data;
            this.totalPages = response.data.transactions.last_page;
            this.currentPage = page;
            this.currencies = response.data.currencies;
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
    
        async get_edite_Currency() {
            try {
                await api.get('/currencies').then((response) => {
                        this.edit_currencies = response.data.currencies.data;
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
        async storeSaleTransaction() {
            
            try {
                const response = await api.post('/salestore', {
                    bord_amount: this.sale_amount,
                    bord_currency: this.sale_currency_model,
                    bord_bank_acount_id: this.bord_selectedDakhl,

                    rasid_amount: this.rasid_amount,
                    rasid_currency: this.rasid_currency_Model,
                    rasid_bank_acount_id: this.rasid_selectedDakhl,
                    currency_rate: this.currency_rate,
                    finance_account_id: 20,
                   
                    date: this.sale_date,
                    desc: this.rasid_desc,
                });

                if (response.data != null) {

                    // console.log("in data!=null", response.data);
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error");
                        } else {
                            this.errors = response.data.error;

                        }

                    } else {

                        this.transactions.unshift(response.data.new_data1);
                        // this.transactions.unshift(response.data.new_data2);

                        this.errors = {}
                        this.sale_currency_model = '';
                        this.rasid_selectedDakhl = '';
                        this.sale_amount = 0;
                        this.rasid_amount = 0;
                        this.currency_rate=0;
                        this.sale_currency_model = '';
                        this.rasid_desc = '';
                        this.rasid_currency_Model = '';
                        this.sale_date = null;
                        this.showalert(response.data.message, "success", "success");

                    }

                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }

        },
        change_currency() {
            this.getBanks(this.rasid_currency_Model);
        },
        edit_change_currency() {
            this.get_edit_Banks(this.edit_rasid_currency_Model);
        },
        change_bord_currency() {
            this.getBordBanks(this.sale_currency_model);
        },
        edit_change_bord_currency() {
            this.edit_getBordBanks(this.edit_sale_currency_model);
            
        },

   

        async edit_sale_func(id,type) {
            const response = await api.post(`/getexchangesaleforedit/`,{id: id,rasid_bord:type});
            let rasid_list = response.data.rasid;
            let bord_list = response.data.bord;
            this.openModaledit();
            this.rasid_id=rasid_list.id;
            this.bord_id=bord_list.id;

            this.edit_getBordBanks(bord_list.currency,bord_list.bank_acount_id);
            this.edit_getRasidBanks(rasid_list.currency,rasid_list.bank_acount_id);
            this.edit_sale_amount = bord_list.amount;
            this.edit_sale_currency_model = bord_list.currency;

            this.edit_currency_rate = bord_list.currency_rate;
            this.edit_rasid_amount = rasid_list.amount;
            this.edit_rasid_currency_Model = rasid_list.currency;
            this.edit_rasid_desc= bord_list.desc;
            this.edit_sale_date = bord_list.date;
        },
        async submiteditSaleTransaction() {
            
            const response = await api.post(`/updatesaleexchange`, {
                bord_id: this.bord_id,
                bord_amount: this.edit_sale_amount,
                bord_currency: this.edit_sale_currency_model,
                bord_bank_acount_id: this.edit_bord_selectedDakhl,

                rasid_id:this.rasid_id,
                rasid_amount: this.edit_rasid_amount,
                rasid_currency: this.edit_rasid_currency_Model,
                rasid_bank_acount_id: this.edit_rasid_selectedDakhl,

                currency_rate: this.edit_currency_rate,
                date: this.edit_sale_date,
                desc: this.edit_rasid_desc,
              
            });
            // console.log(response.data);

            if (response.data != null) {
                // console.log("in data!=null");
                if (response.data.status === false) {

                    if (response.data.message != null) {
                       
                        this.showalert(response.data.message, "error", "error!");
                    } else {
                        this.errors = response.data.error;
                    }

                } else {

                    this.errors = {};
                    this.getTransaction();
                    this.showModal = false;
                    this.showalert(response.data.message, "success", "success");
                }
            }
         
              
        },

        async deleteSaleExchange(id) {
            if (!window.confirm('آیا میخواهید که رسید حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await api.post(`/deleteexchangesale`,{
                        id:id,
                    });
                   
                    if (response.status === 204) {

                        this.showalert(' با موفقیت حذف شد!', 'success', 'success');
                        this.getTransaction();

                    }

                } catch (error) {
                    this.showalert(error.message, 'error', 'error');
                }
            }
        },
        async getBanks(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.banks = response.data.banks;
                this.rasid_selectedDakhl = this.banks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async get_edit_Banks(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.edit_banks = response.data.banks;
                this.edit_rasid_selectedDakhl = this.edit_banks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async getBordBanks(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.bordbanks = response.data.banks;
                this.bord_selectedDakhl = this.bordbanks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
      
        async edit_getBordBanks(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.edit_bordbanks = response.data.banks;
                this.edit_bord_selectedDakhl = this.edit_bordbanks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async edit_getRasidBanks(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.edit_banks = response.data.banks;
                this.edit_rasid_selectedDakhl = this.edit_banks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async searchData() {
            const response = await api.post('/searchsaleexchange', {
                query: this.searchQuery
            });

            this.transactions = response.data;
            // console.log(this.transactions);
        },
    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-xl-4">
            <div class="card"  style="min-height:100vh;">

                <!-- edit modal start -->
                <div class="col-sm-8">
                    <div class="text-sm-end">
                        <b-modal v-model="showModal" title="ویرایش فروش" title-class="text-black font-18" body-class="p-3" hide-footer>
                                <form autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="submiteditSaleTransaction">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="supplier">واحد پول فروش:</label>
                                                <select class="form-control form-control-lg select2 required" v-model="edit_sale_currency_model" @change="edit_change_bord_currency" required>
                                                    <option disabled selected> واحد</option>
                                                    <option v-for="currency in currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                                </select>
                                                <span class="text-danger error-text currency_error"></span>
                                            </div>
        
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="name"> مقدار پول فروش:‌</label>
                                                <input type="number" step="0.0000001" id="sale_amount" v-model="edit_sale_amount" class="form-control required">
                                                <span class="text-danger error-text sale_amount_error"></span>
                                            </div>
        
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label for="supplier">انتخاب دخل فروش :
                                            </label>
                                            <select class="form-control form-control-lg select2 required" v-model="edit_bord_selectedDakhl" style="width: 100%;">
                                                <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                                <option v-for="bank in edit_bordbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>
        
                                            </select>
                                            <span class="text-danger error-text dakhl_error"></span>
                                        </div>
                                        <div class="row">
                                            <span class="border-bottom w-100 font-size-16">
                                                پول وارد شده به دخل
                                            </span>
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="supplier">واحد پول وارد شده :</label>
                                                <select class="form-control form-control-lg select2 required" @change="edit_change_currency" v-model="edit_rasid_currency_Model" style="width: 100%;" required>
                                                    <option disabled selected>رسید واحد</option>
                                                    <option v-for="currency in edit_currencies" :key="currency?.id" :value="currency.id">{{currency?.name}} {{currency?.sign}}</option>
                                                </select>
                                                <span class="text-danger error-text currency_error"></span>
                                            </div>
        
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="supplier">انتخاب دخل :
                                                </label>
                                                <select class="form-control form-control-lg select2 required" v-model="edit_rasid_selectedDakhl" style="width: 100%;">
                                                    <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                                    <option v-for="bank in edit_banks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>
                                                </select>
                                                <span class="text-danger error-text dakhl_error"></span>
                                            </div>
                                            <div class="row p-0 m-0">
                                                <div class="col-sm-6 col-xs-12">
                                                    <label for="name">مقدار پول وارد شده :‌</label>
                                                    <input type="number" step="0.0000001" id="edit_rasid_amount" v-model="edit_rasid_amount" @input="calculatePayAmount" class="form-control required">
                                                    <span class="text-danger error-text amount_error"></span>
                                                </div>
                                                <div class="col-sm-6 col-xs-12">
                                                    <label for="name">نرخ ارز :‌</label>
                                                    <input type="number" step="0.0001" id="edit_currency_rate" v-model="edit_currency_rate" @input="calculatePayAmount" class="form-control required">
                                                    <span class="text-danger error-text edit_currency_rate_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row"> -->
                                        <div class="col-sm-12 col-xs-12 p-0">
                                            <label for="factore_date">تاریخ :
                                            </label>
                                            <div class="input-group ">
                                                <!-- @alireza-ab/vue3-persian-datepicker -->
                                                <date-picker @select="edit_select" mode="single" type="date" locale="fa" :column="1" clearable required>
                                                </date-picker>
                                            </div>
                                            <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                        </div>
                                        <span class="text-center ">{{edit_sale_date}}</span>
                                        <!-- </div> -->
        
                                        <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                            <br>
        
                                            <textarea id="disc" class="form-control" autocomplete="on" v-model="edit_rasid_desc" rows="4" placeholder="توضیحات"></textarea>
                                            <span class="text-danger error-text disc_error"></span>
                                        </div>
        
                                    </div>
                                    <div class="form-group">
                                        <div class="text-end pt-2 mt-1 g-2 mb-2">
                                            <b-button type="submit" variant="primary" class="ms-1 ml-2">آپدیت</b-button>
                                        </div>
                                    </div>
                                </form>
                           
                        </b-modal>
                    </div>
                </div>
                <!-- edit modal end -->

                <div class="card-body">
                    <h4 class="card-title mb-2 p-2 text-white text-center font-size-18" style="background-color: crimson;">فروش :</h4>
                    <span class="border-bottom w-100 font-size-16">
                        پول فروخته شده از دخل
                    </span>
                    <div>

                        <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="storeSaleTransaction">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول فروش:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="sale_currency_model" @change="change_bord_currency" required>
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label for="name"> مقدار پول فروش:‌</label>
                                        <input type="number" id="sale_amount" v-model="sale_amount" step="0.0000001" class="form-control required">
                                        <span class="text-danger error-text sale_amount_error"></span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل فروش :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="bord_selectedDakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in bordbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="row">
                                    <span class="border-bottom w-100 font-size-16">
                                        پول وارد شده به دخل
                                    </span>
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول وارد شده :</label>
                                        <select class="form-control form-control-lg select2 required" @change="change_currency" v-model="rasid_currency_Model" style="width: 100%;" required>
                                            <option disabled selected>رسید واحد</option>
                                            <option v-for="currency in currencies" :key="currency?.id" :value="currency.id">{{currency?.name}} {{currency?.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">انتخاب دخل :
                                        </label>
                                        <select class="form-control form-control-lg select2 required" v-model="rasid_selectedDakhl" style="width: 100%;">
                                            <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                            <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>
                                        </select>
                                        <span class="text-danger error-text dakhl_error"></span>
                                    </div>
                                    <div class="row p-0 m-0">
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="name">مقدار پول وارد شده :‌</label>
                                            <input type="number" id="rasid_amount" step="0.0000001" v-model="rasid_amount" @input="calculatePayAmount" class="form-control required">
                                            <span class="text-danger error-text amount_error"></span>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="name">نرخ ارز :‌</label>
                                            <input type="number" step="0.0001" id="currency_rate" v-model="currency_rate" @input="calculatePayAmount" class="form-control required">
                                            <span class="text-danger error-text currency_rate_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row"> -->
                                <div class="col-sm-12 col-xs-12 p-0">
                                    <label for="factore_date">تاریخ :
                                    </label>
                                    <div class="input-group ">
                                        <!-- @alireza-ab/vue3-persian-datepicker -->
                                        <date-picker @select="select" mode="single" type="date" locale="fa" :column="1" clearable required>
                                        </date-picker>
                                    </div>
                                    <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                </div>
                                <!-- </div> -->

                                <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                    <br>

                                    <textarea id="disc" class="form-control" autocomplete="on" v-model="rasid_desc" rows="4" placeholder="توضیحات"></textarea>
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
            <div class="card"  style="min-height:100vh;">

                <div class="card-body">

                    <div class="col-sm-4">

                        <div class="search-box me-2 mb-2 d-inline-block">

                            <div class="position-relative">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="جستجوی فروشات..." @input="searchData" />
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
                                    <thead class="text-end">
                                        <tr>
                                            <th class="text-center">نمبر چک</th>
                                            <th class="text-center">مقدار فروش </th>
                                            <th class="text-center">مقدار دریافت شده  </th>
                                            <th class="text-center">تفصیلات</th>
                                            <th class="text-center">توسط</th>
                                            <th class="text-center">عملیه</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="transaction in transactions" :key="transaction?.id">
                                            
                                            <td>{{transaction?.check_number}}</td>
                                    
                                            <td>{{transaction?.amount.toLocaleString()}} {{transaction?.tr_currency.name}}
                                                به 
                                                <span v-if="transaction?.bank_account!=null">{{transaction?.bank_account.account_name}}</span>
                                                <span v-else>{{ transaction?.finance_account.account_name}}</span>
                                            </td>

                                            <td>{{transaction?.referenced_transaction.amount.toLocaleString()}} {{transaction?.eq_currency.name}}
                                        
                                            </td>
                                            <td>{{transaction?.desc}}</td>
                                            <td>{{transaction?.user.name}}</td>

                                            <td>

                                                <button class="btn btn-xs">
                                                    <i class="fas fa-pencil-alt text-success me-1" 
                                                    @click="edit_sale_func(transaction.id,transaction.rasid_bord)"></i>
                                                </button>

                                                <button class="btn btn-xs">
                                                    <i class="fas fa-trash-alt text-danger me-1" @click="deleteSaleExchange(transaction.id)"></i>
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
