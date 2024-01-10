<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import axios from 'axios';
import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';

/**
 * Rasidbord component
 */
export default {
    components: {
        Layout,
        PageHeader,
        DatePicker,
    },
    data() {
        return {
            title: "لیست انتقلات",
            items: [{
                    text: "انتقال",
                    href: "/"
                },
                {
                    text: "لیست انتقلات",
                    active: true
                }
            ],
            showModal: false,
            searchQuery: '',

            transfer_amount: 0,
            transfer_currency_model: '',
            commission:'darad',
            currency_rate: 0.00,
            rasid_currency_Model: '',
            commission_currency_model: '',
          
            // rasid_selectedDakhl: '',
            transfer_date: null,
            transfer_desc: '',
              // Dakhl V-Model and arrays
              banks: [],
              currencies: [],
            // show transaction in the table
            transfers: [],
            source_selectedDakhl: '',
            destination_Dakhl: '',
            commission_selectedDakhl:'',
            sourcebanks: [],
            destinationbanks: [],
            commissionbanks: [],

            // edit buy
            edit_transfer_amount: 0,
            edit_source_selectedDakhl: '',
            edit_sale_currency_model: '',
            edit_rasid_banks: [],
            edit_rasid_amount: '',
            edit_currency_rate: 0.00,
            edit_rasid_currency_Model: '',
            edit_rasid_selectedDakhl: '',
            edit_rasid_banks: [],
            edit_sale_date: null,
            edit_edit_rasid_desc: '',
            edit_bord_banks:[],
            edit_currencies:[],

            rasid_id :0,
            bord_id: 0,
            // Currency V-Model and arrays
                

            // for setting the current date
            errors: {},

        };
    },
    mounted() {
        this.getCurrency();
        this.getTransferTransaction();

    },

    methods: {

        //   this is for getting the jalali date value 
        select(date) {
            this.transfer_date = date.toString();

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
        async getTransferTransaction() {
            const response = await axios.get('/api/gettransfers');
            this.transfers = response.data;

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
        async get_edite_Currency() {
            try {
                await axios.get('/api/currencies').then((response) => {
                        this.edit_currencies = response.data.currencies;
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
        async storeTransferTransaction() {

                console.log('tag',this.source_selectedDakhl,this.destination_Dakhl,this.commission_selectedDakhl)
            
            try {
                const response = await axios.post('/api/storetransfer', {
                    transfer_amount: this.transfer_amount,
                    currency: this.transfer_currency_model,
                    source_bank_acount_id: this.source_selectedDakhl,
                    destination_bank_acount_id: this.destination_Dakhl,
                    commission: this.commission,
                    commission_amount: this.commission_amount,
                    commission_currency: this.commission_currency_model,
                    commission_bank_acount_id: this.commission_selectedDakhl,
                    date: this.transfer_date,
                    desc: this.transfer_desc,
                });

                if (response.data != null) {

                    console.log("in data!=null", response.data);
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error!");
                        } else {
                            this.errors = response.data.error;

                        }

                    } else {

                        this.transfers.push(response.data.new_data1);
                        this.transfers.push(response.data.new_data2);
                        this.transfers.push(response.data.new_data3);

                    this.errors = {}
                    this.transfer_amount=''
                    this.transfer_currency_model=''
                    this.source_selectedDakhl=''
                    this.destination_Dakhl=''
                    this.commission='darad'
                    this.commission_amount=''
                    this.commission_currency_model=''
                    this.commission_selectedDakhl=''
                    this.transfer_date=''
                    this.transfer_desc=''
                        this.showalert(response.data.message, "success", "success");

                    }

                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }

        },
        change_transfer_currency() {
            this.getBanks(this.transfer_currency_model);
        },
        change_commission_currency() {
            // this.getBanks(this.commission_currency_model);
            this.getBanksByCIDforComision(this.commission_currency_model);
        },

        // edit_Change_currency() {
        //     this.get_edit_rasid_bank(this.edit_rasid_currency_model);
        // },

        change_transfer_currency() {
            this.getBanksByCID(this.transfer_currency_model);
            // this.getBanksByCID(this.commission_currency_model);
        },

        edit_change_rasidcurrency() {
            this.edit_getBanksByCID(this.edit_sale_currency_model);
        },

        async edit_sale_func(id,type) {
            const response = await axios.post(`/api/getexchangesaleforedit/`,{id: id,rasid_bord:type});
            let rasid_list = response.data.rasid;
            let bord_list = response.data.bord;
            this.openModaledit();
            this.rasid_id=rasid_list.id;
            this.bord_id=bord_list.id;

            this.get_edit_bord_bank(bord_list.currency,bord_list.bank_acount_id);
            this.get_edit_rasid_bank(rasid_list.currency,rasid_list.bank_acount_id);
            this.edit_transfer_amount = bord_list.amount;
            this.edit_sale_currency_model = bord_list.currency;
            this.edit_edit_rasid_desc = rasid_list.desc;
            this.edit_currency_rate = bord_list.currency_rate;
            this.edit_rasid_amount = rasid_list.amount;
            this.edit_rasid_currency_Model = rasid_list.currency;
            this.edit_rasid_desc= bord_list.desc;
            this.edit_sale_date = bord_list.date;
        },
     
        async get_edit_bord_bank(curency_id,bank_id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + curency_id);
                this.edit_bord_banks = response.data.banks;
                // console.log("this.edit_bord_banks",this.edit_bord_banks);
                this.edit_source_selectedDakhl = this.edit_bord_banks.length > 0 ?
            this.edit_bord_banks.find(bank => bank.id === bank_id).id:
            '';

            } catch (error) {
                console.log(error.message);
            }
        },
        async get_edit_rasid_bank(curency_id,bank_id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + curency_id);
                this.edit_rasid_banks = response.data.banks;
                // this.edit_rasid_selectedDakhl = this.edit_rasid_banks[0].id;
               this.edit_rasid_selectedDakhl = this.edit_rasid_banks.length > 0 ? 
               this.edit_rasid_banks.find(banks => banks.id == bank_id).id:'';
                // console.log("get_edit_bord_bank this.edit_rasid_selectedDakhl",this.edit_rasid_selectedDakhl);
             
                

            } catch (error) {
                console.log(error.message);
            }
        },
        async submiteditBuyTransaction() {
            
            const response = await axios.post(`/api/updateexchange`, {
                rasid_id: this.rasid_id,
                rasid_amount: this.edit_transfer_amount,
                rasid_currency: this.edit_sale_currency_model,
                rasid_bank_acount_id: this.edit_source_selectedDakhl,

                bord_id:this.bord_id,
                bord_amount: this.edit_rasid_amount,
                bord_currency: this.edit_rasid_currency_Model,
                bord_bank_acount_id: this.edit_rasid_selectedDakhl,

                currency_rate: this.edit_currency_rate,
                date: this.edit_sale_date,
                desc: this.edit_edit_rasid_desc,
              
            });
            console.log(response.data);

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
                    this.transfers.push(response.data.new_data);
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
                    const response = await axios.post(`/api/deleteexchangesale`,{
                        id:id,
                    });
                   
                    if (response.status === 204) {

                        this.showalert(' با موفقیت حذف شد!', 'success', 'success');
                        this.getTransferTransaction();

                    }

                } catch (error) {
                    this.showalert(error.message, 'error', 'error');
                }
            }
        },
        async getBanks(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.banks = response.data.banks;
                // this.rasid_selectedDakhl = this.banks[0].id;
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async getBanksByCID(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.sourcebanks = response.data.banks;
                
                this.destinationbanks = response.data.banks;
                this.commissionbanks = response.data.banks;

                this.source_selectedDakhl = this.sourcebanks[0].id;
                this.destination_Dakhl = this.destinationbanks[0].id;
                // this.commission_selectedDakhl = this.commissionbanks[0].id;
              
                // console.log("selected Dakhl", this.selectedDakhl);

            } catch (error) {
                console.log(error.message);
            }
        },
        async getBanksByCIDforComision(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.commissionbanks = response.data.banks;
             
                this.commission_selectedDakhl = this.commissionbanks[0].id;
              

            } catch (error) {
                console.log(error.message);
            }
        },
        // async edit_getBanksByCID(id) {
        //     try {
        //         const response = await axios.get('/api/getbankbyid/' + id);
        //         this.edit_sourcebanks = response.data.banks;
        //         this.edit_transfer_selectedDakhl = this.sourcebanks[0].id;
        //         // console.log("selected Dakhl", this.selectedDakhl);

        //     } catch (error) {
        //         console.log(error.message);
        //     }
        // },
        async searchData() {
            const response = await axios.post('/api/searchtransaction', {
                query: this.searchQuery
            });

            this.transfers = response.data;
            console.log(this.transfers);
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


                <div class="card-body">
                    <h4 class="card-title mb-2 p-2 text-white text-center font-size-18" style="background-color: #3498db;">انتقال :</h4>
                    <span class="border-bottom w-100 font-size-16">
                        انتقال پول 
                    </span>
                    <div>

                        <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="storeTransferTransaction">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول انتقالی:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="transfer_currency_model" @change="change_transfer_currency" required>
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label for="name"> مقدار پول انتقالی:‌</label>
                                        <input type="number" id="transfer_amount" v-model="transfer_amount" class="form-control required">
                                        <span class="text-danger error-text transfer_amount_error"></span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل انتقالی :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="source_selectedDakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in sourcebanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل مقصد :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="destination_Dakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in destinationbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="row mt-3 ">
                                    <div class="col-sm-12">
                                    <span class="">
                                       <label for="Commission" class="mx-1">کمیشن دارد:‌</label>
                                       <input
                                       class="form-check-input"
                                       type="radio"
                                       id="Commission" v-model="commission"
                                       checked="true"
                                       value="darad"
                                       name="Commission"
                                     />
                                    </span>
                                      <span>
                                     <label for="Commission" class="mx-1">کمیشن ندارد:‌</label>
                                     <input
                                     class="form-check-input"
                                     type="radio"
                                     id="Commission_darad" v-model="commission"
                                     name="Commission"
                                     value="nadarad"
                                   />
                               </span>
                                   </div>
                           </div>

                           
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول کمیشن:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="commission_currency_model" @change="change_commission_currency" >
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="name">مقدار پول کمیشن :‌</label>
                                            <input type="number" id="rasid_amount" v-model="commission_amount" class="form-control">
                                            <span class="text-danger error-text amount_error"></span>
                                        </div>
                                </div>
                               

                                <!-- commission bank -->
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل کمیشن :
                                    </label>
                                    <select class="form-control form-control-lg select2 " v-model="commission_selectedDakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in commissionbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <!-- commission bank -->

                                <div class="col-sm-12 col-xs-12 p-0">
                                    <label for="factore_date">تاریخ :
                                    </label>
                                    <div class="input-group ">
                                        <!-- @alireza-ab/vue3-persian-datepicker -->
                                        <date-picker @select="select" mode="single" type="date" locale="fa" :column="1" required>
                                        </date-picker>
                                    </div>
                                    <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                </div>
                                <!-- </div> -->

                                <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                    <br>

                                    <textarea id="disc" class="form-control" autocomplete="on" v-model="transfer_desc" rows="4" placeholder="توضیحات"></textarea>
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

                            <div class="table-responsive" v-if="transfers.length > 0">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">آیدی</th>
                                            <th class="text-center">رسید برد</th>
                                            <th class="text-center">ترانزکشن تایپ</th>
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
                                        <tr v-for="transaction in transfers" :key="transaction?.id">
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input :id="`customCheck${transaction?.id}`" type="checkbox" class="form-check-input" />
                                                    <label class="form-check-label" :for="`customCheck${transaction?.id}`">&nbsp;</label>
                                                </div>
                                            </td>

                                            <td>{{transaction?.id}}</td>

                                            <td>
                                                <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                                    {{transaction.rasid_bord}}
                                                    </span>
                                                </td>

                                            <td>{{transaction.transaction_type}}</td>
                                            <td>{{transaction.check_number}}</td>
                                            <td>{{transaction.amount}}</td>
                                            <td>{{transaction.tr_currency.name}}</td>
                                            <td v-if="transaction.bank_account!=null">{{transaction.bank_account?.account_name}}</td>
                                            <td v-else>{{ transaction.finance_account?.account_name}}</td>
                                            <td>{{transaction.desc}}</td>
                                            <td>{{transaction.user_id}}</td>

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
