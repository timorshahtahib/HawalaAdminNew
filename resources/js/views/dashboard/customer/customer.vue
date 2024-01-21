<template>
<Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                   
                        <div class="col-sm-12">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="openModal">
                                    <i class="mdi mdi-plus me-1"></i>مشتری جدید
                                </button>
                                <b-modal v-model="showModal" title="اضافه کردن مشتری جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                    }}</b-alert>
                                    <form @submit.prevent="storeCustomer" enctype="multipart/form-data">
                                        <div class="row flex justify-between">
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="name">نام</label>
                                                        <input id="name" v-model="name" type="text" class="form-control" placeholder="نام خود را وارد کنید" @blur="phoneValidation('name')" required/>
                                                    </div>
                                                    <!-- <span class="text-danger error-text afrad_error" v-if="nameError">{{errors.name}}</span> -->
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="last_name">نام خانواگی</label>
                                                        <input id="lastName" v-model="last_name" type="text" class="form-control" placeholder="نام خانوادگی خود را وارکنید" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="username">نام کاربری</label>
                                                        <input id="username" v-model="username" type="text" class="form-control" placeholder="نام کاربری خود را وارد کنید" required/>
                                                        <span class="text-danger error-text afrad_error" v-if="errors.username">{{errors.username[0]}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="password">رمز عبور</label>
                                                        <input id="password" v-model="password" type="password" class="form-control" placeholder="رمز خود را وارکنید" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="image">عکس</label>
                                                        <input type="file" ref="image" class="form-control" @change="handleFileChange" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="phone">شماره تماس</label>
                                                        <input type="text" v-model="phone" class="form-control" required @blur="phoneValidation('phone')"/>
                                                        <span class="text-danger error-text afrad_error" v-if="errors.phone">{{errors.phone[0]}}</span>
                                                     
                                                        <span class="text-danger error-text afrad_error" v-if="this.phoneError">{{this.phoneError}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address">آدرس</label>
                                                    <textarea v-model="address" id="address" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label for="desc">توضیحات</label>
                                                    <textarea v-model="desc" id="desc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید"></textarea>
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
                        </div>
                        <!-- end col-->
                    </div>
                        <customerTable />
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import customerTable from './customerTable.vue'
import axios from 'axios';
import Swal from 'sweetalert2'
/**
 * Customers component
 */
export default {
    components: {
        Layout,
        PageHeader,
        customerTable
    },
    data() {
        return {
            // customers: [],
            
            title: "لیست مشتریان",
            items: [{
                    text: "مشتری",
                    href: "/"
                },
                {
                    text: "مشتری",
                    active: true
                }
            ],
            showModal: false,
            submitted: false,
            isError: false,
            formError: "",

            name: '',
            phoneError:'',
            last_name: '',
            phone: '',
            username: '',
            password: '',
            image: null,
            address: '',
            desc: '',
            errors: {},
        };
    },
 
    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal(){
            this.showModal=false;
            this.name = '';
            this.last_name = '';
            this.phone = '';
            this.username = '';
            this.password = '';
            this.image = null;
            this.address = '';
            this.desc = '';
        },
        handleFileChange(event) {
            const img = event.target.files[0];
            this.image = img.name;
            // console.log('Selected file:', this.image);
        },
   
        showalert(title,text,icon) {
            Swal.fire({
                title:title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },


        async storeCustomer() {
            this.submitted = true;
            if (this.name && this.last_name && this.phone && this.username && this.password) {

                const response = await axios.post("/api/customer", {
                    name: this.name,
                    last_name: this.last_name,
                    phone: this.phone,
                    username: this.username,
                    password: this.password,
                    image: this.image,
                    address: this.address,
                    desc: this.desc,
                });
        
                if (response.data != null) {
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            // console.log(response.data.message, "error", "error!");
                            this.showalert(response.data.message, "error", "error!");
                        } else {
                            this.errors = response.data.error;

                        }
                    } else {

                        this.errors = {};
                        this.name = '';
                        this.last_name = '';
                        this.phone = '';
                        this.username = '';
                        this.password = '';
                        this.image = null;
                        this.address = '';
                        this.desc = '';
                        this.showModal = false;
                        this.showalert("مشتری با موفقیت ثبت شد!", 'success', 'success');
                        // location.reload();
                       
                      
                    }

                }

        
            } else {
                this.isError = true;
                this.formError = "فیلد ها خالی است";
            }
            // stop here if form is invalid

        },
  
        phoneValidation(field) {
         if (field === 'phone') {
                if (this.phone === '') {
                    this.phoneError = 'شماره تماس ضروری است';
                } else if (this.phone.length < 10) {
                    this.phoneError = 'شماره تماس باید حداقل 10 کاراکتر باشد.';
                    this.telephoneCheck(this.phone);
                } else {
                    this.phoneError = null;
                }
            }

        },
        telephoneCheck(str) {
            let isphone = /^(1\s|1|)?((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{4})$/.test(str);
            if (!isphone) {
                this.phoneError = 'لطفا شماره  تماس عددی وارد نمائید!';
            } else {
                this.phoneError = null;
            }
        }
      
    },
};
</script>