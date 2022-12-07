import React from 'react';
import './sidebar.scss'
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import Avatar from '@mui/material/Avatar';
import SidebarChannel from "./SidebarChannel";
import SidebarChannels from "./SidebarChannels";

function Sidebar() {
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
                            <SidebarChannel channel="Blabla"/>
                            <SidebarChannel channel="Projet"/>
                            <SidebarChannel channel="Emploi"/>
                        </div>
                    }
                />

                <SidebarChannels
                    channelsHeading="HTLM & CSS"
                    children={
                        <div className="sidebar__channelsList">
                            <SidebarChannel channel="Html"/>
                            <SidebarChannel channel="Css"/>
                        </div>
                    }
                />

                <SidebarChannels
                    channelsHeading="Front-end"
                    children={
                        <div className="sidebar__channelsList">
                            <SidebarChannel channel="Javascript"/>
                            <SidebarChannel channel="React"/>
                            <SidebarChannel channel="Angular"/>
                            <SidebarChannel channel="Vue JS"/>
                        </div>
                    }
                />

                <SidebarChannels
                    channelsHeading="Back-end"
                    children={
                        <div className="sidebar__channelsList">
                            <SidebarChannel channel="PHP"/>
                            <SidebarChannel channel="Symfony"/>
                            <SidebarChannel channel="Laravel"/>
                        </div>
                    }
                />

            </div>

            <div className="sidebar__profile">
                <Avatar/>
                <div className="sidebar__profileInfo">
                    <h3>Lucas</h3>
                    <p>#EEE2SDQ5</p>
                </div>
            </div>
        </div>
    );
}

export default Sidebar;