<template>
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

<div class="table-responsive" v-if="customers.length">

    <table class="table table-centered table-nowrap">
        <thead>
            <tr>
                <th scope="col">آیدی</th>
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
                    {{ customer.id }}
                </td>
                <td>{{ customer.name }}</td>
                <td>
                    <p class="mb-1">{{ customer.last_name }}</p>
                </td>
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
<div v-else class="text-center font-size-20">
    نتیجه مورد نظر یافت نشد!
</div>
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
            notFoundMessage: '',
            // edit modal
            editname: '',
            editLastName: '',
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

        }
    },
    mounted() {
        this.getCustomers();
    },

    methods: {

        async getCustomers(page = 1) {
            try {
                const response = await axios.get(`/api/customer?page=${page}&limit=${this.limit}`);
                this.customers = response.data.customers.data;
                this.totalPages = response.data.customers?.last_page;
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching customers:', error);
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
            this.editCust = response.data.customer;
            this.openEditModal();
            // console.log("editCustomer", this.editCust);
            this.editname = this.editCust.name;
            this.editLastName = this.editCust.last_name;
            this.editPhone = this.editCust.phone;
            // this.editUsername = this.editCust.username;
            // this.editPassword = this.editCust.password;
            this.ediPhoto = this.editCust.image;
            this.editAddress = this.editCust.address;
            this.editDesc = this.editCust.desc;

            //    console.log("inside editcustomer ", this.editDesc);
        },
        async editCustomerForm(id) {
            const responseUpdate = await axios.put(`/api/customer/${id}`, {
                name: this.editname,
                last_name: this.editLastName,
                phone: this.editPhone,
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
           try {
            const response = await axios.post('/api/searchCustomer', {
                    query: this.searchQuery
                });

                this.customers = response.data;
           } catch (error) {
                console.log(error.message);
           }
        },

        phoneValidation(field) {
            console.log("phon3e validation");
            if (field === 'editPhone') {
                if (this.editPhone === '') {
                    this.editphoneError = 'شماره تماس ضروری است';
                } else if (this.editPhone.length < 10) {
                    this.editphoneError = 'شماره تماس باید حداقل 10 کاراکتر باشد.';
                    this.telephoneCheck(this.editPhone);
                } else {
                    this.editphoneError = null;
                }
            }

        },
        telephoneCheck(str) {
            let isphone = /^(1\s|1|)?((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{4})$/.test(str);
            if (!isphone) {
                this.editphoneError = 'لطفا شماره تماس وارد نمائید!';
            } else {
                this.editphoneError = null;
            }
        }
    },
}
</script>
