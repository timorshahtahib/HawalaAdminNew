<script>
import errorImg from '../../../images/error-img.png';

export default {
  data() {
    return {
      errorImg
    }
  }
}
</script>
<template>
  <div class="account-pages my-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center mb-5">
            <h1 class="display-2 fw-medium">
              4<i class="bx bx-buoy bx-spin text-primary display-3"></i>4
            </h1>
            <h4 class="text-uppercase">Sorry, page not found</h4>
            <div class="mt-5 text-center">
              <router-link class="btn btn-primary" to="/">Back to Dashboard</router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
          <div>
            <img :src="errorImg" alt class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

