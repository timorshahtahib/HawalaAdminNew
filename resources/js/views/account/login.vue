<script>
import profileImg from '../../../images/profile-img.png';
import logo from '../../../images/logo.svg';
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
      this.processing = true
      await axios.post('/api/login', this.auth).then(({ data }) => {
        if (data.success == true && data.message == 'success') {
          const logged_user = {
            login: true,
            user_id: data.data.id,
            name: data.data.name,
            email: data.data.email,
          }
          localStorage.setItem('user', JSON.stringify(logged_user));
          this.$router.push('/');
        } else {
          if(data.data == 400) {
            this.authError = data.message;
            this.isAuthError = true;
          }
        }
      }).catch(({response:{data}}) => {
        console.log(data)
      }).finally(() => {
        this.processing = false
      })
    },
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
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p>Sign in to continue to Skote.</p>
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
                      <img :src="logo" alt height="34" />
                    </span>
                  </div>
                </router-link>
              </div>

              <b-alert v-model="isAuthError" variant="danger" class="mt-3" dismissible>{{ authError }}</b-alert>

              <b-form class="p-2" action="javascript:void(0)" method="POST">
                <slot />
                <b-form-group id="input-group-1" label="Email" label-for="input-1" class="mb-3">
                  <b-form-input id="input-1" name="email" v-model="auth.email" type="text"
                    placeholder="Enter email"></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-2" label="Password" label-for="input-2" class="mb-3">
                  <b-form-input id="input-2" v-model="auth.password" name="password" type="password"
                    placeholder="Enter password"></b-form-input>
                </b-form-group>
                <b-form-checkbox id="customControlInline" name="checkbox-1" value="accepted"
                  unchecked-value="not_accepted">
                  Remember me
                </b-form-checkbox>
                <div class="mt-3 d-grid">
                  <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                    {{ processing ? "Please wait" : "Login" }}
                  </button>
                </div>
                <div class="mt-4 text-center">
                  <h5 class="font-size-14 mb-3">Sign in with</h5>

                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);" class="social-list-item bg-primary text-white border-primary">
                        <i class="mdi mdi-facebook"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);" class="social-list-item bg-info text-white border-info">
                        <i class="mdi mdi-twitter"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);" class="social-list-item bg-danger text-white border-danger">
                        <i class="mdi mdi-google"></i>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="mt-4 text-center">
                  <router-link to="/forget-password" class="text-muted">
                    <i class="mdi mdi-lock mr-1"></i> Forgot your password?
                  </router-link>
                </div>
              </b-form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->

          <div class="mt-5 text-center">
            <p>
              Don't have an account ?
              <router-link to="/auth/register" class="fw-medium text-primary">Signup now</router-link>
            </p>
            <p>
              © {{ new Date().getFullYear() }} Skote. Crafted with
              <i class="mdi mdi-heart text-danger"></i> by Themesbrand
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

