import {configureStore} from '@reduxjs/toolkit'
import userReducer from "../features/user/userSlice";
import channelReducer from "../features/channel/channelSlice";
import dashboardReducer from "../features/dashboard/dashboardSlice";
import searchReducer from "../features/search/searchSlice";
import privateMessageReducer from "../features/privateMessage/privateMessageSlice";


export const store = configureStore({
    reducer: {
        user: userReducer,
        channel: channelReducer,
        dashboard: dashboardReducer,
        search: searchReducer,
        privateMessage: privateMessageReducer,
    },
    middleware: (getDefaultMiddleware) => getDefaultMiddleware({
        serializableCheck: false,
    })
})
