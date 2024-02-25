<script>
import profileImg from '../../../images/profile-img.png';
import logo from '../../../images/mycustom/Asiatelecomlogo.png';
import axios from 'axios';

/**
 * Login component
 */
export default {
  data() {
    return {
      showAlert:false,
      email: '',
      password: '',
      emailError:null,
      passwordError:null,
      profileImg, logo,
      processing: false,
      authError:null,
     
    }
  },
  beforeCreate() {
    
    if(localStorage.getItem('user')) {
      this.$router.push('/');
    }
  },

  methods: {

      
       

        async login() {
          this.processing = true;

  try {
    const response = await axios.post('/api/login', {
      email: this.email,
      password: this.password
    });

    if (response.data.status === true && response.data.access_token) {
      const token = response.data.access_token;
      const user_name = response.data.user_name;

      // Store user data including token
      localStorage.setItem('user', JSON.stringify({
        token: token,
        username:user_name
      }));

      // Set the token in the axios defaults for future requests
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

      // Redirect to the desired route after successful login
      this.$router.push('/home');
    } else {
      // Handle authentication errors
      this.authError = response.data.error || "Authentication failed.";
    }
  } catch (error) {
    if (error.response && error.response.status === 401) {
      console.error('Unauthorized. Logging out user.');
      // Clear user data and redirect to login page
      localStorage.removeItem('user');
      delete axios.defaults.headers.common['Authorization'];
      this.$router.push('/login'); // Redirect to the login page
    }else if(error.response && error.response.status === 401){
      console.error('خطا در شبکه رخ داده است', error);
      this.authError = 'خطا در شبکه رخ داده است';
    } 
    else {
      console.error('خطا در زمان ورود', error);
      this.authError = "لطفا دوباره تلاش کنید.";
    }

  } finally {
    this.processing = false;
  }
}
  }
  }
</script>

<template>
  <div class="account-pages my-5 pt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card overflow-hidden">
            <div class="bg-soft bg-primary">
              <div class="row">
                <div class="col-12">
                  <div class=" p-4 text-center">
                    <h5 class="">به پنل مدیریت حواله خوش آمدید</h5>
                  </div>
                </div>
               
              </div>
            </div>
            <div class="card-body pt-0">
              <div>
                <router-link to="/">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img :src="logo" alt height="80" />
                    </span>
                  </div>
                </router-link>
              </div>
   

              <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="authError">
                <strong> {{ authError }}</strong> 
              </div>

              <form class="p-2" action="javascript:void(0)" method="POST" @submit.prevent="login">
            
                <div class="form-group mt-2">                
                  <label id="email-group" >ایمیل</label>
                  <input v-model="email" type="email" placeholder="example@gmail.com" class="form-control" required>
                  <p class="pt-2 text-danger " v-if="emailError">{{emailError[0]}}</p>
              </div>

                <div class="form-group mb-3">                
                  <label id="password" >رمز عبور</label>
                  <input type="password" v-model="password"   placeholder="رمز عبور..." class="form-control" required>
                  <p class="pt-2 text-danger " v-if="passwordError">{{passwordError[0]}}</p>
              </div>

                <b-form-checkbox id="customControlInline" name="checkbox-1" value="accepted"
                  unchecked-value="not_accepted">
                  مرا بخاطر بسپار!
                </b-form-checkbox>
                <div class="mt-3 d-grid">
                  <button type="submit" :disabled="processing"  class="btn btn-primary btn-block">
                    {{ processing ? "لطفا صبر نمائید..." : "ورود" }}
                  </button>
                </div>

              </form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->

          <div class="mt-5 text-center">
            <p>
              آیا حساب ندارید؟
              <router-link to="/register" class="fw-medium text-primary">حالا ثبت نام نمائید</router-link>
            </p>
            <p>
              © {{ new Date().getFullYear() }}
              <i class="mdi mdi-heart text-danger"></i> by Asia Telecom
            </p>
          </div>
          <!-- end row -->
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
  </div>
</template>

