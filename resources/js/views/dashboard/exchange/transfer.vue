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
            isLoading:false,
            transfer_amount: '',
            transfer_currency_model: '',
            commission: 'darad',
            commission_amount: '',
            commission_currency_model: '',
            transfer_date: null,
            transfer_desc: '',
            // banks: [],
            currencies: [],
            transfers: [],
            source_selectedDakhl: '',
            destination_Dakhl: '',
            commission_selectedDakhl: '',
            sourcebanks: [],
            destinationbanks: [],
            commissionbanks: [],

            //    for edit

            edit_transfer_amount: '',
            edit_transfer_currency_model: '',
            edit_commission: null,
            edit_commission_currency_model: '',
            edit_transfer_date: null,
            edit_transfer_desc: '',
            edit_banks: [],
            edit_currencies: [],
            edit_source_selectedDakhl: '',
            edit_destination_Dakhl: '',
            edit_commission_selectedDakhl: '',
            edit_sourcebanks: [],
            edit_destinationbanks: [],
            edit_commissionbanks: [],
            edit_commission_amount: '',
            rasid_id: 0,
            bord_id: 0,
            commission_id: 0,

            errors: {},
        // pagination
        currentPage: 1,
        totalPages: 1,
        limit: 10,

        showCommission:true,
        edit_showCommission:true,

        };
    },
    mounted() {
        // this.getCurrency();
        this.getTransferTransaction();

    },

    methods: {

        //   this is for getting the jalali date value 
        select(date) {
            this.transfer_date = date.toString();
        },
        edit_select(date) {
            this.edit_transfer_date = date.toString();
        },

        openModaledit() {
            this.showModal = true;
            this.get_edit_Currency();
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
        async getTransferTransaction(page=1) {
                try {
                    this.isLoading=true;
                    const response = await api.get(`/gettransfers?page=${page}&limit=${this.limit}`);
                    this.transfers = response.data.transactions.data;
                    this.totalPages = response.data.transactions.last_page;
                    this.currentPage = page;
                     this.currencies = response.data.currencies;
                } catch (error) {
                    console.log(error.message);
                }finally{
                    this.isLoading=false;
                }
            // console.log(this.transfers);
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.getTransferTransaction(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getTransferTransaction(this.currentPage + 1); // Update the page parameter
            }
        },
       

        // for adding new Transaction  
        async storeTransferTransaction() {

            try {
                const response = await api.post('/storetransfer', {
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

                    // console.log("in data!=null", response.data);
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error!");
                        } else {
                            this.errors = response.data.error;

                        }

                    } else {

                        this.transfers.unshift(response.data.new_data1);
                        this.transfers.unshift(response.data.new_data2);
                        this.transfers.unshift(response.data.new_data3);

                        this.errors = {}
                        this.transfer_amount = ''
                        this.transfer_currency_model = ''
                        this.source_selectedDakhl = ''
                        this.destination_Dakhl = ''
                        this.commission = 'darad'
                        this.commission_amount = ''
                        this.commission_currency_model = ''
                        this.commission_selectedDakhl = ''
                        this.transfer_date = ''
                        this.transfer_desc = ''
                        this.showalert(response.data.message, "success", "success");

                    }

                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }

        },
        change_transfer_currency() {
            this.getBanksByCID(this.transfer_currency_model);
        },
        change_commission_currency() {
            // this.getBanks(this.commission_currency_model);
            this.getBanksByCIDforComision(this.commission_currency_model);
        },

        async getBanksByCID(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
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
                const response = await api.get('/getbankbyid/' + id);
                this.commissionbanks = response.data.banks;
                this.commission_selectedDakhl = this.commissionbanks[0].id;
            } catch (error) {
                console.log(error.message);
            }
        },

        // for edit
        async get_edit_Currency() {
            try {
                await api.get('/currencies').then((response) => {
                        this.edit_currencies = response.data.currencies.data;
                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },

        edit_change_transfer_currency() {
            this.edit_getBanksByCID(this.edit_transfer_currency_model);
        },
        edit_change_commission_currency() {
            this.edit_getBanksByCIDforComision(this.edit_commission_currency_model);
        },

        async edit_getBanksByCID(id) {
            try {
                const response = await api.get('/getbankbyid/' + id);
                this.edit_sourcebanks = response.data.banks;
                this.edit_destinationbanks = response.data.banks;

                this.edit_source_selectedDakhl = this.edit_sourcebanks[0].id;
                this.edit_destination_Dakhl = this.edit_destinationbanks[0].id;
            } catch (error) {
                console.log(error.message);
            }
        },

        async edit_getBanksByCIDforComision(id) {
            try {
                // get bank by currency id
                const response = await api.get('/getbankbyid/' + id);
                this.edit_commissionbanks = response.data.banks;
                this.edit_commission_selectedDakhl = this.edit_commissionbanks[0].id;

            } catch (error) {
                console.log(error.message);
            }
        },

        async edit_transfer_func(id, type) {
            
            const response = await api.post('/gettransferforedit', {
                id: id,
                rasid_bord: type
            });

            let rasid_list = response.data.rasid;
            let bord_list = response.data.bord;
            let commission_list = response.data.commission;
            this.openModaledit();
            this.rasid_id = rasid_list.id;
            this.bord_id = bord_list.id;
            this.commission_id = commission_list?.id;
            // console.log("commission id",this.commission_id);

            this.edit_transfer_amount = bord_list?.amount;
            this.edit_transfer_currency_model = bord_list.currency;
            this.edit_getBanksByCID(this.edit_transfer_currency_model)
            this.edit_source_selectedDakhl = bord_list.bank_acount_id;
            this.destination_Dakhl = rasid_list.bank_acount_id;

            this.edit_commission_currency_model = commission_list?.currency;
            this.edit_commission_amount = commission_list?.amount;
            this.edit_commission = commission_list?.commission;
            // console.log("commission_list",commission_list);
            this.edit_source_selectedDakhl = bord_list.bank_acount_id;
            this.edit_getBanksByCIDforComision(this.edit_commission_currency_model)
            this.edit_transfer_date = bord_list.date;
            this.edit_transfer_desc = bord_list.desc;

            

        },


        hideCommission(){
            this.showCommission = !this.showCommission;
            console.log("hideCommission");
        },
        editHideCommission(){
            // this.edit_showCommission = !this.showCommission;
            this.edit_showCommission = !this.edit_showCommission;
            console.log("this.edit_showCommission",this.edit_showCommission);
        }

,   
    async editSubmitTransfer() {
            try {
                const response = await api.post('/updateTransferTransaction', {
                    rasid_id: this.rasid_id,
                    bord_id: this.rasid_id,
                    commmission_id: this.commission_id,
                    transfer_amount: this.edit_transfer_amount,
                    currency: this.edit_transfer_currency_model,
                    source_bank_acount_id: this.edit_source_selectedDakhl,
                    destination_bank_acount_id: this.edit_destination_Dakhl,
                    commission: this.edit_commission,
                    commission_amount: this.edit_commission_amount,
                    commission_currency: this.edit_commission_currency_model,
                    commission_bank_acount_id: this.edit_commission_selectedDakhl,
                    date: this.edit_transfer_date,
                    desc: this.edit_transfer_desc,
                });
                console.log("this.edit_transfer_desc",this.edit_transfer_desc);
                if (response.data != null) {

                    // console.log("in data!=null", response.data);
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            console.log("response.data.status === false");
                            this.showalert(response.data.message, "error", "error!");
                        } else {
                            this.errors = response.data.error;
                        }
                    } else {

                        this.edit_transfer_amount = ''
                        this.edit_transfer_currency_model = ''
                        this.edit_source_selectedDakhl = ''
                        this.edit_destination_Dakhl = ''
                        this.edit_commission = ''
                        this.edit_commission_amount = ''
                        this.edit_commission_currency_model = ''
                        this.edit_commission_selectedDakhl = ''
                        this.edit_transfer_date = ''
                        this.edit_transfer_desc = ''

                        this.showModal = false;
                        this.getTransferTransaction();
                        this.showalert(response.data.message, "success", "success");

                    }

                }

            } catch (error) {
                console.log("Store in catch", error.message);
            }
            },
        async deleteTransfer() {
            if (!window.confirm('آیا میخواهید که رسید حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await api.post('/deletetransfer', {
                        rasid_id:this.rasid_id,
                        bord_id:this.bord_id,
                        commission_id:this.commission_id,
                    });

                    if (response.status === 204) {

                        this.getTransferTransaction();
                        this.showalert(' با موفقیت حذف شد!', 'success', 'success');

                    }

                } catch (error) {
                    this.showalert(error.message, 'error', 'error');
                }

            }
        },

        async searchData() {
            const response = await api.post('/searchtransfer', {
                query: this.searchQuery
            });
            this.transfers = response.data;
          
        
        },
    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-xl-4">
            <!-- edit modal start -->
            <div class="col-sm-8">
                <div class="text-sm-end">
                    <b-modal v-model="showModal" title="ویرایش انتقال" title-class="text-black font-18" body-class="p-3" hide-footer>
                        <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="editSubmitTransfer">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول انتقالی:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="edit_transfer_currency_model" @change="edit_change_transfer_currency" required>
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in edit_currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label for="name"> مقدار پول انتقالی:‌</label>
                                        <input type="number" id="edit_transfer_amount" v-model="edit_transfer_amount" class="form-control" required>
                                        <span class="text-danger error-text transfer_amount_error"></span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل انتقالی :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="edit_source_selectedDakhl" style="width: 100%;" required>
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in edit_sourcebanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل مقصد :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="edit_destination_Dakhl" style="width: 100%;" required>
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in edit_destinationbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                          
                                <div class="row mt-3">
                                   <div class="col-sm-12">
                                        <!--  <span class="">
                                            <label for="Commission" class="mx-1">کمیشن دارد:‌</label>
                                            <input class="form-check-input" type="radio" id="Commission" v-model="edit_commission" value="darad" name="Commission" />
                                        </span>
                                        <span>
                                            <label for="nocommission" class="mx-1">کمیشن ندارد:‌</label>
                                            <input class="form-check-input" type="radio" id="nocommission" v-model="edit_commission" name="Commission" value="nadarad" />
                                        </span>-->
                                    
                                    <select class="form-control form-control-lg select2 required" v-model="edit_commission" @change="editHideCommission">
                                       <!-- {{ transaction.commission_list ? `<option value="darad" selected>کمیشن دارد</option> :<option value="naDarad">کمیشن ندارد</option>` }}  -->
                                        
                                    </select>
                                </div> 
                                </div>
                                <span v-show="edit_showCommission">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول کمیشن:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="edit_commission_currency_model" @change="edit_change_commission_currency">
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in edit_currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="name">مقدار پول کمیشن :‌</label>
                                        <input type="number" id="commission_amount" v-model="edit_commission_amount" class="form-control">
                                        <span class="text-danger error-text amount_error"></span>
                                    </div>
                                </div>

                                <!-- commission bank -->
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل کمیشن :
                                    </label>
                                    <select class="form-control form-control-lg select2 " v-model="edit_commission_selectedDakhl" style="width: 100%;">
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in edit_commissionbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>
                                    </select>

                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                            </span>
                                <!-- commission bank -->

                                <div class="col-sm-12 col-xs-12 p-0">
                                    <label for="factore_date">تاریخ :
                                    </label>
                                    <div class="input-group ">
                                        <!-- @alireza-ab/vue3-persian-datepicker -->
                                        <date-picker @select="edit_select" mode="single" type="date" locale="fa" :column="1" clearable required>
                                        </date-picker>
                                    </div>
                                    <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                    <span class="text-center">{{edit_transfer_date}}</span>
                                </div>
                                <!-- </div> -->

                                <div class="col-sm-12 col-xs-12" style="padding-right:0px!important">
                                    <br>

                                    <textarea id="disc" class="form-control" autocomplete="on" v-model="edit_transfer_desc" rows="4" placeholder="توضیحات"></textarea>
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
                                            <option v-for="currency in currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                        </select>
                                        <span class="text-danger error-text currency_error"></span>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label for="name"> مقدار پول انتقالی:‌</label>
                                        <input type="number" id="transfer_amount" v-model="transfer_amount" class="form-control required" required>
                                        <span class="text-danger error-text transfer_amount_error"></span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل انتقالی :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="source_selectedDakhl" style="width: 100%;" required>
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in sourcebanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب دخل مقصد :
                                    </label>
                                    <select class="form-control form-control-lg select2 required" v-model="destination_Dakhl" style="width: 100%;" required>
                                        <option disabled selected>ابتدا واحد پول را انتخاب کنید.</option>
                                        <option v-for="bank in destinationbanks" :key="bank.id" :value="bank.id">{{bank.account_name}}</option>

                                    </select>
                                    <span class="text-danger error-text dakhl_error"></span>
                                </div>
                                <div class="row mt-3 ">
                                    <!-- <div class="col-sm-12">
                                        <span class="">
                                            <label for="Commission" class="mx-1">کمیشن دارد:‌</label>
                                            <input class="form-check-input" type="radio" id="Commission" v-model="commission" checked="true" value="darad" name="Commission" />
                                        </span>
                                        <span>
                                            <label for="Commission" class="mx-1">کمیشن ندارد:‌</label>
                                            <input class="form-check-input" type="radio" id="Commission_darad" v-model="commission" name="Commission" value="nadarad" />
                                        </span>
                                    </div> -->

                                    <div class="col-sm-12">
                                    <select class="form-control form-control-lg select2 required" v-model="commission" @change="hideCommission">
                                        <option value="darad" selected>کمیشن دارد</option>
                                        <option value="naDarad">کمیشن ندارد</option>
                                    </select>
                                </div>
                                </div>
                                    <!-- if doesn't commission don't show the bellow inputs -->
                                <span v-show="showCommission">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="supplier">واحد پول کمیشن:</label>
                                        <select class="form-control form-control-lg select2 required" v-model="commission_currency_model" @change="change_commission_currency">
                                            <option disabled selected> واحد</option>
                                            <option v-for="currency in currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
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
                            </span>
                                <!-- commission bank -->
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
            <div class="card"  style="min-height:100vh">

                <div class="card-body">

                    <div class="col-sm-4">

                        <div class="search-box me-2 mb-2 d-inline-block">

                            <div class="position-relative">
                                <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی انتقالات..." @input="searchData" />
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
                            <div class="table-responsive" v-if="transfers?.length">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">نمبر چک</th>
                                            <th class="text-center">رسید برد</th>
                                            <th class="text-center">مقدار پول</th>
                                            <th class="text-center">مقدار کمیشن</th>
                                            <th class="text-center">تفصیلات</th>
                                            <th class="text-center">توسط</th>
                                            <th class="text-center">عملیه</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="transaction in transfers" :key="transaction?.id" >

                                            <td>{{transaction?.check_number}}</td>
                                            <td>
                                                <span class="badge  font-size-12" :class="transaction?.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                                    {{transaction?.rasid_bord}}
                                                </span>
                                            </td>

                                            <td>{{transaction?.amount}} {{transaction?.tr_currency.name}}
                                                به
                                                <span v-if="transaction?.bank_account!=null">{{transaction.bank_account?.account_name}}</span>
                                                <span v-else>{{ transaction?.finance_account?.account_name}}</span>
                                            </td>
                                           
                                           
                                            <td>{{transaction?.commission}}</td>
                                            <td>{{transaction?.desc}}</td>
                                            <td>{{transaction?.user.name}}</td>

                                            <td>

                                                <button class="btn btn-xs">
                                                    <i class="fas fa-pencil-alt text-success me-1" @click="edit_transfer_func(transaction.id,transaction.rasid_bord)"></i>
                                                </button>

                                                <button class="btn btn-xs">
                                                    <i class="fas fa-trash-alt text-danger me-1" @click="deleteTransfer(transaction.id)"></i>
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
