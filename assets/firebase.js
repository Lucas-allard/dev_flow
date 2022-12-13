import {initializeApp} from "firebase/app";
import {getFirestore} from "firebase/firestore";

// TODO: Replace the following with your app's Firebase project configuration
// See: https://firebase.google.com/docs/web/learn-more#config-object
const firebaseConfig = {
    apiKey: "AIzaSyAaPQ5VhDZ9r6OyFFo7x8lp0ZLbI8do7Ds",
    authDomain: "dev-flow-chat.firebaseapp.com",
    databaseURL: "https://dev-flow-chat-default-rtdb.europe-west1.firebasedatabase.app",
    projectId: "dev-flow-chat",
    storageBucket: "dev-flow-chat.appspot.com",
    messagingSenderId: "953323262229",
    appId: "1:953323262229:web:a23c6b92e79bc7842d591c"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);


// Initialize Cloud Firestore and get a reference to the service
const db = getFirestore(app);

export default db