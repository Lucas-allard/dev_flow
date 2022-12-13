import React, {useEffect, useState} from 'react';
import './sidebar.scss'
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import SidebarChannel from "./SidebarChannel";
import SidebarChannels from "./SidebarChannels";
import {selectUser} from "../features/user/userSlice";
import {useSelector} from "react-redux";
import db from "../../firebase";


const Sidebar = () => {
    const user = useSelector(selectUser);
    const [channels, setChannels] = useState([]);

    useEffect(() => {
        db.collection("channels").onSnapshot((snapshot) => (
            setChannels(
                // @ts-ignore
                snapshot.docs.map(doc => ({
                        id: doc.id,
                        channel: doc.data()
                    }
                ))
            )
        ))
    }, [])

    const handleAddChannel = () => {
        const channelName = prompt('saisir le nom du nouveau channel');

        if (channelName) {
            db.collection("channels").add({
                channelName: channelName
            });
        }
    }

    return (
        <div className="sidebar">
            <div className="sidebar__top">
                <h3>Labo Chat</h3>
                <ExpandMoreIcon/>
            </div>

            <div className="sidebar__middle">
                <SidebarChannels
                    channelsHeading="Général"
                    children={
                        <div className="sidebar__channelsList">
                            {channels.map((channel, id) =>
                                <SidebarChannel
                                    channelName={channel.channelName} channelId={channel.channelId}/>
                            )}
                        </div>
                    }
                    addChannel={handleAddChannel}/>
            </div>

            {/*{user &&*/}
            {/*    <div className="sidebar__profile">*/}

            {/*        <Avatar alt="profil picture" src={user.profilPicture}/>*/}
            {/*        <div className="sidebar__profileInfo">*/}
            {/*            <h3>{user.fullname}</h3>*/}
            {/*            <p>#{user.id.substring(0, 8)}</p>*/}
            {/*        </div>*/}
            {/*    </div>*/}
            {/*}*/}
        </div>
    );
}

export default Sidebar;