import axios from "axios";
import {API_LOGIN} from "../config/apiUrls";
import jwtDecode from "jwt-decode";

const setAxiosToken = (token) => {
    axios.defaults.headers["Authorization"] = "Bearer " + token;
}
const authenticate = (data) => {
    return axios
        .post(API_LOGIN, data, {
            "Content-Type": "application/ld+json"
        })
        .then(response => response.data.token)
        .then(token => {
            window.localStorage.setItem("token", token);
            setAxiosToken(token);
            return jwtDecode(token);
        });
};

const logout = () => {
    window.localStorage.removeItem("token");
    delete axios.defaults.headers["Authorization"];
};

const isAuth = () => {
    const token = window.localStorage.getItem("token");
    if (token) {
        const {exp: expiration} = jwtDecode(token);
        if (expiration * 1000 > new Date().getTime()) {
            setAxiosToken(token);
            return true;
        } else {
            logout();
            return false;
        }
    }
};
export default {
    authenticate, logout, isAuth
}