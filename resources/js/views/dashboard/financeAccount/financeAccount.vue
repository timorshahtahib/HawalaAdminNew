<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import axios from 'axios';
// import SweetAlert from '../../../SweetAlert.vue';
import Swal from 'sweetalert2'
import financeAccountTable from "./financeAccountTable.vue";
export default {
    components: {
        Layout,
        PageHeader,
        financeAccountTable
    },
    data() {
        return {
            financeAccounts: [],
            currencies: [],
            title: "لیست حسابات",
            items: [{
                    text: "داشبورد",
                    href: "/"
                },
                {
                    text: "حسابات",
                    active: true
                }
            ],
            showModal: false,
            submitted: false,
            isError: false,
            formError: "",

            account_name: '',
            accountnameError: null,
            type: '',
            typeError:null,
            currency: '',
            description: '',
            user_id: '',
            AccountType:'',
            errors: {},

          
        };
    },
    mounted() {
        this.getFinanceAccounts();

    },
    methods: {

        openModal() {
            this.showModal = true;
            this.getcurrencies();
            this.type='asset'
            this.AccountType="bank"
        },
      
        showalert(title,text,icon) {
            Swal.fire({
                title:title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },

      
        async getFinanceAccounts() {
            try {
                await axios.get('/api/finance_account', {
                        params: {
                            limit: this.limit,
                            offset: this.offset,
                        },
                    }).then((response) => {
                        this.financeAccounts = response.data.financeAccounts;
                        this.total_pages = response.data.total_pages;
                    })
                    .catch((error) => {
                        console.error('Error fetching customers:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        async getcurrencies() {
            try {
                await axios.get('/api/currencies').then((response) => {
                        this.currencies = response.data.currencies;
                        console.log('tag', response.data.currencies)
                        this.currency=this.currencies[0].id
                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        /**
         * Modal form submit
         */
        // eslint-disable-next-line no-unused-vars
        async submitForm() {
            try {
                const response = await axios.post('/api/finance_account', {
                    account_name: this.account_name,
                    type: this.type,
                    currency: this.currency,
                    description: this.description,
                    // user_id: this.user_id,
                    user_id: this.user_id,
                    status: this.status,
                    account:this.AccountType
                });
               
                if (response.data != null) {
                  console.log('response.data != null')
                  if (response.data.status === false) {
                    if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "1توجه!");
                            console.log('response.data.message != null')
                        } else {
                            this.errors = response.data.error;
                            console.log("Errors", this.errors);
                            console.log("status false");
                          
                        }

                  }else{
                    // console.log('  this.financeAccounts.push(response.data.new_data)')
                    this.financeAccounts.push(response.data.new_data);
                    this.account_name = '';
                    this.type = '';
                    this.currency = '';
                    this.description = '';
                    this.user_id = '';
                    this.status = '';
                    this.showModal = false;
                    this.showalert("حساب جدید","حساب موفقانه اضافه شد","success");
                    
                  }
                   

                }

            } catch (error) {
                console.error(error.message);
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
                    
                        <!-- edit modal start -->
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <b-modal v-model="showModal" title="ویرایش مشتری" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
        }}</b-alert>
                                    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
                                        <div class="row flex justify-between">
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    {{ editCust }}
                                                    <div class="mb-3">
                                                        <label for="editname">نام</label>
                                                        <input id="editname" v-model="editname" type="text" class="form-control" placeholder="نام خود را وارد کنید" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editLastName">نام خانواگی</label>
                                                        <input id="editLastName" v-model="editLastName" type="text" class="form-control" placeholder="نام خانوادگی خود را وارکنید" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editUsername">نام کاربری</label>
                                                        <input id="editUsername" v-model="editUsername" type="text" class="form-control" placeholder="نام کاربری خود را وارد کنید" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editPassword">رمز عبور</label>
                                                        <input id="editPassword" v-model="editPassword" type="editPassword" class="form-control" placeholder="رمز عبور خود را وارد کنید" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editImage">عکس</label>
                                                        <input type="file" ref="editImage" class="form-control" @change="onChange" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="editPhone">شماره تماس</label>
                                                        <input type="text" v-model="editPhone" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="editAddress">آدرس</label>
                                                    <textarea v-model="editAddress" id="editAddress" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label for="editDesc">توضیحات</label>
                                                    <textarea v-model="editDesc" id="editDesc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید"></textarea>
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
                        <!-- edit modal end -->

                        <div class="col-sm-12">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="openModal">
                                    <i class="mdi mdi-plus me-1"></i>حساب جدید
                                </button>
                                <b-modal v-model="showModal" title="اضافه کردن حساب جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                    }}</b-alert>
                                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                                        <div class="row flex justify-between">
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-control-label px-3">نام حساب<span class="text-danger">*</span></label>
                                                        <input id="acount_name" v-model="account_name" placeholder="نام حساب..." type="text" class="form-control"  required/>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                      <label class="form-control-label px-3">نوعیت حساب<span class="text-danger">*</span></label>
                                                      <select v-model="type" class="form-control form-control-lg" >
                                                        <option value="asset">Assets</option>
                                                        <option value="equity">equity</option>
                                                        <option value="liablity">liablity</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                      <label class="form-control-label px-3">پول<span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-lg select2 required" v-model="currency" style="width: 100%;" required>
                                                          <option disabled selected> واحد</option>
                                                          <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="row flex justify-between">
                                              <div class="col-md-6 col-sm-12 col-lg-6">
                                                  <div class="mb-3">
                                                    <label class="form-control-label px-3">حسابات<span class="text-danger">*</span></label>
                                                      <select class="form-control form-control-lg select2 required" v-model="AccountType" style="width: 100%;" required>
                                                        <option value="bank">بانک</option>
                                                        <option value="income">درآمد</option>
                                                        <option value="expense">مصرف</option>
                                                    </select>
                                                  </div>
                                              </div>
                                          </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label for="desc">توضیحات</label>
                                                    <textarea v-model="description" id="desc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید" ></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end pt-5 mt-1 g-2">
                                            <b-button variant="danger" @click="showModal=false">بستن</b-button>
                                            <b-button type="submit" variant="success" class="ms-1 ml-2">ساختن</b-button>
                                        </div>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <financeAccountTable />
                    <!-- <ul class="pagination pagination-rounded justify-content-end mb-2">
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
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
