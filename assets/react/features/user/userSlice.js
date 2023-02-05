import {createAsyncThunk, createSlice} from '@reduxjs/toolkit'
import userAPI from "../../services/userAPI";
import authAPI from "../../services/authAPI";


export const loginCheck = createAsyncThunk(
    'user/loginCheck',
    async (credentials) => {
        return await authAPI.authenticate(credentials)
    }
)

export const getUsersData = createAsyncThunk(
    'user/getUsersList',
    async () => {
        return await userAPI.getUsers()
    }
)

export const getUserData = createAsyncThunk(
    'user/getUserData',
    async (id) => {
        return await userAPI.getUser(id)
    }
)

export const updateUserData = createAsyncThunk(
    'user/updateUserData',
    async (payload) => {
        return await userAPI.updateUser(payload)
    }
)

export const updateUserPicture = createAsyncThunk(
    'user/updateUserPicture',
    async (payload) => {
        return await userAPI.updateUserPicture(payload)
    }
)


const initialState = {}

export const userSlice = createSlice({
    name: 'user',
    // `createSlice` will infer the state type from the `initialState` argument
    initialState,
    reducers: {
        displayUsersList: (state, action) => {
            state.isDisplayUsersList = action.payload
        },
        chooseUserProfil: (state, action) => {
            state.selectedUser = action.payload
        }
    },
    extraReducers: (builder) => {
        builder
            .addCase(getUserData.fulfilled, (state, action) => {
                state.user = action.payload
            })
            .addCase(getUserData.rejected, (state) => {
                state.user = null
            })
            .addCase(updateUserData.fulfilled, (state, action) => {
                state.user = action.payload.data
            })
            .addCase(updateUserPicture.fulfilled, (state, action) => {
                state.user = action.payload.data
            })
            .addCase(getUsersData.fulfilled, (state, action) => {
                state.users = action.payload
            })
    }
})

export const {
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