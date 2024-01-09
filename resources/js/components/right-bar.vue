<script>
import simplebar from 'simplebar-vue';

import layout1 from '../../images/layouts/layout-1.jpg';
import layout2 from '../../images/layouts/layout-2.jpg';
import layout3 from '../../images/layouts/layout-3.jpg';


/**
 * Right sidebar component
 */
export default {
    components: { simplebar },
    data() {
        return {
            layout1, layout2, layout3,
            config: {
                handler: this.handleRightBarClick,
                middleware: this.middleware,
                events: ["click"]
            },
            layoutType: this.$root.layout.type,
            width: this.$root.layout.width,
            sidebarType: this.$root.layout.sidebar,
            topbar: this.$root.layout.topbar,
            loader: this.$root.layout.loader
        };
    },
    methods: {
        hide() {
            this.$parent.toggleRightSidebar();
        },
        // eslint-disable-next-line no-unused-vars
        handleRightBarClick(e, el) {
            this.$parent.hideRightSidebar();
        },
        // eslint-disable-next-line no-unused-vars
        middleware(event, el) {
            return !event.target.classList.contains("toggle-right");
        },
        changeLayout(layout) {
            if (layout == "horizontal") {
                this.topbar = "dark";
                this.$root.changeLayout({ type: layout, topbar: "dark" });

            } else {
                this.sidebarType = "dark";
                this.$root.changeLayout({ type: layout, sidebar: "dark", topbar: "light" });
            }

            this.$root.loadRightCollapse();
        },
        changeType(type) {
            this.$root.changeSidebar(type);
            return this.$root.changeLayout({ sidebar: type });
        },
        changeLayoutMode(mode) {
            this.$root.changeMode(mode);
            return this.$root.changeLayout({ mode: mode });
        },
        changeLayoutWidth(width) {
            this.$root.changeWidth(width);
            return this.$root.changeLayout({ width: width });
        },
        changeTopbartype(value) {
            this.$root.changeTopbar(value);
            return this.$root.changeLayout({ topbar: value });
        },
        changeloader(loader) {
            return this.$root.changeLayout({ loader: loader });
        }
    },
};
</script>

<template>
    <div>
        <div v-click-outside="config" class="right-bar">
            <simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end" @click="hide">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>
                <div class="p-3">
                    <h6 class="mb-0">Layout</h6>
                    <hr class="mt-1" />

                    <b-form-radio class="mb-2" v-model="layoutType" name="layoutSelect" value="vertical"
                        @input="changeLayout($event)">Vertical</b-form-radio>
                    <b-form-radio class="mb-2" v-model="layoutType" name="layoutSelect" value="horizontal"
                        @input="changeLayout($event)">Horizontal</b-form-radio>

                    <!-- Width -->
                    <h6 class="mt-3">Width</h6>
                    <hr class="mt-1" />

                    <b-form-radio class="mb-2" v-model="width" name="widthSelect" value="fluid"
                        @input="changeLayoutWidth($event)">Fluid</b-form-radio>
                    <b-form-radio class="mb-2" v-model="width" name="widthSelect" value="boxed"
                        @input="changeLayoutWidth($event)">Boxed</b-form-radio>

                    <!-- Sidebar -->
                    <div v-if="layoutType === 'vertical'">
                        <h6 class="mt-3">Sidebar</h6>

                        <hr class="mt-1" />
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="dark"
                            @input="changeType($event)">Dark</b-form-radio>
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="light"
                            @input="changeType($event)">Light</b-form-radio>
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="compact"
                            @input="changeType($event)">Compact</b-form-radio>
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="icon"
                            @input="changeType($event)">Icon</b-form-radio>
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="colored"
                            @input="changeType($event)">Colored</b-form-radio>
                        <b-form-radio class="mb-2" v-model="sidebarType" name="sidebarSelect" value="scrollable"
                            @input="changeType($event)">Scrollable</b-form-radio>

                    </div>

                    <!-- Topbar -->
                    <div v-if="layoutType === 'horizontal'">
                        <h6 class="mt-3">Topbar</h6>
                        <hr class="mt-1" />

                        <b-form-radio class="mb-2" v-model="topbar" name="topbarbarSelect" value="dark"
                            @input="changeTopbartype($event)">Dark</b-form-radio>
                        <b-form-radio class="mb-2" v-model="topbar" name="topbarbarSelect" value="light"
                            @input="changeTopbartype($event)">Light</b-form-radio>
                        <b-form-radio class="mb-2" v-model="topbar" name="topbarbarSelect" value="colored"
                            @input="changeTopbartype($event)">Colored</b-form-radio>
                        <b-form-radio class="mb-2" v-model="topbar" name="topbarbarSelect" value="scrollable"
                            @input="changeTopbartype($event)">Scrollable</b-form-radio>

                    </div>

                    <h6 class="mt-3">Preloader</h6>
                    <hr class="mt-1" />

                    <b-form-radio class="mb-2" v-model="loader" name="loaderbarSelect" value="true" @input="changeloader(true)">Enable</b-form-radio>
                    <b-form-radio class="mb-2" v-model="loader" name="loaderbarSelect" value="false" @input="changeloader(false)">Disable</b-form-radio>
                </div>
                <!-- Settings -->
                <h6 class="text-center mb-0">Choose Mode</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <a href="javascript: void(0);" @click="changeLayoutMode('default')">
                            <img :src="layout1" class="img-fluid img-thumbnail" alt />
                        </a>
                    </div>

                    <div class="mb-2">
                        <a href="javascript: void(0);" @click="changeLayoutMode('dark')">
                            <img :src="layout2" class="img-fluid img-thumbnail" alt />
                        </a>
                </div>

            </div>
        </simplebar>
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
</div></template>

<style lang="scss"></style>
