<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import Loader from '../../loader/loader.vue';
import api from '../../../services/api';
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
      filter_rasid_bord:'',
      typeOfExchange:'',
      orderModel:'',
      currencyModel:'',
      SelectedDakhl:'',
      banks:[],
      currencies:[],
      customerName:'',
      currentPage: 1,
      totalPages: 1,
      limit: 10,
      customerbalances:[],
      isFiltering : false,
    };
  },
  mounted() {
    this.getTransactionbycid();

    this.filter_rasid_bord='all';
    this.typeOfExchange = 'all';
  },
  methods: {
    async getTransactionbycid(page = 1) {
      try {
        this.isLoading=true;
        const response = await api.post(`/customerinfo`, {
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
        this.customerbalances = response.data.customerBalance
        this.customerName = response.data?.customer?.data[0].name;
        this.currencies = response.data.currencies;
      } catch (error) {
        console.log(error.message);
      }finally{
        this.isLoading=false;
      }
    },
 
 
    change_currency() {
      this.getBanks(this.currencyModel);
        },
    async getBanks(id) {
      try {
        const response = await api.get('/getbankbyid/' + id);
        this.banks = response.data.banks;
        this.SelectedDakhl = this.banks[0].id;
        // console.log("this.banks",this.banks);
      } catch (error) {
        console.log(error.message);
      }
    },
    async filterCustomerExport() {
    try {
      // Set isFiltering to true to disable the button
      this.isFiltering = true;
      
      const response = await api.post('/exportcustomertopdf', {
        id: this.$route.params.id,
        transaction_type: this.typeOfExchange,
        rasid_bord: this.filter_rasid_bord,
        currency: this.currencyModel
      });
      
      this.transactionslist = response.data.customerExportFilter.data;
    } catch (error) {
      console.log(error.message);
    } finally {
      // Ensure to set isFiltering back to false after the function finishes
      this.isFiltering = false;
    }
  }
,

exportToPDF() {
      try {
        const tables = [
    this.$refs.table1,
    this.$refs.table2,
    // this.$refs.table3
  ];

  const pdf = new jsPDF('p', 'mm', 'a4');
  const imgWidth = 190; // Adjust as needed
  const farsiFont = '../../../../fonts/arial.ttf'; // Replace ... with your base64 font
  pdf.addFileToVFS('arial.ttf', farsiFont);
  pdf.setFont('arial');
  pdf.setFontSize(12); // Set the font size to 12
  let yOffset = 20; // Initial y offset below the header
  tables.forEach((table, index) => {
    html2canvas(table).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const imgHeight = canvas.height * imgWidth / canvas.width;
      
      // Add image to PDF
      pdf.addImage(imgData, 'PNG', 10, yOffset, imgWidth, imgHeight);

      // Increment y offset for the next table
      yOffset += imgHeight + 10;

      // If it's the last table, save the PDF
      if (index === tables.length - 1) {
        // Set footer
        const pageCount = pdf.internal.getNumberOfPages(); // Get the total number of pages
        for (let i = 1; i <= pageCount; i++) {
          pdf.setPage(i); // Set the current page
          const footerText = `Page ${i} of ${pageCount}`;
          const footerFontSize = 12;
          const footerX = pdf.internal.pageSize.getWidth() / 2;
          const footerY = pdf.internal.pageSize.getHeight() - 10;
          pdf.setFontSize(footerFontSize);
          pdf.text(footerText, footerX, footerY, { align: 'center' });
        }

        // Save PDF
        pdf.save(`${this.customerName}.pdf`);
      }
    });
  });
      } catch (error) {
        console.log(error.message);
      }
},




  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-12">
            <div class="card" >
              <div class="card-body">
                <h4 class="card-title mb-4">جستجوی معامله</h4>
                <form class="repeater" enctype="multipart/form-data">
                  <div>
                    <div  class="row">
                      <div class="mb-3 col-md-2">
                        <label for="email">نوع معامله</label>
                        <select class="form-control form-control-lg  required" v-model="typeOfExchange" >
                            <option value="all" selected>همه</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                            <option value="bord">سفارش</option>
                        </select>
                      </div>
                      <div class="mb-3 col-md-2">
                        <label for="email">نوع رسید وبرد</label>
                        <select class="form-control form-control-lg  required" v-model="filter_rasid_bord">
                            <option value="all">همه</option>
                            <option value="rasid">رسید</option>
                            <option value="bord">برد</option>
                        </select>
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
                           <!-- <input
                             type="button"
                             class="btn btn-primary btn-block"
                             value="جستجو"
                             @click="filterCustomerExport"
                           > -->
                        
                           <input
                           type="button"
                           class="btn btn-primary btn-block"
                           value="جستجو"
                           :disabled="isSearching"
                           @click="filterCustomerExport"
                         >
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
        <div class="card"  style="min-height:100vh">
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
                  <!-- <b-tabs content-class="p-4" class="pt-2" nav-wrapper-class="nav-item" nav-class="justify-content-center nav-tabs-custom"> -->
                    <!-- <b-tab title="ترانزکشن" active> -->
                      <div>
                        <div class="row justify-content-center">
                          <div class="col-xl-12">
                            <div>
                              <hr class="mb-4" />
                              <h3 ref="table1"> لیست تمامی تراکنش های {{customerName}}</h3>
                              <div v-if="isLoading">
                                <!-- Loader or loading message here -->
                                <Loader />  
                              </div>
                              <div class="" v-else>
                                
                                <div class="table-responsive" v-if="transactionslist?.length ">
                                  <div class="text-center font-size-20" v-if="notFound"> نتیجه مورد نظر یافت نشد! </div>
                                  <table class="table table-centered table-nowrap" v-else  ref="table2">
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
                                 <hr>
                                        
                                 <tr>
                                            <th>واحد</th>
                                            <th>کل رسید </th>
                                            <th colspan="2">کل برداشتها</th>
                                            <th colspan="2">بیلانس</th>
                                           
                                          </tr>
                                     
                                        <tbody>
                                          <tr v-for="(currency, key) in customerbalances" :key="key">
                                            <td>{{ key }}</td>
                                            <td>
                                              <span class="badge  font-size-13" :class="currency.rasid > 0 ? 'bg-success' : 'bg-danger'">
                                                {{ currency.rasid }}
                                              </span>
                                            </td>
                                            <td colspan="2">
                                              <span class="badge  font-size-13" :class="currency.bord > 0 ? 'bg-success' : 'bg-danger'">{{ currency.bord }}</span>
                                            </td>
                                            <td colspan="2">
                                              <span class="badge  font-size-13 "   :class="currency.balance > 0 ? 'bg-success' : 'bg-danger'">{{ currency.balance }}</span>
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
