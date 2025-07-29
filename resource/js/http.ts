import axios, {AxiosResponse, RawAxiosRequestHeaders} from "axios";


let headers: RawAxiosRequestHeaders = {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
};
const token = localStorage.getItem('token');

if (token) {
    headers['Authorization'] = `Bearer ${token}`;
}

const customHttp = axios.create({
        baseURL: 'http://localhost:8888/api',
        headers,

    })
;

export interface IError {
    message: string;
    code?: number;
    errors?: Record<string, string>;
    success: boolean
}

export interface IResponse<T> {
    message: string;
    success: boolean;
    data: T;
}

export type HttpMethod = 'GET' | 'POST' | 'PATCH' | 'PUT' | 'DELETE';

customHttp.interceptors.response.use(function (response): AxiosResponse<IResponse<any>> {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    return response;
}, function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    return Promise.reject(error.response.data as IError);
});

export default async function http<T>(url: string, method: HttpMethod = 'GET', data = {}): Promise<[IResponse<T> | null, IError | null]> {
    try {
        if (method === 'POST') {
            const response = await customHttp.post<IResponse<T>>(url, data);
            return [response.data, null];
        }
        if (method === 'PUT') {
            const response = await customHttp.put<IResponse<T>>(url, data);
            return [response.data, null];
        }
        if (method === 'PATCH') {
            const response = await customHttp.patch<IResponse<T>>(url, data);
            return [response.data, null];
        }
        if (method === 'DELETE') {
            const response = await customHttp.delete<IResponse<T>>(url, data);
            return [response.data, null];
        }
        const response = await customHttp.get<IResponse<T>>(url, {params: data});

        return [response.data, null];
    } catch (e) {
        const error = e as IError;
        if (axios.isAxiosError(error)) {
            return [null, error.response?.data as IError || {message: 'Unknown error', success: false}];
        }
        return [null, {message: error?.message ?? 'Unknown error', success: false}];
    }

}
