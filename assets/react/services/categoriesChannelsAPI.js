import {addDoc, collection, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";

const getCategoriesChannels = () => {
    return query(
        collection(db, `categoriesChannels`),
        orderBy("timestamp", "asc")
    );
}

const addCategoryChannel = async (category) => {
    return await addDoc(collection(db, "categoriesChannels"), {
        name: category,
        timestamp: new Date()
    });

}

export default {
    getCategoriesChannels, addCategoryChannel
}