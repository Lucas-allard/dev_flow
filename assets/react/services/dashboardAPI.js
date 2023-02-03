import {API_UPDATE_PROFILE} from "../config/apiUrls";
import axios from "axios";

const updateProfile = (data) => {
    return axios
        .put(API_UPDATE_PROFILE, data, {
            headers: {
                'content-type': 'application/json',
            }
        })
        .then(response => console.log(response))
        .catch(error => console.log(error.response));
}

export default {
    updateProfile
}