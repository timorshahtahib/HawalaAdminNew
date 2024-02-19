// // src/services/api.js

// import axios from 'axios';

// const api = axios.create({
//     baseURL: '/api',
//     headers: {
//         Accept: "application/json",
//         "Content-Type": "application/json",
//         responseType: "json",
//     },
// });

// // Add a request interceptor to include the bearer token
// // api.defaults.headers.common['Authorization'] = localStorage.getItem('user');
// // api.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// api.interceptors.request.use(config => {
//     const token = localStorage.getItem('user'); // Retrieve your token from localStorage or any other storage
//     const jsonObject = JSON.parse(token);
//     const tokenValue = jsonObject.token;


//     if (token) {
//         config.headers.Authorization = `Bearer ${tokenValue}`;
//     }

//     return config;
// }, error => {
//     if (error.response.status === 401) {
//         // Redirect to login page
//         router.push('/login');
//     }
//     return Promise.reject(error);
// });

// export default api// src/services/api.js

import axios from 'axios';
import router from '../router'; // Import the router instance from your router file

const api = axios.create({
    baseURL: '/api',
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        responseType: "json",
    },
});

// Add a request interceptor to include the bearer token
api.interceptors.request.use(config => {
    const token = localStorage.getItem('user');
    if (token) {
        const jsonObject = JSON.parse(token);
        const tokenValue = jsonObject.token;
        config.headers.Authorization = `Bearer ${tokenValue}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// Add a response interceptor to handle 401 errors
api.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            // Redirect to login page
            router.push('/login');
        }
        return Promise.reject(error);
    }
);

export default api;