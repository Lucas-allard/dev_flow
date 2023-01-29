import React, {useEffect} from 'react';
import SidebarChat from "../components/chat/SidebarChat";
import Chat from "../components/chat/Chat";
import './chatPage.scss';
import {isDisplayUsersList, login, logout, setUsersList} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import UsersList from "../components/chat/UsersList";


const ChatPage = ({user, users}) => {
    const isActiveUsersList = useSelector(isDisplayUsersList)
    const dispatch = useDispatch();

    useEffect(() => {
        console.log(user)
        if (!user) {
            dispatch(logout);
        }
        dispatch(login(user))
    }, [user])


    useEffect(() => {
        dispatch(setUsersList(users))
    }, [users])

    return (
        <div className="chat__page">
            <SidebarChat/>
            <Chat/>
            {isActiveUsersList &&
                <UsersList/>
            }
        </div>
    );
}

export default ChatPage;

