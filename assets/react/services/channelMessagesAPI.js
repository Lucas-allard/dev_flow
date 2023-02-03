import {collection, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";
import axios from "axios";
import {API_SEND_MESSAGE} from "../config/apiUrls";

const getChannelsMessages = (categoryId, channelId) => {
    return query(
        collection(db, `categoriesChannels/${categoryId}/channels/${channelId}/messages`),
        orderBy("timestamp", "asc")
    );
}

const addMessage = async (data) => {
    return axios
        .put(API_SEND_MESSAGE, data, {
        headers: {
            'content-type': 'application/json',
        }
    })
        .then(response => response)
        .catch(error => error.response);
}

export default {
    getChannelsMessages, addMessage
}