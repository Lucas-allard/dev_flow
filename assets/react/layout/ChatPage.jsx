import React, {useEffect} from 'react';
import SidebarChat from "../components/chat/SidebarChat";
import Chat from "../components/chat/Chat";
import './chatPage.scss';
import {getUsersData, isDisplayUsersList} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import UsersList from "../components/chat/UsersList";
import userAPI from "../services/userAPI";


const ChatPage = () => {
    const isActiveUsersList = useSelector(isDisplayUsersList)
    const dispatch = useDispatch();
    const getUsersList = () => dispatch(getUsersData())

    useEffect(() => {
        getUsersList();
    }, [])

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

