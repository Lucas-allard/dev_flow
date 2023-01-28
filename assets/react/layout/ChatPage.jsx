import React, {useEffect} from 'react';
import Sidebar from "../components/Sidebar";
import Chat from "./Chat";
import './chatPage.scss';
import {isDisplayUsersList, login, logout, selectUsers, setUsersList} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import UsersList from "../components/UsersList";


const ChatPage = ({user, users}) => {
    const isUsersList = useSelector(isDisplayUsersList)
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
        <div className="chat__page">
            <Sidebar/>
            <Chat/>
            {isUsersList &&
                <UsersList/>
            }
        </div>
    );
}

export default ChatPage;

