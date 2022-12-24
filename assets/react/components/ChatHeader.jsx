import React, {useEffect, useState} from 'react';
import "./chatHeader.scss";
import NotificationsIcon from '@mui/icons-material/Notifications';
import EditLocationIcon from '@mui/icons-material/EditLocation';
import PeopleAltIcon from '@mui/icons-material/PeopleAlt';
import SearchIcon from '@mui/icons-material/Search';
import SendIcon from '@mui/icons-material/Send';
import HelpIcon from '@mui/icons-material/Help';
import {useDispatch} from "react-redux";
import {setSearch} from "../features/search/searchSlice";


const ChatHeader = ({channelName}) => {
    const [searchValue, setSearchValue] = useState("");
    const dispatch = useDispatch();

    const handleChange = (e) => {
        console.log(e.target.value)
        e.preventDefault();
        setSearchValue(e.target.value)
    }

    useEffect(() => {
        if (searchValue.length > 3) {
            dispatch(setSearch({value: searchValue}))
        } else {
            dispatch(setSearch(null))
        }
    }, [searchValue])

    return (
        <div className="chatHeader">
            <div className="chatHeader__left">
                <h3>
                    <span className="chatHeader__hash">
                        #
                    </span>
                    {channelName}
                </h3>
            </div>

            <div className="chatHeader__right">
                <NotificationsIcon/>
                <EditLocationIcon/>
                <PeopleAltIcon/>

                <div className="chatHeader__search">
                    <input placeholder="Search" type="text" onChange={handleChange}/>
                    <SearchIcon/>
                </div>

                <SendIcon/>
                <HelpIcon/>
            </div>
        </div>
    );
}

export default ChatHeader;