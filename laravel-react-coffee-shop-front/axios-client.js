import axios from 'axios';

const axiosClient = axios.create({
    baseURL: `${import.meta.env.VITE_BASE_URL_APP}/api`,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: true
});

axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('ACCESS_TOKEN');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrfToken && config.method !== 'get') {
        config.headers['X-CSRF-TOKEN'] = csrfToken;
    }
    
    return config;
});

axiosClient.interceptors.response.use(
    (response) => response,
    (error) => {
        const { response } = error;
        if (response?.status === 401) {
            localStorage.removeItem('ACCESS_TOKEN');
        }
        return Promise.reject(error);
    }
);

export default axiosClient;