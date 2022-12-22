import {addDoc, collection, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";

const getChannels = (categoryId) => {
    return query(
        collection(db, `categoriesChannels/${categoryId}/channels`),
        orderBy("timestamp", "asc")
    );
}

const addChannel = async (categoryId, channel) => {
    return await addDoc(collection(db, `categoriesChannels/${categoryId}/channels`), {
        name: channel,
        timestamp: new Date()
    })
}

export default {
    getChannels, addChannel
}