import {createSlice} from '@reduxjs/toolkit'

// Define a type for the slice state


// Define the initial state using that type
const initialState = {
    id: "",
    name: "",
}

export const channelSlice = createSlice({
    name: 'channel',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        setChannel: (state, action) => {
            state.channel = action.payload
        },
    }
})

export const {setChannel} = channelSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectChannel = (state) => state.channel.channel

export default channelSlice.reducer