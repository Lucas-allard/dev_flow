import {createSlice} from '@reduxjs/toolkit'

// Define a type for the slice state


// Define the initial state using that type
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
        }
    }
})

export const {login, logout} = userSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectUser = (state) => state.user.user

export default userSlice.reducer