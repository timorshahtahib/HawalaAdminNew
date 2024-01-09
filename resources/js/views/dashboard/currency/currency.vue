<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import currencyTable from './currencyTable.vue'
import axios from 'axios';
import Swal from 'sweetalert2'

/**
 * Customers component
 */
export default {
  components: { Layout, PageHeader,currencyTable },
  data() {
    return {
        currencies: [],
      title: "لیست واحدات پولی",
      items: [
        {
          text: "داشبورد",
          href: "/"
        },
        {
          text: "واحد پولی",
          active: true
        }
      ],
      showModal: false,
      submitted: false,
      isError: false,
      formError: "",
    
    currencyName: "",
    currencyNameError: "",
    currencySign: "",
    currencySignError: "",
    errors: {},

    // edit modal
  
    };
  },
  mounted() {
  
    },
  methods: {
    showalert(title,text,icon) {
            Swal.fire({
                title:title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },
   
  
    /**
     * Modal form submit
     */
    // eslint-disable-next-line no-unused-vars
    async handleSubmit(e) {
      this.submitted = true;

      if (this.currencyName && this.currencySign ) {

        const response = await axios.post('/api/currencies', {  name: this.currencyName,sign: this.currencySign });
            // console.log("submit method ",response);
            if (response.data != null) {
                if (response.data.status === false) {

                    if (response.data.message != null) {
                        console.log(response.data.message, "error", "error!");
                        // this.showalert(response.data.message, "error", "error!");
                    } else {
                        this.errors = response.data.error;

                    }
                  }else{
                    this.errors = {};
                    this.currencyName = null;
                    this.currencySign = null;
                    this.showModal = false;
                  
                    this.showalert( "واحد پولی با موفقیت ثبت شد!",'success','success');
                    // console.log("مشتری با موفقیت ثبت شد!",'success','ok');
                }
             
            }

        this.showModal = false;
       
      } else {
        this.isError = true;
        this.formError = "اطلاعات را وارد کنید";
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
            <div class="row mb-2">
           
     <!-- start modal col-->
              <div class="col-sm-12">
                <div class="text-sm-end">
                  <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="showModal = true">
                    <i class="mdi mdi-plus me-1"></i>واحد جدید
                  </button>
                  <b-modal v-model="showModal" title="اضافه کردن واحد پولی جدید" title-class="text-black font-18" body-class="p-3"
                    hide-footer>
                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                    }}</b-alert>
                    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
                      <div class="row flex justify-between">
                            <div class="row flex justify-between">
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <div class="mb-3">
                                      <label class="form-control-label px-3">نام واحد پولی<span class="text-danger">*</span></label>
                                      <input type="text" id="currencyName" v-model="currencyName" placeholder="نام واحد پولی..." class="form-control"  />
                                      <p v-if="currencyNameError" class="text-danger">{{ currencyNameError }}</p>
                                      <span class="text-danger error-text afrad_error" v-if="errors.name">{{errors.name[0]}}</span>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                      <label class="form-control-label px-3">نشان</label>
                                      <input type="text" id="currencySign" v-model="currencySign" placeholder="نشان..." class="form-control" >
                                      <p v-if="currencySignError" class="text-danger">{{ currencySign }}</p>
                                      <span class="text-danger error-text afrad_error" v-if="errors.sign">{{errors.sign[0]}}</span>
                                    </div>
                                  </div>
                            </div>
                            
                        
                      </div>

                      <div class="text-end pt-5 mt-1 g-2">
                          <b-button variant="danger" @click="showModal = false">بستن</b-button>
                          <b-button type="submit" variant="success" class="ms-1 ml-2">ساختن</b-button>
                      </div>
                    </form>
                  </b-modal>
                </div>
              </div>
              <!-- end modal col-->
            </div>
                <currencyTable />
          
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
