<script>
import VueEasyLightbox from "vue-easy-lightbox";

import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

import img1 from "../../../images/small/img-1.jpg";
import img2 from "../../../images/small/img-2.jpg";
import img3 from "../../../images/small/img-3.jpg";
import img4 from "../../../images/small/img-4.jpg";
import img5 from "../../../images/small/img-5.jpg";
import img6 from "../../../images/small/img-6.jpg";
import img7 from "../../../images/small/img-7.jpg";

/**
 * Lightbox component
 */
export default {
  components: { VueEasyLightbox, Layout, PageHeader },
  data() {
    return {
      img1, img2, img3, img4, img5, img6, img7,
      title: "Lightbox",
      items: [
        {
          text: "UI Elements",
          href: "/"
        },
        {
          text: "Lightbox",
          active: true
        }
      ],
      isOpen: false,
      visible: false,
      singleImage: false,
      visibleCaption: false,
      index: 0, // default: 0
      imgs: [
        img1,
        img2,
        img3,
        img4,
        img5,
        img6
      ],
      captionimgs: [
        { src: img3, title: "Caption 1" },
        { src: img7, title: "Caption 2" }
      ]
    };
  },
  methods: {
    showImg(index) {
      this.index = index;
      this.visible = true;
    },
    handleHide() {
      this.visible = false;
    },
    showCaptiomImg(index) {
      this.index = index;
      this.visibleCaption = true;
    },
    handleCaptionHide() {
      this.visibleCaption = false;
    }
  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Single image lightbox</h4>
            <p class="card-title-desc">Example of image popup.</p>
            <div class="popup-gallery">
              <img :src="img1" width="120" @click="singleImage = true" />
              <vue-easy-lightbox :visible="singleImage" :imgs="img1"
                @hide="singleImage = false"></vue-easy-lightbox>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Lightbox gallery</h4>
            <p class="card-title-desc">In this example lazy-loading of images is enabled for the next image based on move
              direction.</p>
            <div class="popup-gallery d-flex flex-wrap">
              <div v-for="(src, index) in imgs" :key="index" class="float-left" @click="() => showImg(index)">
                <img :src="src" width="120" />
              </div>
              <vue-easy-lightbox :visible="visible" :imgs="imgs" :index="index" @hide="handleHide"></vue-easy-lightbox>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Caption</h4>
            <p class="card-title-desc">Show caption with popup.</p>
            <div class="popup-gallery d-flex flex-wrap">
              <div v-for="(src, index) in captionimgs" :key="index" class="float-left"
                @click="() => showCaptiomImg(index)">
                <img :src="src.src" width="275" />
              </div>
              <vue-easy-lightbox :visible="visibleCaption" :imgs="captionimgs" :index="index"
                @hide="handleCaptionHide"></vue-easy-lightbox>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Popup with form</h4>
            <div>
              <a class="popup-form btn btn-primary" href="javascript: void(0);" @click="isOpen = true">Popup form</a>

              <b-modal v-model="isOpen" id="modal-1" title="Form" hide-footer size="lg" centered>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter Name" />
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter Email" />
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="password">Password</label>
                          <input type="text" class="form-control" id="password" placeholder="Enter Password" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="mb-3">
                          <label for="subject">Subject</label>
                          <textarea class="form-control" id="subject" rows="3"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-end">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </b-modal>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
