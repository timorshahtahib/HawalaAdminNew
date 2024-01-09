<template>
    <div class="col-sm-4 bg-red" style="
    margin-top: -52px;
">
        <div class="search-box me-2 mb-2 d-inline-block">
            <div class="position-relative">
                <input type="text" class="form-control" v-model="searchQuery" 
                placeholder="جستجوی مشتری..." @input="searchData"/>
                <i class="bx bx-search-alt search-icon"></i>
            </div>
        </div>
    </div>
<!-- edit modal start -->
<div class="col-sm-8">
    <div class="text-sm-end">
        <b-modal v-model="showModal" title="ویرایش مشتری" title-class="text-black font-18" body-class="p-3" hide-footer>
            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
}}</b-alert>
            <form @submit.prevent="editCustomerForm(editCust.id)" enctype="multipart/form-data">
                <div class="row flex justify-between">
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">

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
                                <label for="editImage">عکس</label>
                                <input type="file" ref="editImage" class="form-control" @change="editHandleFileChange" />
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
                    <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                </div>
            </form>
        </b-modal>
    </div>
</div>
<!-- edit modal end -->

<div class="table-responsive">
  
    <table class="table table-centered table-nowrap" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">نام خانواگی</th>
                <th scope="col">شماره مسلسل مشتری</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">توضیحات</th>
                <th scope="col">پروفایل کاربر</th>
                <th scope="col">وضیعت</th>
                <th scope="col">اکشن</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="customer in customers" :key="customer.id" style="text-center">
                <td>
                    <div class="form-check font-size-16">
                        <input :id="`customCheck${customer.id}`" type="checkbox" class="form-check-input" />
                        <label class="form-check-label" :for="`customCheck${customer.id}`">&nbsp;</label>
                    </div>
                </td>
                <td>{{ customer.name }}</td>
            <td>
              <p class="mb-1">{{ customer.last_name }}</p>
            </td>
            <td>{{ customer.cu_number }}</td>
            <td>{{ customer.phone }}</td>
            <td>{{ customer.desc }}</td>
             <td>
                <router-link  class="btn btn-xs btn-primary" :to="`/dashboard/customer/${customer.id}`">پروفایل</router-link>
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


<ul class="pagination pagination-rounded justify-content-end mb-2">
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
</ul>
</div>
<!-- <div class="text-center font-size-20">
    نتیجه مورد نظر یافت نشد!
  </div> -->
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'
export default {
    name: 'customerTable',
    data() {
        return {
            showModal: false,
            customers: [],
            searchQuery: null,
            // edit modal
            editname: '',
            editLastName: '',
            editUsername: '',
            editPassword: '',
            editPhone: '',
            editImage: null,
            editAddress: '',
            editDesc: '',
        }
    },
    mounted() {
        this.getCustomers();
    },

    methods: {

        async getCustomers() {
            try {
                await axios.get('/api/customer', {
                        params: {
                            limit: this.limit,
                            offset: this.offset,
                        },
                    }).then((response) => {
                        this.customers = response.data.customers;
                        this.total_pages = response.data.total_pages;
                        //    console.log("customers response",response.data);
                    })
                    .catch((error) => {
                        console.error('Error fetching customers:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        editHandleFileChange(event) {
            const img = event.target.files[0];
            this.editImage = img.name;

        },
        openEditModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },
        async editCustomer(id) {
            const response = await axios.get(`/api/customer/${id}`);
            this.editCust = response.data;
            this.openEditModal(this.editCust);
            //    console.log("editCustomer",this.editCust);
            this.editname = this.editCust.name;
            this.editLastName = this.editCust.last_name;
            this.editPhone = this.editCust.phone;
            this.editUsername = this.editCust.username;
            this.editPassword = this.editCust.password;
            this.ediPhoto = this.editCust.image;
            this.editAddress = this.editCust.address;
            this.editDesc = this.editCust.desc;
            editUsername

            //    console.log("inside editcustomer ", this.editDesc);
        },
        async editCustomerForm(id) {
            const responseUpdate = await axios.put(`/api/customer/${id}`, {
                name: this.editname,
                last_name: this.editLastName,
                phone: this.editPhone,
                // username: this.editUsername,
                // password: this.editPassword,
                image: this.ediPhoto,
                address: this.editAddress,
                desc: this.editDesc,
            });
            // console.log(this.responseUpdate);
            if (responseUpdate.data != null) {
                if (responseUpdate.data.status === false) {
                    if (responseUpdate.data.message != null) {
                        this.showalert(responseUpdate.data.message, "error", "error");
                    } else {
                        this.errors = responseUpdate.data.error;

                    }
                } else {
                    this.errors = {};
                    this.name = null;
                    this.last_name = null;
                    this.phone = null;
                    this.username = null;
                    this.password = null;
                    this.image = null;
                    this.address = null;
                    this.desc = null;
                    this.showModal = false;
                    // console.log(response.code);
                    this.showalert("مشتری با موفقیت ویرایش شد!", 'success', 'success');
                }
                // console.log("Customer updated successfully");   
            } else {
                this.errors = {};
                this.closeModal();
                this.customers.push(response.data.new_data);
                this.showalert(responseUpdate.data.message, "success", "success");
            }

            this.showModal = false;
            this.getCustomers();
          

        },
        async deleteCustomer(id) {
            if (!window.confirm('آیا میخواهید که مشتری حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await axios.delete(`/api/customer/${id}`);
                    this.customers = response.data;
                    if (response.status === 204) {
                        this.showalert('مشتری با موفقیت حذف شد!', 'ادامه دهید', 'success');
                        this.getCustomers();
                    }

                } catch (error) {
                    this.showalert('مشتری با موفقیت حذف نشد!', 'ادامه دهید', 'error');
                }
            }
        },

        async searchData() {
            const response = await axios.post('/api/searchCustomer', {
                query: this.searchQuery
            });
           
            if(response.data.length){
                this.customers = response.data;
            }
        },
        customerValidation(field) {
            if (field === 'name') {
                if (this.name === '') {
                    this.nameError = 'نام ضروری است';
                } else if (this.name.length < 4) {
                    this.nameError = 'نام باید حداقل 4 کاراکتر باشد.';
                } else {
                    this.nameError = null;
                }
            } else if (field === 'last_name') {
                if (this.last_name === '') {
                    this.lastNameError = 'نام فامیلی ضروری است';
                } else if (this.last_name.length < 4) {
                    this.lastNameError = 'نام فامیلی باید حداقل 4 کاراکتر باشد.';
                } else {
                    this.lastNameError = null;
                }
            } else if (field === 'username') {
                if (this.username === '') {
                    this.usernameError = 'نام کاربری ضروری است';
                } else if (this.username.length < 4) {
                    this.usernameError = 'نام کاربری باید حداقل 4 کاراکتر باشد.';
                } else {
                    this.usernameError = null;
                }
            } else if (field === 'password') {
                if (this.password === '') {
                    this.passwordError = 'رمز عبور ضروری است';
                } else if (this.password.length < 8) {
                    this.passwordError = 'رمز عبور باید حداقل 8 کاراکتر باشد.';
                } else {
                    this.passwordError = null;
                }
            } else if (field === 'phone') {
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
                this.phoneError = 'لطفا شماره تماس وارد نمائید!';
            } else {
                this.phoneError = null;
            }
        }
    },
}
</script>
