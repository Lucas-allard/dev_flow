import React from 'react';
import {Provider} from "react-redux";
import {store} from '../store/store';
import Router from "../routes/router";

function App({user}) {
    return (
        <Provider store={store}>
            <Router user={user} />
        </Provider>
    );
}

export default App;