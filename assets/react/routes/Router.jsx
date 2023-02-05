import React, {useEffect} from 'react';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import HomePage from "../layout/HomePage";
import DashboardPage from "../layout/DashboardPage";
import {getUserData, loginCheck} from "../features/user/userSlice";
import {useDispatch} from "react-redux";
import ChatPage from "../layout/ChatPage";
import authAPI from "../services/authAPI";

function Router({user}) {
    const {email, id} = user;
    const dispatch = useDispatch();

    useEffect(() => {
        console.log(email, id)
        if (!id || !email) {
            return;
        }

        if (authAPI.isAuth()) {
            return;
        }


        dispatch(loginCheck({email: email, id: id}))
    }, [id, email])


    useEffect(() => {
        if (!id) {
            return;
        }
        dispatch(getUserData(id))
    }, [id])


    return (
        <BrowserRouter>
            <Routes>
                <Route path='/' element={<HomePage/>}/>
                {/*<Route*/}
                {/*    path='/chat'*/}
                {/*    element={*/}
                {/*        <ChatPage/>*/}
                {/*    }*/}
                {/*/>*/}
                <Route
                    path='/dashboard'
                    element={
                        <DashboardPage/>
                    }
                />
            </Routes>
        </BrowserRouter>
    )
        ;
}

export default Router;