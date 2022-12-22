import {createSlice} from '@reduxjs/toolkit'

const initialState = {
    isSelectPrivateMessage: false
}

export const privateMessageSlice = createSlice({
    name: 'privateMessage',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        setIsSelectPrivateMessage: (state, action) => {
            console.log(state)
            state.isSelectPrivateMessage = action.payload
            console.log(state)
        }
    }
})

export const {
    setIsSelectPrivateMessage
} = privateMessageSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectIsPrivateMessage = (state) => state.privateMessage.isSelectPrivateMessage

export default privateMessageSlice.reducer