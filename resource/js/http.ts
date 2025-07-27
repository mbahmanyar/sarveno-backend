import axios from "axios";

const http = axios.create({
    baseURL: 'http://localhost:8888/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },

});

http.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    console.log('response', response)
    return response;
}, function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    console.log('error', error)
    return Promise.reject(error.response.data);
});

export default http;