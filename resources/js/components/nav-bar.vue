<script>
import simplebar from "simplebar-vue";


import logoDarkLg from "../../images/logo-dark.png";

import asialogo from "../../images/mycustom/Asiatelecomlogo.png";
// import asialogo from '../../images/logo-light.svg';

import avatar1 from "../../images/users/avatar-2.jpg";



// import megamenu from "../../images/megamenu-img.png";

/**
 * Nav-bar Component
 */
export default {
  data() {
    return {
      username: "",
      logoDarkLg,
      asialogo,
      avatar1,
  
  
    };
  },

  components: { simplebar },
  mounted() {


    if (localStorage.getItem("user")) {
      this.username = JSON.parse(localStorage.getItem("user")).username;
      // console.log("this.username",this.username);
    }
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push({ name: "login" });
    },
    toggleMenu() {
      this.$parent.toggleMenu();
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
    },
  
  },
};
</script>

<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box mb-2">
          <router-link to="/" class="logo logo-dark">
            <span class="logo-sm">
              <img :src="logoDarkLg" alt height="s" />
            </span>
            <span class="logo-lg">
              <img :src="logoDarkLg" alt height="17" />
            </span>
          </router-link>

          <router-link to="/home" class="logo logo-light">
            <span class="logo-sm">
              <img :src="asialogo" alt height="22" />
            </span>
            <span class="logo-lg text-white">
              <!-- Asia admin panel -->
              <img :src="asialogo" alt height="140" class="mt-5" />
            </span>
          </router-link>
        </div>

        <button
          id="vertical-menu-btn"
          type="button"
          class="btn btn-sm px-3 font-size-16 header-item"
          @click="toggleMenu"
        >
          <i class="fa fa-fw fa-bars"></i>
        </button>

        <!-- App Search-->
        <form class="app-search d-none d-lg-block">
          <div class="position-relative">
            <input
              type="text"
              class="form-control"
              :placeholder="$t('navbar.search.text')"
            />
            <span class="bx bx-search-alt"></span>
          </div>
        </form>

        <b-dropdown
          variant="black"
          class="dropdown-mega d-none d-lg-block ms-2"
          toggle-class="header-item"
          menu-class="dropdown-megamenu dropdown-menu-end"
        >
          <template v-slot:button-content>
            {{ $t("navbar.dropdown.megamenu.text") }}
            <i class="mdi mdi-chevron-down"></i>
          </template>

          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <div class="col-md-4">
                  <h5 class="font-size-14 mt-0">
                    {{ $t("navbar.dropdown.megamenu.uicontent.title") }}
                  </h5>
                  <ul class="list-unstyled megamenu-list">
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.lightbox")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.rangeslider")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.sweetalert")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.rating")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.forms")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.tables")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.charts")
                      }}</a>
                    </li>
                  </ul>
                </div>

                <div class="col-md-4">
                  <h5 class="font-size-14 mt-0">
                    {{ $t("navbar.dropdown.megamenu.application.title") }}
                  </h5>
                  <ul class="list-unstyled megamenu-list">
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.ecommerce")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.calendar")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.email")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.projects")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.tasks")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.application.list.contacts")
                      }}</a>
                    </li>
                  </ul>
                </div>

                <div class="col-md-4">
                  <h5 class="font-size-14 mt-0">
                    {{ $t("navbar.dropdown.megamenu.extrapages.title") }}
                  </h5>
                  <ul class="list-unstyled megamenu-list">
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.lightsidebar")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.compactsidebar")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.horizontallayout")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.maintenance")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.comingsoon")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.timeline")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.extrapages.list.faqs")
                      }}</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="font-size-14 mt-0">
                    {{ $t("navbar.dropdown.megamenu.uicontent.title") }}
                  </h5>
                  <ul class="list-unstyled megamenu-list">
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.lightbox")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.rangeslider")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.sweetalert")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.rating")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.forms")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.tables")
                      }}</a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">{{
                        $t("navbar.dropdown.megamenu.uicontent.list.charts")
                      }}</a>
                    </li>
                  </ul>
                </div>

                <div class="col-sm-5">
                  <div>
                    <img :src="megamenu" alt class="img-fluid mx-auto d-block" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </b-dropdown>
      </div>

      <div class="d-flex">
        <b-dropdown
          class="d-inline-block d-lg-none ms-2"
          variant="black"
          menu-class="dropdown-menu-lg p-0"
          toggle-class="header-item noti-icon"
          right
        >
          <template v-slot:button-content>
            <i class="mdi mdi-magnify"></i>
          </template>

          <form class="p-3">
            <div class="form-group m-0">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search ..."
                  aria-label="Recipient's username"
                />
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="mdi mdi-magnify"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </b-dropdown>

        <b-dropdown
          right
          variant="black"
          toggle-class="header-item"
          menu-class="dropdown-menu-end"
        >
          <template v-slot:button-content>
            <img
              class="rounded-circle header-profile-user"
              :src="avatar1"
              alt="Header Avatar"
            />
            <!-- <span class="d-none d-xl-inline-block ms-1">{{ username }}</span> -->
            <span class="d-none d-xl-inline-block ms-1">Ahmad</span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
          </template>

          <b-dropdown-divider></b-dropdown-divider>
          <a
            href="javascript:void(0)"
            @click="logout()"
            class="dropdown-item text-danger"
          >
            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
            {{ $t("navbar.dropdown.henry.list.logout") }}
          </a>
        </b-dropdown>

        <div class="dropdown d-inline-block">
          <button
            type="button"
            class="btn header-item noti-icon right-bar-toggle toggle-right"
            @click="toggleRightSidebar"
          >
            <i class="bx bx-cog bx-spin toggle-right"></i>
          </button>
        </div>
      </div>
    </div>
  </header>
</template>
