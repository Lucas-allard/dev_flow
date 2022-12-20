import React, {useEffect} from 'react';
import {Provider} from "react-redux";
import {store} from '../store/store';
import ChatPage from "../components/ChatPage";


function ChatApp({user}) {


    return (
        <Provider store={store}>
            <ChatPage user={JSON.parse(user)}/>
        </Provider>
    );
}

export default ChatApp;