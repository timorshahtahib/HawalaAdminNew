<script>
import Layout from "../../layouts/main.vue";
import Transaction from "../../components/widgets/transaction.vue";
import Emailsent from "../../components/widgets/emailsent.vue";
import axios from 'axios';
import Loader from "../loader/loader.vue";
import smallLoader from "../loader/smallLoader.vue";
/**
 * Dashboard Component
 */
export default {
  components: { Layout, Transaction,Loader ,smallLoader },
  data() {
    return {
      title: "گزارشات",
      showModal: false,
      bank_balance:[],
      currency_count:0,
      finance_count:0,
      isLoading:false,
      allbalances:[],
      // pagination
      currentPage: 1,
      totalPages: 1,
      limit: 10,
    };
  },
   mounted() {
 
  },
  mounted() {
    this.getBanksBalance();
    this.getAllBalances();
  },
  methods:{
    async getBanksBalance(page = 1) {
            this.isLoading=true;
            try {
                const response = await axios.get(`/api/bankbalance?page=${page}&limit=${this.limit}`);
                this.bank_balance = response.data.bank_balance.data;
                this.totalPages = response.data.bank_balance.last_page;
                this.currency_count=response.data.currency_counts;
                this.finance_count=response.data.financeAcc_count;
                this.currentPage = page;
               
            } catch (error) {
                console.log(error.message);
            }finally{
              this.isLoading=false;
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.getBanksBalance(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getBanksBalance(this.currentPage + 1); // Update the page parameter
            }
        },
        gobankDesc(id){
            this.$router.push({ name: 'bankDetails', params: { id } });
        },

        async getAllBalances(){
              try {
                const response = await axios.get('/api/getallbalances');
                this.allbalances = response.data;
              } catch (error) {
                console.log(error.message);
              }
        }
  }
};
</script>

<template>
  <Layout>


    <div class="row">
      <div class="col-xl-12">
        <div class="row">
        <div class="col-md-4">
            <div class="card mini-stats-wid">
                <div class="card-body" style="min-height: 47vh;">
                  <div class="d-flex ">
                    <div class="flex-grow-1">
                      <p class="text-muted fw-medium">تعداد حسابات</p>
                      <h4 class="mb-0">{{finance_count}}</h4>
                    </div>
            
                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                      <span class="avatar-title">
                        <i class="bx bx-copy-alt font-size-24"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- end card-body -->
              </div>
        </div>
        <div class="col-md-4">
            <div class="card mini-stats-wid" style="min-height: 47vh;">
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex-grow-1">
                      <p class="text-muted fw-medium">تعداد واحدات پولی</p>
                      <h4 class="mb-0">{{currency_count}}</h4>
                    </div>
            
                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                      <span class="avatar-title">
                        <i class="bx bx-archive-in font-size-24"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- end card-body -->
              </div>
        </div>

        <div class="col-md-4">
            <div class="card " style="min-height: 47vh;">
                <!-- <div class="card-body"> -->
                  <div class="d-flex">
                    <div class="w-100">
                      <div v-if="isLoading">
                          <smallLoader />
                      </div>
                      <div class="card text-center" v-else>
                        <div class="card-body">
                          <h4 class="card-titl badge  font-size-20 text-center text-black-50">بیلانس</h4>
                          <div class="table-responsive mb-0">
                            <div>
                              <table class="table table-centered table-nowrap" style="width:100%">
                                <thead>
                                  <tr>
                                    <th>واحد</th>
                                    <th>کل رسید </th>
                                    <th>کل برداشتها</th>
                                    <th>بیلانس</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  
                                  <tr v-for="(item, index) in allbalances" :key="index">
                                    <td>{{ item.currency }}</td>
                                    <td><span class="badge  font-size-11" :class="item.rasid > 0 ? 'bg-success' : 'bg-danger'">{{ item.rasid }} </span></td>
                                    <td> <span class="badge font-size-11" :class="item.bord > 0 ? 'bg-success' : 'bg-danger'"> {{ item.bord }}</span></td>
                                    <td><span class="badge font-size-11" :class="item.balance > 0 ? 'bg-success': 'bg-danger'"> {{ item.balance }}</span></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            
                  </div>
                <!-- </div> -->
                <!-- end card-body -->
              </div>
        </div>
          <!-- end card -->
        </div>

      </div>
    </div>
    <!-- end row -->

 

    <div class="row">
      <div class="col-lg-12">
        <div class="card" style="min-height:100% !important">
          <div class="card-body">
            <h4 class="card-title mb-4">جدول بانک ها</h4>
            <!-- Transactions table -->
            <div v-if="isLoading">
              <Loader />
            </div>
            <div v-else>
              <div class="table-responsive mb-0">
                <table class="table table-centered table-nowrap align-middle">
                  <thead class="table-light">
                    <tr>
                    
                      <th class="align-middle">آیدی</th>
                      <th class="align-middle">نام حساب</th>
                      <th class="align-middle">واحدات پولی</th>
                      <th class="align-middle">تمام رسیدها</th>
                      <th class="align-middle">تمام بردها</th>
                      <th class="align-middle">بیلانس</th>
                      <th class="align-middle"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="bank in bank_balance" :key="bank.id">
                      <td>{{bank.id}}</td>
                      <td>{{bank.account_name}}</td>
                      <td>{{bank.currencyname}}</td>
                      <td> <span class="badge  font-size-13" :class="bank.total_rasid > 0 ? 'bg-success' : 'bg-warning' "> {{bank.total_rasid}}</span></td>
                      <td><span class="badge  font-size-13" :class="bank.total_bord > 0 ? 'bg-danger' :  'bg-warning' "> {{bank.total_bord}}</span></td>
                      <td style="direction:rtl !important">
                        <span class="badge  font-size-13" :class="bank.blance > 0 ? 'bg-success' : bank.blance === 0 ? 'bg-warning' : 'bg-danger'">
                          {{bank.blance}}
                        </span>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-primary btn-sm btn-rounded"
                          @click="gobankDesc(bank.id)"
                        >
                          دیدن جزئیات
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
               
              </div>
              <!-- end table -->
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
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </Layout>
</template>
