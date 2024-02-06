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
      auth: {
        email: "",
        password: ""
      },
      profileImg, logo,
      processing: false,
      authError: null,
      isAuthError: false,      
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
        const response = await axios.post('/api/login', this.auth);

        // Assuming your API response structure matches the provided one
        if (response.data.status) {
                const logged_user = {
                   status:response.data.status,
                    token: response.data.access_token
                };

              localStorage.setItem('user', JSON.stringify(logged_user.token));
              this.$router.push('/');
        } else {
          this.authError = response.data.message;
           this.isAuthError = true;
          
        }
      } catch (error) {
        console.error('Error during login:', error);
          this.authError = 'An error occurred during login.';
          this.isAuthError = true;
      }finally {
    this.processing = false;
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

              <b-alert v-model="isAuthError" variant="danger" class="mt-3" dismissible>{{ authError }}</b-alert>

              <b-form class="p-2" action="javascript:void(0)" method="POST">
                <slot />
                <b-form-group id="input-group-1" label="ایمل آدرس" label-for="input-1" class="mb-3">
                  <b-form-input id="input-1" name="email" v-model="auth.email" type="text"
                    placeholder="Enter email"></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-2" label="رمز عبور" label-for="input-2" class="mb-3">
                  <b-form-input id="input-2" v-model="auth.password" name="password" type="password"
                  placeholder="رمز عبور خود را وارد نمائید"></b-form-input>
                </b-form-group>
                <b-form-checkbox id="customControlInline" name="checkbox-1" value="accepted"
                  unchecked-value="not_accepted">
                  مرا بخاطر بسپار!
                </b-form-checkbox>
                <div class="mt-3 d-grid">
                  <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                    {{ processing ? "لطفا صبر نمائید..." : "ورود" }}
                  </button>
                </div>
           
                <div class="mt-4 text-center">
                  <router-link to="/forget-password" class="text-muted">
                    <i class="mdi mdi-lock mr-1"></i> رمز عبور خود را فراموش کرده اید؟
                  </router-link>
                </div>
              </b-form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->

          <div class="mt-5 text-center">
            <p>
              آیا حساب ندارید؟
              <router-link to="/auth/register" class="fw-medium text-primary">حالا ثبت نام نمائید</router-link>
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

