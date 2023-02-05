import axios from "axios";
import {API_USERS} from "../config/apiUrls";

const getUsers = async () => {
    return await axios.get(API_USERS)
        .then(response => response.data)
        .catch(error => console.log(error))
}

const getUser = async (id) => {
    return await axios.get(API_USERS + id)
        .then(response => response.data)
        .catch(error => console.log(error))
}

const updateUser = async ({data, id}) => {
    return await axios.patch(API_USERS + id, data, {
        headers: {
            'Content-Type': 'application/merge-patch+json'
        }
    })
        .then(response => response)
}

const updateUserPicture = async ({data, id}) => {
    return await axios.post(API_USERS + id + "/image", data,
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => response)
}

export default {
    getUsers, getUser, updateUser, updateUserPicture
}