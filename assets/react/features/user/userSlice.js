import {createSlice} from '@reduxjs/toolkit'

const initialState = {
}

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
        },
        chooseUserProfil: (state, action) => {
            state.selectedUser = action.payload
        }
    }
})

export const {
    login,
    logout,
    chooseUserProfil,
    setUsersList
} = userSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectUser = (state) => state.user.user
export const selectUsers = (state) => state.user.users
export const selectUserProfil = (state) => state.user.selectedUser

export default userSlice.reducer