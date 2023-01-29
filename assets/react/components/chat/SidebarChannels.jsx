import React, {useEffect, useState} from 'react';
import './sidebarChannels.scss';
import KeyboardArrowRightIcon from '@mui/icons-material/KeyboardArrowRight';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import AddIcon from "@mui/icons-material/Add";
import {onSnapshot} from "firebase/firestore";
import SidebarChannel from "./SidebarChannel";
import {useDispatch, useSelector} from "react-redux";
import {setChannel} from "../../features/channel/channelSlice";
import {selectUser} from "../../features/user/userSlice";
import channelsAPI from "../../services/channelsAPI";


const SidebarChannels = ({categoryName, categoryId}) => {
    const [channels, setChannels] = useState([]);
    const [expandChannels, setExpandChannels] = useState(false);
    const dispatch = useDispatch();
    const user = useSelector(selectUser);

    useEffect(() => {
        getChannels()
    }, [])

    const getChannels = async () => {
        onSnapshot(channelsAPI.getChannels(categoryId), (querySnapshot) => {
            setChannels([]);
            querySnapshot.forEach((doc) => {
                setChannels(
                    (channel) => [
                        ...channel,
                        {
                            id: doc.id,
                            name: doc.data().name
                        }
                    ]
                )
            });
        });
    }

    const handleAddChannel = async (categoryId) => {
        const channel = prompt('Saisir de le nom du nouveau channel');
        try {
            await channelsAPI.addChannel(categoryId, channel)
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    const handleChangeChannel = (channelName, channelId) => {
        dispatch(setChannel({
            id: channelId,
            name: channelName,
            categoryId: categoryId
        }))
    }

    return (
        <div className="sidebar__channels">
            <div className="sidebar__channelsHeader" onClick={() => setExpandChannels(!expandChannels)}>
                <div className="sidebar__header">
                    {!expandChannels &&
                        <KeyboardArrowRightIcon/>
                    }
                    {expandChannels &&
                        <KeyboardArrowDownIcon/>
                    }
                    <h4>{categoryName}</h4>
                </div>
                {user?.roles.includes('ROLE_ADMIN') && <AddIcon className="sidebar__addChannel" onClick={() => handleAddChannel(categoryId)}/>}
            </div>

            <div className="sidebar__channelsList">
                {expandChannels && channels && channels.map((channel) =>
                    <SidebarChannel
                        channelName={channel.name}
                        id={channel.id}
                        onHandleChangeChannel={handleChangeChannel}
                        key={channel.id}
                    />
                )}

            </div>
        </div>
    );
}

export default SidebarChannels;