import React from 'react';
import {Provider} from "react-redux";
import {store} from '../store/store';
import Sidebar from "../components/Sidebar";
import Chat from "../components/Chat";
import {createRoot} from "react-dom/client";
import './chatPage.scss';

function ChatPage() {
    return (
        <main>
            <div className="chat__page">
                <Sidebar/>
                <Chat/>
            </div>
        </main>


    );
}


const rootAppElement = document.getElementById("chat");
const rootApp = createRoot(rootAppElement);
rootApp.render(
    <Provider store={store}>
        <ChatPage/>
    </Provider>
)