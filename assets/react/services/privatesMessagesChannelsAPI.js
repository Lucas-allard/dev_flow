import {collection, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";
import axios from "axios";

const getPrivatesMessagesChannels = (userFullname) => {
    return query(
        collection(db, `categoriesChannels`),
        where()
        orderBy("timestamp", "asc")
    );
}

const addMessage = async (user, data) => {
    axios.defaults["x-csrf-token"] = user.csrfToken;
    const options = {
        method: 'POST',
        headers: {
            'content-type': 'application/json',
        },
        data: JSON.stringify(data),
        url: "https://localhost:8000/chat/send",
    };
    return await axios(options);
}

export default {
    getChannelsMessages, addMessage
}