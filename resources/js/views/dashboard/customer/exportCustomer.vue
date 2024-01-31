<script>
  import Layout from "../../../layouts/main.vue";
  import PageHeader from "../../../components/page-header.vue";
  import axios from "axios";
  import Loader from '../../loader/loader.vue'
  import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

  export default {
    components: {
      Layout,
      PageHeader,
      Loader
    },
    data() {
      return {
        title: "صفحه خروجی گرفتن از اطلاعات مشتری",
        items: [{
          text: "مشتری",
          href: "/"
        }, {
          text: "خروجی پی دی اف",
          active: true
        }],
        isLoading: false,
        notFound: false,
        searchQuery: '',
        transactionslist: [],
        orderslist: [],

        // filter
        filter_rasid_bord:'',
        orderModel:'',
        currencyModel:'',
        SelectedDakhl:'',
        banks:[],
        currencies:[],
        orders:[], 

        errors: {},
        currentPage: 1,
        totalPages: 1,
        limit: 10,
      };
    },
    mounted() {
      this.getTransactionbycid();
      this.getCurrency();
      this.getOrders();
      this.filter_rasid_bord='all';
    //   this.orderModel='سفارش';
    //   this.currencyModel="واحد";
    },
   
    methods: {


      exportToPDF() {
    const table = this.$refs.table;
    html2canvas(table).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 190; // Adjust as needed
        const imgHeight = canvas.height * imgWidth / canvas.width;
        const farsiFont = '../../../../fonts/arial.ttf'; // Replace ... with your base64 font
        pdf.addFileToVFS('arial.ttf', farsiFont);
        pdf.setFont('arial');

        // Set header
        pdf.setPage(1); // Set the page number to 1
        pdf.setDrawColor(0); // Set the color for the header
        pdf.setFontSize(18); // Set the font size for the header
        pdf.text('My PDF Header', 105, 15, { align: 'center' }); // Text, x, y, options

        // Add image
        pdf.addImage(imgData, 'PNG', 10, 30, imgWidth, imgHeight); // Adjust Y position to make space for the header

        // Set footer
        const pageCount = pdf.internal.getNumberOfPages(); // Get the total number of pages
        for (let i = 1; i <= pageCount; i++) {
            pdf.setPage(i); // Set the current page
            pdf.setFontSize(12); // Set the font size for the footer
            pdf.text('Page ' + i + ' of ' + pageCount, 105, pdf.internal.pageSize.height - 10, { align: 'center' }); // Text, x, y, options
        }

        pdf.save('table.pdf');
    });
}
,
 
      async getTransactionbycid(page = 1) {
        try {
          const response = await axios.post(`/api/customerinfo`, {
            id: this.$route.params.id,
            rasid_bord:this.rasid_bord,
            order_id:this.order_id,
            bank_acount_id:this.bank_acount_id
          });
          this.transactionslist = response.data.transactions?.data;
          this.orderslist = response.data?.orders;
          this.rasid = response.data.rasid;
          this.bord = response.data.bord;
          this.totalAmount = response.data.total_amount;
          this.totalPages = response.data.customers?.last_page();
          this.currentPage = page;
          // console.log("transactionslist=",this.transactionslist);
        } catch (error) {
          console.log(error.message);
        }
      },
      prevPage() {
            if (this.currentPage > 1) {
                this.transactionslist(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.transactionslist(this.currentPage + 1); // Update the page parameter
            }
        },
        async getOrders() {
    
          try {
                const response = await axios.get(`/api/orders`);
                this.orders = response.data.orders.data;
                console.log(this.orderModel);
            } catch (error) {
                console.error('Error fetching orders:', error);
            }finally{
                this.isLoading=false;
            }
        },
        async getCurrency(){
            const response = await axios.get('/api/currencies');
            this.currencies = response.data.currencies.data;
        },
         change_currency() {
            this.getBanks(this.currencyModel);
        },
        async getBanks(id) {
            try {
                const response = await axios.get('/api/getbankbyid/' + id);
                this.banks = response.data.banks;
                this.SelectedDakhl = this.banks[0].id;

            } catch (error) {
                console.log(error.message);
            }
        },

        async filterCustomerExport(){

            try {
                const response = await axios.post('/api/exportcustomertopdf',{
                id: this.$route.params.id,
                rasid_bord:this.filter_rasid_bord,
                // order_id:this.orderModel,
                currency:this.currencyModel
                // bank_acount_id:this.bank_acount_id,
                });

             this.transactionslist= response.data.customerExportFilter.data;
        // console.log(this.transactionslist);
            } catch (error) {
                console.log(error.message)
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
                <h4 class="card-title mb-4">جستجوی معامله</h4>
                <form class="repeater" enctype="multipart/form-data">
                  <div>
                    <div  class="row">
                      <div class="mb-3 col-md-2">
                        <label for="email">نوع رسید وبرد</label>
                        <select class="form-control form-control-lg  required" v-model="filter_rasid_bord">
                            <option value="all">All</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                        </select>
                      </div>
                      <div class="col-md-2 col-xs-12">
                        <label for="supplier">سفارش:</label>
                        <select class="form-control form-control-lg select2 required"  v-model="orderModel" >
                            <option disabled selected> سفارش</option>
                            <option v-for="order in orders" :key="order?.id" :value="order?.id">
                                {{order?.id}}</option>
                        </select>
                        <span class="text-danger error-text currency_error"></span>
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
                        <div class="col-lg-1 align-self-center">
                            <div class="d-grid">
                           <input
                             type="button"
                             class="btn btn-primary btn-block"
                             value="جستجو"
                             @click="filterCustomerExport"
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
        <div class="card h-100">
          <div class="card-body">
            <!-- <div class="table-responsive mb-0"> -->
            <div class="text-center">
              <div class="col-xl-12 col-lg-12">
                <div class="card">
                  <div class="row">
                    <div class="col-md-10">
                            
                    </div>
                    <div class="col-md-2">
                      <div class="me-2 mb-2 d-inline-block">
                        <div class="position-relative">
                            <button class="btn btn-primary" @click="exportToPDF">خروجی گرفتن</button>
                          
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
                                  <table class="table table-centered table-nowrap" v-else  ref="table">
                                    <thead>
                                      <tr>
                                        <th class="text-center">نمبر چک</th>
                                        <!-- <th class="text-center">نام مشتری</th> -->
                                        <th class="text-center">رسید برد</th>
                                        <th class="text-center">مقدار پول</th>
                                        <th class="text-center">پول</th>
                                        <th class="text-center">تفصیلات</th>
                                        <th class="text-center">توسط</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="transaction in transactionslist" :key="transaction?.id">
                                        <td>{{transaction.check_number}}</td>
                                        <!-- <td v-if="transaction.customer!=null">{{ transaction.customer.name}}</td>
                                        <td v-else>{{ transaction.finance_account.account_name}}</td> -->
                                        <td>
                                          <span class="badge  font-size-12" :class="transaction.rasid_bord === 'rasid' ? 'bg-success' :'bg-danger'">
                                            {{transaction.rasid_bord}}
                                          </span>
                                        </td>
                                        <td>{{transaction.amount}} {{transaction.tr_currency.name}}  {{transaction.rasid_bord ==='rasid'? 'به': 'از' }} <span v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</span>
                                          <span v-else>{{ transaction.finance_account.account_name}}</span>
                                        </td>
                                        <td>{{transaction.amount_equal}} {{transaction?.eq_currency?.name}}  {{transaction.rasid_bord ==='rasid'? 'به': 'از' }} <span v-if="transaction.bank_account!=null">{{transaction.bank_account.account_name}}</span>
                                          <span v-else>{{ transaction.finance_account.account_name}}</span>
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
                              <div class="table-responsive">
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
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>