// src/services/axios.js
import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: "http://127.0.0.1:8000/api/",
});

// Add a request interceptor
axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
});

axiosInstance.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            // Handle 401 Unauthorized here, e.g. log out and redirect to login page
            localStorage.removeItem('token');
            // Redirect to the login page
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Custom GET request with parameters
export const customGet = (url, successCallback, failureCallback, params = {}) => {
    return axiosInstance.get(url, { params })
        .then(response => successCallback ? successCallback(response) : response)
        .catch(error => failureCallback ? failureCallback(error) : error);
};

// Custom POST request with parameters
export const customPost = (url, data, successCallback, failureCallback) => {
    return axiosInstance.post(url, data)
        .then(response => successCallback(response))
        .catch(error => failureCallback(error));
};

// Custom PUT request with parameters
export const customPut = (url, data, successCallback, failureCallback) => {
    return axiosInstance.put(url, data)
        .then(response => successCallback(response))
        .catch(error => failureCallback(error));
};

// Custom DELETE request with parameters
export const customDelete = (url, successCallback, failureCallback) => {
    return axiosInstance.delete(url)
        .then(response => successCallback(response))
        .catch(error => failureCallback(error));
};

export default axiosInstance;
