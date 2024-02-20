<script>
  import Layout from "../../layouts/main.vue";
  import PageHeader from "../../components/page-header.vue";
  import Loader from '../../views/loader/loader.vue'
  import api from '../../services/api';
  import Swal from 'sweetalert2'



  /**
   * customer-Profile component
   */
  
  export default {
    components: {
      Layout,
      PageHeader,
      Loader
    },
    data() {
      return {
        title: "مدیریت کاربران",
        items: [{
          text: "صفحه اصلی",
          href: "/"
        }, {
          text: "مدیریت کاربران",
          active: true
        }],
        showModal: false,
        showeditModal: false,
        isLoading: false,
        notFound: false,
        searchQuery:'',
        
        users:[],
        user:'',
  
        name: '',
        email: '',
        password: '',
        role:'',
        processing: false,
        regError:null,
        nameError:null,
        emailError:null,
        passwordError:null,
        roleError:null,
        errors:{},

        // for edit user
        editName: '',
        editEmail: '',

        editRole:'',
        editProcessing: false,
        editError:null,
        editNameError:null,
        editEmailError:null,
        editroleError:null,
        editerrors:{},

        currentPage: 1,
        totalPages: 1,
        limit: 10,

      };
    },
    mounted() {
        this.getUser();
    },
 
    methods: {
      async getUser(page=1) {
        this.isLoading=true;
           try {
            const response = await api.get(`/user?page=${page}&limit=${this.limit}`);
            this.users = response.data.users.data;
            this.totalPages = response.data.users.last_page;
            this.currentPage = page; // Update the current page
          
           } catch (error) {
            console.log(error.message);
           }finally{
            this.isLoading=false;
           }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getUser(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getUser(this.currentPage + 1); // Update the page parameter
            }
        },
        openModal() {
            this.showModal = true;
        },
        openEditModal() {
            this.showeditModal = true;
           
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'بستن'
            });
        },

        async register(){
        try {
                this.processing = true;
                const response = await api.post('/register', {
                    name:this.name,
                    email:this.email,
                    password:this.password,
                    role:this.role
                });

                if (response.data != null) {
                    if (response.data.status === false) {
                        if (response.data.message != null) {
                            this.errors = response.data.error;
                            this.nameError = this.errors.name;
                            this.emailError = this.errors.email;
                            this.passwordError = this.errors.password;
                            this.roleError = this.errors.role;
                        }
                       
                    }
                    else {
                        this.errors = {};
                        this.name = '';
                        this.email = '';
                        this.role = '';
                        
                        this.showModal = false;
                        this.users.unshift(response.data.new_user);
                        this.showalert("کاربر با موفقیت ثبت شد!", '', 'success');
                    }
                }
 
         } catch (error) {
            console.log(error.message);
         }finally{
        this.processing = false
      }
   
},
        async updateUser(id){
            try {
                this.editProcessing=true;
                const response = await api.get(`/user/${id}`);  
                this.user = response.data;
                this.openEditModal();
                this.editName  = this.user.name;
                this.editEmail  = this.user.email;
                this.editRole  = this.user.role;
                // console.log("role",this.user);
            } catch (error) {
                console.log(error.message);
            }

        
        },

   
        async submitUpdateUser(id) {
      
            console.log("editRole",this.editRole);
            try {
                const response = await api.post('/updateuser', {
                    id:this.user.id,
                    name:this.editName,
                    email:this.editEmail,
                    role:this.editRole
                });
                    
                if (response.data != null) {
                    console.log('response.data != null')
                    if (response.data.status === false) {
                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "error");
                        } else {
                            this.errors = response.data.error;
                            console.log("Errors", this.errors);
                            console.log("status false");
                        }

                    } else {
  
                        this.editerrors = {};
                        this.editName = '';
                        this.editEmail = '';
                        this.editrole = '';
                        this.showeditModal = false;
                        this.getUser();
                        this.showalert("حساب با موفقبت ویرایش شد", "", "success");
                    }

                }
            } catch (error) {
                console.log(error);
                this.showalert('حساب با موفقیت ویرایش نشد!', "", "error");
            }
            
            

        },
        async deleteUser(id) {
            if (!window.confirm('آیا میخواهید که حساب حذف شود؟')) {
                return;
            } else {
                try {
                    console.log("inside try");
                    const response = await api.post('/deleteuser',{id:id});
                    this.financeAccounts = response.data;
                    if (response.status === 204) {
                        this.showalert('حساب با موفقیت حذف شد!', 'موفقانه', 'success');
                        this.getUser();
                    }

                } catch (error) {
                    // console.log("inside catch");
                    this.showalert('حساب با موفقیت حذف نشد!', 'ناموفقانه', 'error');
                }
            }
        },

        async searchData() {
            // const response = await api.post('/searchUser', {
            //     query: this.searchQuery
            // });
            // // this.users = response.data.users.data;
            // this.users = response.data;
            // console.log(this.searchQuery);
            // // this.totalPages = response.data.users.last_page;
            // // this.currentPage = page;

            console.log("search");
        },
    },
  };
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        
  
<!-- edit modal start -->
<div class="col-sm-8">
  <div class="text-sm-end">
      <b-modal v-model="showeditModal" title="ویرایش کاربر" title-class="text-black font-18" body-class="p-3" hide-footer>

