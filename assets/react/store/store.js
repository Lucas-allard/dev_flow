import {configureStore} from '@reduxjs/toolkit'
import userReducer from "../features/user/userSlice";
import channelReducer from "../features/channel/channelSlice";
import searchReducer from "../features/search/searchSlice";


export const store = configureStore({
    reducer: {
        user: userReducer,
        channel: channelReducer,
        search: searchReducer,
    }
})
