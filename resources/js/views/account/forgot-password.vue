<script>
import profileImg from '../../../images/profile-img.png';
import logo from '../../../images/logo.svg';
import axios from 'axios';
/**
 * Forgot Password component
 */
export default {
    data() {
        return {
            email: "",
            error: "",
            status: "",
            isResetError: false,
            tryingToReset: false,
            processing: false,
            profileImg, logo
        };
    },
    mounted() {
        this.isResetError = !!this.error;
        this.tryingToReset = !!this.status;
    },
    methods: {
        async forget() {
            this.processing = true
            await axios.post('/api/forget-password', 
            {email:this.email}
            )
            .then(({ data }) => {
                if (data.success == true && data.message == 'success') {
                    this.status = "Password reset link send in your email.";
                    this.tryingToReset = true;
                } else {
                    if (data.data == 400) {
                        this.error = data.message;
                        this.isResetError = true;
                    }
                }
            }).catch(({ response: { data } }) => {
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
                                        <h5 class="text-primary">Reset Password</h5>
                                        <p>Re-Password with Skote.</p>
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
                            <div class="p-2">
                                <b-alert v-model="isResetError" class="mb-4" variant="danger" dismissible>{{ error
                                }}</b-alert>
                                <b-alert v-model="tryingToReset" class="mb-4" variant="success" dismissible>{{ status
                                }}</b-alert>
                                <form action="javascript:void(0)" method="POST">
                                    <slot />
                                    <div class="mb-3">
                                        <label for="useremail">Email</label>
                                        <input type="email" name="email" v-model="email" class="form-control" id="useremail"
                                            placeholder="Enter email" />
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-end">
                                            <b-button type="submit" :disabled="processing" @click="forget()"
                                                variant="primary" class="btn-block">
                                                {{ processing ? "Please wait" : "Forget Password" }}
                                            </b-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-5 text-center">
                        <p>
                            Remember It ?
                            <router-link to="/login" class="fw-medium text-primary">Sign In here</router-link>
                        </p>
                        <p>
                            © {{ new Date().getFullYear() }} Skote. Crafted with
                            <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
</template>
