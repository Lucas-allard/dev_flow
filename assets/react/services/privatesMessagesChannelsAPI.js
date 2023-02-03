import {collection, orderBy, query, where} from "firebase/firestore";
import {db} from "../../firebase";
import axios from "axios";
import {API_SEND_PRIVATE_MESSAGE} from "../config/apiUrls";

const getPrivatesMessagesChannels = (user) => {

    return query(
        collection(db, `privatesMessages`),
        where('participants', 'array-contains', user),
        orderBy("timestamp", "asc")
    );
}

const getPrivatesMessages = (user, otherUser) => {
    return query(
        collection(db, `privatesMessages`),
        where('participants', "array-contains", otherUser || user),
        orderBy("timestamp", "asc")
    )
}

const addMessage = async (data) => {
    return axios
        .post(API_SEND_PRIVATE_MESSAGE, data, {
            headers: {
                'content-type': 'application/json',
            }
        })
        .then(response => response)
        .catch(error => error);
}

export default {
    getPrivatesMessagesChannels, getPrivatesMessages, addMessage
}