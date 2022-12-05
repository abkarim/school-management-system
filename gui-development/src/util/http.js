import axios from "axios";

const productionURL = '/api';
const devURL = 'http://localhost/api';

export default axios.create({
    baseURL: process.env.NODE_ENV === 'production' ? productionURL : devURL,
    withCredentials: true
});