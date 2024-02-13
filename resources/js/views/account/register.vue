<script>

import profileImg from '../../../images/profile-img.png';
import logo from '../../../images/mycustom/Asiatelecomlogo.png';
import axios from 'axios';
import Swal from 'sweetalert2';
/**
 * Register component
 */
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      profileImg, logo,
      processing: false,
      regError:'',
      regSuccess:'',
      nameError:null,
      emailError:null,
      passwordError:null,
    };
  },
  methods: {
    showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'بستن'
            })
        },

 async register(){
  this.processing = true
      try {
        if(this.name || this.email || this.password ){
        const response = await axios.post('/api/register', {
            name:this.name,
            email:this.email,
            password:this.password
         });
  
         if(response.data.status===true){
          this.showalert("ثبت نام با موفقیت انجام شد", 'موفقانه', 'success');
          this.$router.push('/login');
         }else{
  
          // this.showalert(response.data.error, 'خطا', 'error');
          this.nameError=response.data.error.name;
          this.emailError=response.data.error.email;
          this.passwordError=response.data.error.password;
          // console.log("response",response.data.error);
         }
       }
      } catch (error) {
        console.log(error.message);
      }finally{
        this.processing = false
      }
}

  }
};
</script>

<template>
  <div class="account-pages my-5 pt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card overflow-hidden">
            <div class="bg-soft bg-primary">
              <div class="row">
                <div class="col-7">
                  <div class="text-primary p-4">
                    <h5 class="text-primary">به صفحه ثبت نام خوش آمدید</h5>
                   
                  </div>
                </div>
                <div class="col-5 align-self-end">
                  <img :src="profileImg" alt class="img-fluid" />
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div>
                <router-link to="/">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img :src="logo" alt class="rounded-circle" height="66" />
                    </span>
                  </div>
                </router-link>
              </div>
              <div class="alert text-center text-black font-bold alert-danger" role="alert" v-if="regError">
               <span v-if="regError">{{ regError }}</span>
              </div>

              <form  action="javascript:void(0)" method="POST" @submit.prevent="register">
                <slot />
                <div class="form-group mb-3">                
                  <label id="email-group" label="" label-for="name">نام</label>
                  <input type="text" id="name" class="form-control" v-model="name"   placeholder="نام..."   required>
                  <p class="pt-2 text-danger " v-if="nameError">{{nameError[0]}}</p>
              </div>
  
                <div class="form-group mt-2">                
                  <label id="email-group" label-for="ایمیل">ایمیل</label>
                  <input v-model="email" type="email" placeholder="example@gmail.com" class="form-control" required>
                  <p class="pt-2 text-danger " v-if="emailError">{{emailError[0]}}</p>
              </div>
                <div class="form-group mb-3">                
                  <label id="password" >رمز عبور</label>
                  <input type="password" v-model="password"   placeholder="رمز عبور..." class="form-control" required>
                  <p class="pt-2 text-danger " v-if="passwordError">{{passwordError[0]}}</p>
              </div>

                <!-- <div class="form-group mb-3">                
                  <label id="password" >تائید رمز عبور</label>
                  <input type="password" v-model="password_confirmation"   placeholder="تائید رمز عبور..." class="form-control" required>
              </div> -->
                <div class="mt-4 d-grid">
                  <b-button type="submit" :disabled="processing"  variant="primary" class="btn-block">
                    {{ processing ? "لطفا منتظر باشید..." : "ثبت نام" }}
                  </b-button>
                </div>
           
   
              </form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->
    
          <div class="mt-5 text-center">
            <p>
              از قبل حساب دارید؟
              <router-link to="/login" class="fw-medium text-primary text-bold">ورود</router-link>
              
            </p>
            <p>
              © {{ new Date().getFullYear() }}
              <i class="mdi mdi-heart text-danger"></i> by Asia Telecom
            </p>
          </div>
        </div>
        <!-- end col -->
      </div>
    </div>
  </div>
</template>

<style lang="scss" module></style>
