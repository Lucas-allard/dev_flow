import React from 'react';
import './sidebarChannels.scss';
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import AddIcon from "@mui/icons-material/Add";


const SidebarChannels = ({channelsHeading, children, addChannel}) => {
    return (
        <div className="sidebar__channels">
            <div className="sidebar__channelsHeader">
                <div className="sidebar__header">
                    <ExpandMoreIcon/>
                    <h4>{channelsHeading}</h4>
                </div>
                <AddIcon className="sidebar__addChannel" onClick={() => addChannel}/>
            </div>

            {children}
        </div>
    );
}

export default SidebarChannels;