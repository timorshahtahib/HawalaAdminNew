<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import orderTable from './orderTable.vue'
import axios from 'axios';

/**
 * Customers component
 */
export default {
  components: { Layout, PageHeader,orderTable },
  data() {
    return {
       
      title: "لیست سفارشات",
      items: [
        {
          text: "داشبورد",
          href: "/"
        },
        {
          text: "سفارش",
          active: true
        }
      ],
    //   showModal: false,
    //   submitted: false,
    //   isError: false,
    //   formError: "",

    //   orderState:'',
    //   phone_number: '',
    //   phoneError: null,
    //   qtt: '',
    //   qttError: null,
    // errors: {},

    };
  },
 
  methods: {
   
       
    /**
     * Modal form submit
     */
    // eslint-disable-next-line no-unused-vars

    // closeModal(){
    //   this.showModal=false;
    // },
    // async handleSubmit(e) {
    //   this.submitted = true;
    //     const response = await axios.post("/api/orders",{ phone_number: this.phone_number, qtt: this.qtt,state:this.orderState});

    //     console.log(response);
     
    // },
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
            <div class="row mb-2">
              <div class="col-sm-4">
                <div class="search-box me-2 mb-2 d-inline-block">
                  <div class="position-relative">
                    <input type="text" class="form-control" placeholder="جستجوی سفارش..." />
                    <i class="bx bx-search-alt search-icon"></i>
                  </div>
                </div>
              </div>




              <!-- <div class="col-sm-12">
                <div class="text-sm-end">
                  <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="showModal = true">
                    <i class="mdi mdi-plus me-1"></i>سفارش جدید
                  </button>
                  <b-modal v-model="showModal" title="اضافه کردن سفارش جدید" title-class="text-black font-18" body-class="p-3"
                    hide-footer>
                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                    }}</b-alert>
                    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
                      <div class="row flex justify-between">
                            <div class="row flex justify-between">
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <div class="mb-3">
                                      <label class="form-control-label px-3">وضیعت</label>
                                      <select name="orderState" class="form-control">
                                        <option value="done">انجام شده</option>
                                        <option value="pending">در حال انتظار</option>
                                        <option value="rejected">رد شده</option>
                                    </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                      <label class="form-control-label px-3">شماره تماس</label>
                                        <input type="text" id="phone_number" v-model="phone_number" placeholder="شماره تماس..." class="form-control" 
                                        @keyup="orderValidation('phone_number')" required />
                                        <p v-if="phoneError" class="text-danger">{{ phoneError }}</p>
                                    </div>
                                  </div>
                            </div>
                                <div class="row flex justify-between">
                                    <div class="col-md-6 col-sm-12 col-lg-6">
                                        <div class="mb-3">
                                          <label class="form-control-label px-3">کیو تی تی</label>
                                          <input type="text" id="qtt" v-model="qtt" class="form-control" placeholder="کیو تی تی.." @blur="orderValidation" required />
                                          <p v-if="qttError" class="text-danger">{{ qttError }}</p>
                                        </div>
                                      </div>
                                    
                                </div>
                      
                      </div>

                      <div class="text-end pt-5 mt-1 g-2">
                          <b-button variant="danger" @click="closeModal">بستن</b-button>
                          <b-button type="submit" variant="success" class="ms-1 ml-2">ساختن</b-button>
                      </div>
                    </form>
                  </b-modal>
                </div>
              </div> -->
              <!-- end col-->
            </div>
              <orderTable />
          
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
