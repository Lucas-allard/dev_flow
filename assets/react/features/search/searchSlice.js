import {createSlice} from '@reduxjs/toolkit'

// Define a type for the slice state


// Define the initial state using that type
const initialState = {
  value: "",
}

export const searchSlice = createSlice({
    name: 'search',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        setSearch: (state, action) => {
            state.search = action.payload
        },
    }
})

export const {setSearch} = searchSlice.actions

// Other code such as selectors can use the imported `RootState` type
export const selectSearch = (state) => state.search.search

export default searchSlice.reducer