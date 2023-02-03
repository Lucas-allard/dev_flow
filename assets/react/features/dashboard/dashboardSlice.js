import {createAsyncThunk, createSlice} from '@reduxjs/toolkit'
import dashboardAPI from "../../services/dashboardAPI";

// Define a type for the slice state
const updateProfile = createAsyncThunk(
    'dashboard/updateProfile',
    async (data) => {
        const response = await dashboardAPI.updateProfile(data)
        return response.data
    }
)

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
    },
    extraReducers: {
        [updateProfile.fulfilled]: (state, action) => {
            state.profile = action.payload
        },
        [updateProfile.rejected]: (state, action) => {
            return {...state, error: action.payload}
        },
        [updateProfile.pending]: (state, action) => {
            return {...state, loading: true}
        }
    }
})

export const {setRoute} = dashboardSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectRoute = (state) => state.dashboard.route

export default dashboardSlice.reducer