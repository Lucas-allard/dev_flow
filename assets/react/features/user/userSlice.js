import {createSlice} from '@reduxjs/toolkit'

const initialState = {}

export const userSlice = createSlice({
    name: 'user',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        login: (state, action) => {
            state.user = action.payload
        },
        logout: (state) => {
            state.user = null
        },
        setUsersList: (state, action) => {
            state.users = action.payload
        }
    }
})

export const {
    login,
    logout,
    setUsersList
} = userSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectUser = (state) => state.user.user
export const selectUsers = (state) => state.user.users

export default userSlice.reducer