<form   @submit.prevent="submitUpdateUser">
    <slot />
    <div class="form-group mb-3">                
      <label id="email-group" label="" label-for="name">نام</label>
      <input type="text" id="editName" class="form-control" v-model="editName"   placeholder="نام..."   >
      <p class="pt-2 text-danger" v-if="editNameError">{{editNameError[0]}}</p>
     
  </div>

    <div class="form-group mt-2">                
      <label id="email-group" label-for="ایمیل">ایمیل</label>
      <input v-model="editEmail" type="email" placeholder="example@gmail.com" class="form-control" >
      <p class="pt-2 text-danger " v-if="editEmailError">{{editEmailError[0]}}</p>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="mb-3">
            <label for="editRo">تعین صلاحیت</label>
            <select class="form-control form-control-lg  " v-model="editRole" >
                <option value="" disabled>انتخاب سطح دسترسی</option>
                <option value="customer">مشتری</option>
                <option value="user">یوزر</option>
                <option value="superadmin">سوپرادمین</option>
                <option value="admin">ادمین</option>
              </select>
          
        </div>
    </div>
</div>
    <div class="text-end pt-5 mt-1 g-2">
      <b-button type="submit" :disabled="processing"  variant="primary" class="btn-block m-2">
        <!-- {{ editProcessing ? "لطفا منتظر باشید..." : "آپدیت" }} -->
         آپدیت 
      </b-button>
      <b-button variant="danger" @click="showeditModal = false">بستن</b-button>
    </div>


  </form>
      </b-modal>
  </div>
</div>
<!-- edit modal end -->


<!-- add new user -->
      <div class="col-xl-12">
          <div class="card">

              <div class="card-body">
              
                      <div class="row">
                          <div class="col-md-10">
                              <div class="search-box me-2 mb-2 d-inline-block">
      
                                  <div class="position-relative">
                                 
                                      <input type="text" v-model="searchQuery" class="form-control" placeholder="جستجوی کاربر..." @input="searchData" />
                                      <i class="bx bx-search-alt search-icon"></i>
                                  </div>
                              </div>
                            
                          </div>
                          <div class="col-md-2 flex space-around">
                            <div class="col-sm-12">
                              <div class="text-sm-end">
                                  <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="openModal">
                                      <i class="mdi mdi-plus me-1"></i>کاربر جدید
                                  </button>

                                  <b-modal v-model="showModal" title="اضافه کردن کاربر جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
                         
               <div class="alert text-center text-black font-bold alert-danger" role="alert" v-if="regError">
               <span>{{ regError }}</span>
              </div>
                    <form   @submit.prevent="register">
                        <slot />
                        <div class="form-group mb-3">                
                          <label id="email-group" label="" label-for="name">نام</label>
                          <input type="text" id="name" class="form-control" v-model="name"   placeholder="نام..."   >
                          <p class="pt-2 text-danger" v-if="errors.name"> {{ nameError[0] }}</p>
                         
                      </div>
          
                        <div class="form-group mt-2">                
                          <label id="email-group" label-for="ایمیل">ایمیل</label>
                          <input v-model="email" type="email" placeholder="example@gmail.com" class="form-control" >
                          <p class="pt-2 text-danger" v-if="errors.email"> {{ emailError[0] }}</p>
                        
                      </div>
                        <div class="form-group mb-3">                
                          <label id="password" >رمز عبور</label>
                          <input type="password" v-model="password"   placeholder="رمز عبور..." class="form-control" >
                          <p class="pt-2 text-danger" v-if="errors.password"> {{ passwordError[0] }}</p>
                      </div>
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="mb-3">
                                <label for="role">تعین صلاحیت</label>
                                  <select class="form-control form-control-lg  " v-model="role" >
                                    <option value="" disabled>انتخاب سطح دسترسی</option>
                                    <option value="customer">مشتری</option>
                                    <option value="superadmin">سوپرادمین</option>
                                    <option value="admin">ادمین</option>
                                  </select>
                                  <p class="pt-2 text-danger" v-if="errors.role"> {{ roleError[0] }}</p>

                            </div>
                           
                        </div>
                    </div>
                        <div class="text-end pt-5 mt-1 g-2">
                          <b-button type="submit" :disabled="processing"  variant="primary" class="btn-block m-2">
                            {{ processing ? "لطفا منتظر باشید..." : "ثبت نام" }}
                          </b-button>
                          <b-button variant="danger" @click="showModal = false">بستن</b-button>
                        </div>
                   
           
                      </form>
                                  </b-modal>
                              </div>
                          </div>
                          </div>
                      </div>
               
                  <div class="row">
                      <div class="col-sm-12 ">
                          <div v-if="isLoading">
                              <Loader />
                            </div>
                        <div v-else>
                          <div class="table-responsive " v-if="users?.length" >
                              <table class="table table-centered table-nowrap text-start">
                                  <thead>
                                      <tr>
                                          <th class="text-center">آیدی</th>
                                          <th class="text-center">نام</th>
                                          <th class="text-center">ایمیل</th>
                                          <th class="text-center">وضیعت</th>
                                          <th class="text-center">سطح دسترسی</th>
                                          <th class="text-center">اکشن</th>
                                      </tr>
                                  </thead>
                                  <tbody class="text-center">
                                      <tr v-for="user in users" :key="user?.id">
                                    
                                        <td>{{user.id}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.status}}</td>
                                        <td>
                                            <span class="badge font-size-14 font-bold p-1" :class="user.role === 'superadmin' ? 'bg-success' : 
                                            user.role==='admin'? 'bg-primary' : user.role === 'user' ? 'bg-secondary' : 'bg-warning' ">{{user.role}}</span>
                                        </td>
                                        <td>
                                          <button class="btn btn-xs">
                                              <i class="fas fa-pencil-alt text-success me-1" @click="updateUser(user.id)"></i>
                                          </button>
                      
                                          <button class="btn btn-xs">
                                              <i class="fas fa-trash-alt text-danger me-1" @click="deleteUser(user.id)"></i>
                      
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
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- end col -->
  </div>
  </Layout>
</template>