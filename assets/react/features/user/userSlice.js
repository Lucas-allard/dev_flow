import {createSlice} from '@reduxjs/toolkit'
import axios from "axios";

const initialState = {}
export const userSlice = createSlice({
    name: 'user',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        login: (state, action) => {
            state.user = action.payload
            axios.defaults["x-csrf-token"] = state.user.csrfToken;
            console.log(state.user.authenticationToken)
            axios.defaults["Authorization"] = "Bearer " + state.user.authenticationToken;
            console.log(axios.defaults)
        },
        logout: (state) => {
            state.user = null
        },
        setUsersList: (state, action) => {
            state.users = action.payload
        },
        displayUsersList: (state, action) => {
            state.isDisplayUsersList = action.payload
        },
        chooseUserProfil: (state, action) => {
            state.selectedUser = action.payload
        }
    },
})

export const {
    login,
    logout,
    chooseUserProfil,
    setUsersList,
    displayUsersList
} = userSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectUser = (state) => state.user.user
export const selectUsers = (state) => state.user.users
export const selectUserProfil = (state) => state.user.selectedUser
export const isDisplayUsersList = (state) => state.user.isDisplayUsersList

export default userSlice.reducer