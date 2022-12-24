import React, {useEffect} from 'react';
import Sidebar from "../components/Sidebar";
import Chat from "./Chat";
import './chatPage.scss';
import {login, logout, selectUsers, setUsersList} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import {selectIsPrivateMessage} from "../features/privateMessage/privateMessageSlice";
import UsersList from "../components/UsersList";


const ChatPage = ({user, users}) => {
    const dispatch = useDispatch();

    useEffect(() => {
        if (!user) {
            dispatch(logout);
        }
        dispatch(login(user))
    }, [user])


    useEffect(() => {
        dispatch(setUsersList(users))
    }, [users])

    return (
        <main>
            <div className="chat__page">
                <Sidebar/>
                <Chat/>
                <UsersList/>
            </div>
        </main>

    );
}

export default ChatPage;

