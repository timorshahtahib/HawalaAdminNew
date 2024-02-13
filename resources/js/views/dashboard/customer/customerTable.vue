<template>
    <div class="col-sm-12">
        <div class="text-sm-end">
            <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="openModal">
                <i class="mdi mdi-plus me-1"></i>مشتری جدید
            </button>
            <b-modal v-model="showModal" title="اضافه کردن مشتری جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
                <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
}}</b-alert>
                <form @submit.prevent="storeCustomer" enctype="multipart/form-data">
                    <div class="row flex" style="justify-content: center;">
                        <div class="row flex justify-between">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="pr-2">نام کامل </label>
                                    <input id="name" v-model="name" type="text" class="form-control" placeholder="نام کامل خود را وارد کنید" @blur="phoneValidation('name')" required/>
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
                        <div class="row col-12">
                            <div class="mb-3">
                                <label for="address">آدرس</label>
                                <textarea v-model="address" id="address" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید" required></textarea>
                            </div>
                        </div>
                        <div class="row col-12">
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
<div class="col-sm-4 bg-red" style="
    margin-top: -52px;
">
    <div class="search-box me-2 mb-2 d-inline-block">
        <div class="position-relative">
            <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
            <i class="bx bx-search-alt search-icon"></i>
        </div>
    </div>
</div>
<!-- edit modal start -->
<div class="col-sm-8">
    <div class="text-sm-end">
        <b-modal v-model="editshowModal" title="ویرایش مشتری" title-class="text-black font-18" body-class="p-3" hide-footer>
            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
}}</b-alert>
            <form @submit.prevent="editSubmitCustomerForm" enctype="multipart/form-data">
                <div class="row flex " style="justify-content: center;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12">

                                <label for="editname">نام کامل</label>
                                <input id="editname" v-model="editname" type="text" class="form-control" placeholder="نام کامل خود را وارد کنید" required/>
                           
                        </div>

                    </div>
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label for="editImage">عکس</label>
                                <input type="file" ref="editImage" class="form-control" @change="editHandleFileChange" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label for="editPhone">شماره تماس</label>
                                <input type="text" v-model="editPhone" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 juste">
                        <div class=" mb-3">
                            <label for="editAddress">آدرس</label>
                            <textarea v-model="editAddress" id="editAddress" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید"></textarea>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="mb-1">
                            <label for="editDesc">توضیحات</label>
                            <textarea v-model="editDesc" id="editDesc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید"></textarea>
                        </div>
                    </div>
                </div>

                <div class=" text-end pt-5 mt-1 g-2 ml-5">
                    <b-button variant="danger" @click="editshowModal = false">بستن</b-button>
                    <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                </div>
            </form>
        </b-modal>
    </div>
</div>
<!-- edit modal end -->

    <div v-if="isLoading">
        <Loader/>
      </div>
      <div class="table-responsive" v-else>

        <table class="table table-centered table-nowrap">
            <thead>
                <tr>
                    <th>آیدی</th>
                    <th>نام کامل</th>
                    <th>شماره مسلسل مشتری</th>
                    <th>شماره تماس</th>
                    <th>توضیحات</th>
                    <th>پروفایل کاربر</th>
                    <th>وضیعت</th>
                    <th>اکشن</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="customer in customers" :key="customer.id" style="text-center">
                    <td>
                        {{ customer.id }}
                    </td>
                    <td>{{ customer.name }}</td>
                    <td>{{ customer.cu_number }}</td>
                    <td>{{ customer.phone }}</td>
                    <td>{{ customer.desc }}</td>
                    <td>
                        <router-link class="btn btn-xs btn-primary" :to="`/dashboard/customer/${customer.id}`">پروفایل</router-link>
                    </td>
                    <td>
                        <!-- <span class="badge bg-success font-size-12"> -->
                        <span class="badge  font-size-12" :class="customer.status === 0 ? 'bg-warning' :'bg-primary'">
                            <i class="mdi mdi-star me-1"></i>
                            {{ customer.status }}
                        </span>
                    </td>
    
                    <td>
                        <button class="btn btn-xs">
                            <i class="fas fa-pencil-alt text-success me-1" @click="editCustomer(customer.id)"></i>
                        </button>
    
                        <button class="btn btn-xs">
                            <i class="fas fa-trash-alt text-danger me-1" @click="deleteCustomer(customer.id)"></i>
    
                        </button>
                    </td>
    
                </tr>
            </tbody>
        </table>
        <div  class="text-center font-size-20" v-if="notFound">
            نتیجه مورد نظر یافت نشد!
        </div>
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
  


</template>

<script>
import Swal from 'sweetalert2'
import Loader from '../../loader/loader.vue';
import api from '../../../services/api';

