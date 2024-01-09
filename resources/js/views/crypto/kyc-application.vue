<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

import { FormWizard, TabContent } from "@anivive/vue3-form-wizard";
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

import img1 from '../../../images/verification-img.png';

import vueDropzone from "vue3-dropzone";

export default {
  methods: {
    onComplete: function () {
      this.$refs.iswizard.reset();
    },
  },
  components: {
    Layout,
    PageHeader,
    FormWizard,
    TabContent,
    vueDropzone,
  },
  data() {
    return {
      title: "KYC Application",
      items: [
        {
          text: "Crypto",
          href: "javascript:void(0)",
        },
        {
          text: "KYC Application",
          active: true,
        },
      ],
      showModal: false,
      img1,
      dropzoneOptions: {
        url: "https://httpbin.org/post",
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        headers: {
          "My-Awesome-Header": "header value",
        },
      },
    };
  },
};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row justify-content-center mt-lg-5">
      <div class="col-xl-5 col-sm-8">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <div class="row justify-content-center">
                <div class="col-lg-10">
                  <h4 class="mt-4 fw-semibold">KYC Verification</h4>
                  <p class="text-muted mt-3">
                    Itaque earum rerum hic tenetur a sapiente delectus ut aut
                    reiciendis perferendis asperiores repellat.
                  </p>
                  <div class="mt-4">
                    <!-- Button trigger modal -->
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="showModal = true"
                    >
                      Click here for Verification
                    </button>
                  </div>
                </div>
                <div class="row justify-content-center mt-5 mb-2">
                  <div class="col-sm-6 col-8">
                    <div>
                      <img
                        :src="img1"
                        alt
                        class="img-fluid"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-modal
      v-model="showModal"
      size="lg"
      centered
      title="Verify your Account"
      hide-footer
    >
      <form-wizard
        shape="tab"
        color="#556ee6"
        ref="iswizard"
        @on-complete="onComplete"
      >
        <tab-content
          icon="mdi mdi-account-circle"
          title="Personal Info"
          class="kyc-wizard"
        >
          <form>
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="kycfirstname-input">First name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kycfirstname-input"
                    placeholder="Enter First name"
                  />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="kyclastname-input">Last name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kyclastname-input"
                    placeholder="Enter Last name"
                  />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="kycphoneno-input">Phone</label>
                  <input
                    type="text"
                    class="form-control"
                    id="kycphoneno-input"
                    placeholder="Enter Phone number"
                  />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label for="kycbirthdate-input">Date of birth</label>
                  <input
                    type="date"
                    class="form-control"
                    id="kycbirthdate-input"
                    placeholder="Enter Date of birth"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label for="kycselectcity-input" class="form-label"
                    >City</label
                  >
                  <select class="form-select" id="kycselectcity-input">
                    <option value="SF" selected>San Francisco</option>
                    <option value="LA">Los Angeles</option>
                    <option value="SD">San Diego</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </tab-content>
        <tab-content
          icon="mdi mdi-email"
          title="Confirm Email"
          class="kyc-wizard"
        >
          <form>
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label for="kycemail-input">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="kycemail-input"
                    placeholder="Enter Email Address"
                  />
                </div>

                <div class="mb-3">
                  <label for="kycconfirmcode-input">Confirm code</label>
                  <input
                    type="email"
                    class="form-control"
                    id="kycconfirmcode-input"
                    placeholder="Enter Confirm code"
                  />
                </div>

                <div class="mb-3">
                  Didn't recieve code ?
                  <button type="button" class="btn btn-link">
                    Resend Code
                  </button>
                </div>
              </div>
            </div>
          </form>
        </tab-content>
        <b-button variant="success" class="float-end" type="submit">Submit</b-button>
      </form-wizard>
    </b-modal>
  </Layout>
  
</template>
