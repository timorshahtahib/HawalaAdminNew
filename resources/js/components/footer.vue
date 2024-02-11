<template>
  <footer class="footer">
    <div class="container-fluid">
      <div class="row text-center">
        <div class="col-sm-6">
          <div class="text-sm-end d-none d-sm-block ">
            <router-link to="www.asyatelecom.net/">By Asia Telecom{{ new Date().getFullYear() }}</router-link>
            <router-view/>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- end footer -->
</template>
