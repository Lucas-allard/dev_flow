import React, {useEffect} from 'react';
import Sidebar from "./Sidebar";
import Chat from "./Chat";
import './chatPage.scss';
import {login, logout, selectUsers, setUsersList} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import {selectIsPrivateMessage} from "../features/privateMessage/privateMessageSlice";


const ChatPage = ({user, users}) => {
    const isSelectPrivateMessage = useSelector(selectIsPrivateMessage)
    const _users = useSelector(selectUsers)
    const dispatch = useDispatch();

    useEffect(() => {
        if (!user) {
            dispatch(logout);
        }
        dispatch(login(user))
    }, [user])


    useEffect(() => {
        console.log(users)
        dispatch(setUsersList(users))
    }, [users])

    useEffect(() => {
        console.log(_users)
    }, [_users])


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

