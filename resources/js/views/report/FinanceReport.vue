<script>
import Layout from "../../layouts/main.vue";
import Transaction from "../../components/widgets/transaction.vue";
import Emailsent from "../../components/widgets/emailsent.vue";
import axios from 'axios';
/**
 * Dashboard Component
 */
export default {
  components: { Layout, Transaction,  },
  data() {
    return {
      title: "گزارشات",
      showModal: false,
      bank_balance:[],
    };
  },
   mounted() {
    setTimeout(() => {
      this.showModal = true;
    }, 1500);
  },
  mounted() {
    this.getBanksBalance();
  },
  methods:{
    async getBanksBalance() {
            // console.log("getCustomerForEdit",id);
            try {
                const response = await axios.get('/api/bankbalance');
                this.bank_balance = response.data.bank_balance;
               console.log("get banks", this.bank_balance);
              
            } catch (error) {
                console.log(error.message);
            }
        },


        gobankDesc(id){
       
      this.$router.push({ name: 'bankDetails', params: { id } });
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
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex-grow-1">
                      <p class="text-muted fw-medium">تعداد حسابات</p>
                      <h4 class="mb-0">1,235</h4>
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
            <div class="card mini-stats-wid">
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex-grow-1">
                      <p class="text-muted fw-medium">تعداد واحدات پولی</p>
                      <h4 class="mb-0">5</h4>
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
            <div class="card mini-stats-wid">
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex-grow-1">
                      <p class="text-muted fw-medium">کل سرمایه</p>
                      <h4 class="mb-0">$1,235</h4>
                    </div>
            
                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                      <span class="avatar-title">
                        <i class="bx bx-purchase-tag-alt font-size-24"></i>
                      </span>
                    </div>
                  </div>
                </div>
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
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">جدول بانک ها</h4>
            <!-- Transactions table -->
            <div class="table-responsive mb-0">
                <table class="table table-centered table-nowrap align-middle">
                  <thead class="table-light">
                    <tr>
                    
                      <th class="align-middle">آیدی</th>
                      <th class="align-middle">نام حساب</th>
                      <th class="align-middle">واحد پولی</th>
                      <th class="align-middle">تمام رسیدها</th>
                      <th class="align-middle">تمام بردها</th>
                      <th class="align-middle">بیلانس</th>
                      <th class="align-middle"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="bank in bank_balance" :key="bank.id">
                  
                      <td>
                      
                        <a href="javascript: void(0);" class="text-body fw-bold">1</a>
                      </td>
                      <td>{{bank.account_name}}</td>
                      <td>{{bank.currencyname}}</td>
                      <td>{{bank.total_rasid}}</td>
                      <td>{{bank.total_bord}}</td>
                      <td>{{bank.blance}}</td>
                      
                     
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
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </Layout>
</template>
