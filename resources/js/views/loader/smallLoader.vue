<template>
    <div class="loader">
      <div class="spinner"></div>
      <p class="loading-text">کمی صبر نمائید...</p>
    </div>
  </template>
  
  <script>
  export default {
    name: "smallLoader",
  };
  </script>
  
  <style scoped>
  .loader {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 40vh;
  }
  
  .spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: #4a90e2;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
  }
  
  .loading-text {
    margin-top: 20px;
    font-size: 20px;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #555;
  }
  
  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
  </style>
  