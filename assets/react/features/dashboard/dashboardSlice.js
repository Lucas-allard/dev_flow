import {createSlice} from '@reduxjs/toolkit'

// Define a type for the slice state


// Define the initial state using that type
const initialState = {
    route: 'Profil'
}

export const dashboardSlice = createSlice({
    name: 'dashboard',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        setRoute: (state, action) => {
            state.route = action.payload
        },
    }
})

export const {setRoute} = dashboardSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectRoute = (state) => state.dashboard.route

export default dashboardSlice.reducer