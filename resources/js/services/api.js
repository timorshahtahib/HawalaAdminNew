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
        } else {
            if (error.response.status === 500) {
                // Redirect to another page
                router.push('/serror'); // Adjust the route according to your setup
            }
        }
        return Promise.reject(error.message);
    }
);

export default api;