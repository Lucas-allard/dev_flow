import React, {useEffect, useState} from 'react';
import {Provider} from "react-redux";
import {store} from '../store/store';
import ChatPage from "../components/ChatPage";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import HomePage from "../components/HomePage";

function App({user, users}) {
    return (
        <Provider store={store}>
            <BrowserRouter>
                <Routes>
                    <Route path='/' element={<HomePage/>}/>
                    {user &&
                        <Route
                            path='/chat'
                            element={
                                <ChatPage
                                    user={JSON.parse(user)}
                                    users={JSON.parse(users)}
                                />
                            }
                        />
                    }
                </Routes>
            </BrowserRouter>
        </Provider>
    );
}

export default App;