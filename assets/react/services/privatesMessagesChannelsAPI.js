import {collection, orderBy, query, where} from "firebase/firestore";
import {db} from "../../firebase";
import axios from "axios";

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

const addMessage = async (user, data) => {
    axios.defaults["x-csrf-token"] = user.csrfToken;
    const options = {
        method: 'POST',
        headers: {
            'content-type': 'application/json',
        },
        data: JSON.stringify(data),
        url: "https://localhost:8000/chat/send/private",
    };
    return await axios(options);
}

export default {
    getPrivatesMessagesChannels, getPrivatesMessages, addMessage
}