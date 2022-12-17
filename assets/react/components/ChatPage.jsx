import React, {useEffect} from 'react';
import Sidebar from "./Sidebar";
import Chat from "./Chat";
import './chatPage.scss';
import {login, logout} from "../features/user/userSlice";
import {useDispatch} from "react-redux";


const ChatPage = (user) => {
    const dispatch = useDispatch();

    useEffect(() => {
        // console.log(user.user)
        if (!user) {
            dispatch(logout);
        }
        dispatch(login(user.user))
    }, [user])


    return (
        <main>
            <div className="chat__page">
                <Sidebar/>
                <Chat/>
            </div>
        </main>

    );
}

export default ChatPage;