export default {
    name: 'customerTable',
    data() {
        return {
            customers: [],
            searchQuery: null,
            isLoading: false,
            notFound: false,
            showModal: false,
            submitted: false,
            isError: false,
            formError: "",
            name: '',
            phoneError: '',
            phone: '',
            username: '',
            password: '',
            image: null,
            address: '',
            desc: '',
            errors: {},
            // edit modal
            editshowModal: false,
            editname: '',
            editUsername: '',
            editPassword: '',
            editPhone: '',
            editImage: null,
            editAddress: '',
            editDesc: '',
            editphoneError: '',
            // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,
        };
    },
    mounted() {
        this.getCustomers();
    },
    methods: {
        async getCustomers(page = 1) {
            this.isLoading = true;
            try {
               const response = await api.get(`/customer?page=${page}&limit=${this.limit}`);
                // const response = await api.get(`/customer`);
                this.customers = response.data.customers.data;
                this.totalPages = response.data.customers?.last_page;
                this.currentPage = page; // Update the current page
            }
            catch (error) {
                console.error('Error fetching customers:', error);
            }
            finally {
                this.isLoading = false;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getCustomers(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getCustomers(this.currentPage + 1); // Update the page parameter
            }
        },
        editHandleFileChange(event) {
            const img = event.target.files[0];
            this.editImage = img.name;
        },
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.name = '';
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
        openEditModal() {
            this.editshowModal = true;
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'بستن'
            });
        },
        async storeCustomer() {
         try {
            this.isLoading = true;
            this.submitted = true;
            if (this.name && this.phone && this.username && this.password) {
                const response = await api.post("/customer", {
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
                        }
                        else {
                            this.errors = response.data.error;
                        }
                    }
                    else {
                        this.errors = {};
                        this.name = '';
                        this.phone = '';
                        this.username = '';
                        this.password = '';
                        this.image = null;
                        this.address = '';
                        this.desc = '';
                        this.showModal = false;
                        this.customers.unshift(response.data.new_data);
                        this.showalert("مشتری با موفقیت ثبت شد!", 'موفقانه', 'success');
                        // location.reload();
                    }
                }
            }
            else {
                this.isError = true;
                this.formError = "فیلد ها خالی است";
            }
         } catch (error) {
            console.log(error.message);
         }finally {
                this.isLoading = false;
                console.log("isloading");
            }
            // stop here if form is invalid
        },
        async editCustomer(id) {
            const response = await api.get(`/customer/${id}`);
            this.editCust = response.data.customer;
            this.openEditModal();
            this.editname = this.editCust.name;
            this.editPhone = this.editCust.phone;
            this.editImage = this.editCust.image;
            this.editAddress = this.editCust.address;
            this.editDesc = this.editCust.desc;
            //    console.log("inside editcustomer ", this.editDesc);
        },
        async editSubmitCustomerForm() {
            // console.log("id",id);
            const responseUpdate = await api.post('/updatecustomer', {
                id: this.editCust.id,
                name: this.editname,
                phone: this.editPhone,
                image: this.editImage,
                address: this.editAddress,
                desc: this.editDesc,
            });
            if (responseUpdate.data != null) {
                // console.log("responseUpdate.data != null");
                if (responseUpdate.data.status === false) {
                    if (responseUpdate.data.message != null) {
                        this.showalert(responseUpdate.data.message, "بستن", "error");
                    }
                    else {
                        this.errors = responseUpdate.data.error;
                        this.showalert(this.errors, 'error', 'error');
                    }
                }
                else {
                    this.errors = {};
                    this.editname = '';
                    this.editPhone = null;
                    this.image = null;
                    this.editAddress = null;
                    this.editImage = null;
                    this.editshowModal = false;
                    this.getCustomers();
                    this.showalert("مشتری با موفقیت ویرایش شد!", 'موفقانه', 'success');
                }
            }
        },
        async deleteCustomer(id) {

            if (!window.confirm('آیا میخواهید که مشتری حذف شود؟')) {
                return;
            }
            else {
                
                try {
                    const response = await api.delete(`/customer/${id}`);
                    this.customers = response.data;
                    if (response.status === 204) {
                       
                        this.showalert('مشتری با موفقیت حذف شد!', 'موفقانه', 'success');
                      
                    }
                }
                catch (error) {
                    this.showalert('مشتری با موفقیت حذف نشد!', 'ناموفقانه', 'error');
                }finally {
                
                this.getCustomers();
            }
            }
        },
        async searchData() {
            try {
                const response = await api.post('/searchCustomer', {
                    query: this.searchQuery
                });
                this.customers = response.data;
                this.notFound = this.customers.length === 0;
                // console.log(this.notFound);
            }
            catch (error) {
                console.log(error.message);
            }
        },
        phoneValidation(field) {
            // console.log("phon3e validation");
            if (field === 'editPhone') {
                if (this.editPhone === '') {
                    this.editphoneError = 'شماره تماس ضروری است';
                }
                else if (this.editPhone.length < 10) {
                    this.editphoneError = 'شماره تماس باید حداقل 10 کاراکتر باشد.';
                    this.telephoneCheck(this.editPhone);
                }
                else {
                    this.editphoneError = null;
                }
            }
        },
        telephoneCheck(str) {
            let isphone = /^(1\s|1|)?((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{4})$/.test(str);
            if (!isphone) {
                this.editphoneError = 'لطفا شماره تماس وارد نمائید!';
            }
            else {
                this.editphoneError = null;
            }
        }
    },
   
}
</script>
