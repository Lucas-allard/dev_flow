import React from 'react';
import {Provider} from "react-redux";
import {store} from '../store/store';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import ChatPage from "../layout/ChatPage";
import HomePage from "../layout/HomePage";
import DashboardPage from "../layout/DashboardPage";

function App({user, users}) {
    return (
        <Provider store={store}>
            <BrowserRouter>
                <Routes>
                    <Route path='/' element={<HomePage/>}/>
                    {user &&
                        <>
                            <Route
                                path='/chat'
                                element={
                                    <ChatPage
                                        user={user}
                                        users={users}
                                    />
                                }
                            />
                            <Route
                                path='/dashboard'
                                element={
                                    <DashboardPage
                                        user={user}
                                    />
                                }
                            />
                        </>
                    }
                </Routes>
            </BrowserRouter>
        </Provider>
    );
}

export default App;